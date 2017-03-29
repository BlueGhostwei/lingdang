<?php

namespace App\Http\Controllers\Admin;

use App\Models\AclResource;
use App\Models\AclRole;
use App\Models\User;
use Monolog\Handler\NullHandlerTest;
use Redirect;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\AclUser;
use App\Http\Controllers\Controller;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Input;

/**
 * 角色管理
 *
 * Class AclRoleController
 * @package App\Models
 *
 * @author  fengqi <lyf362345@gmail.com>
 * @copyright Copyright (c) 2015 udpower.cn all rights reserved.
 */
class AclRoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$role = (new AclRole())->getRole();
        $role = AclUser::orderBy('id', 'desc')->get();
        return view('Admin.acl.role.index', ['role' => $role]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $resource = (new AclResource())->AclResource;

        //dd($resource);
        return view('Admin.acl.role.form', [
            'resource' => $resource
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $resource = (new AclResource())->AclResource;
        $roleResource = AclRole::where('role', $id)->get()->all();
        return view('Admin.acl.role.show', [
            'role' => $id,
            'resource' => $resource,
            'roleResource' => $roleResource,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $resource = (new AclResource())->AclResource;
        $roleResource = AclRole::where('role', $id)->get(['resource'])->toArray();
        $roleResource = Arr::pluck($roleResource, 'resource');
        return view('Admin.acl.role.form', [
            'role' => $id,
            'resource' => $resource,
            'roleResource' => $roleResource,
        ]);
    }

    //用户列表个体用户权限编辑
    public function user_edit($id)
    {
        //获取用户ID，判断用户角色，拿到角色类型ID
        $user = User::find($id);
        //dd($user);
        $resource = (new AclResource())->AclResource;
        $roleResource = AclRole::where('role', $user->role)
            ->orWhere(['p_role_id'=>$user->role,'user_id'=>$id])
            ->get(['resource'])->toArray();
       // dd($roleResource);
        $roleResource = Arr::pluck($roleResource, 'resource');
        return view('Admin.acl.role.user_role', [
            'role' => $user->role,
            'user' => $user,
            'resource' => $resource,
            'roleResource' => $roleResource,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'resource' => 'required'
        ]);
        /*AclRole::where('role', $id)->orWhere('p_role_id', $id)->delete();*/
        AclRole::where('role', $id)->delete();
        $resource = $request->get('resource');
        $aclRole = new AclRole();
        $data = [];
        foreach ($resource as $item) {
            $item = strtr($item, [' ' => '']);
            if (is_int(stripos($item, ','))) {
                $item = explode(',', $item);
                foreach ($item as $item2) {
                    $data[] = ['role' => $id, 'resource' => $item2];
                }
            } else {
                $data[] = ['role' => $id, 'resource' => $item];
            }
        }
        $aclRole->insert($data);

        return \Redirect::route('acl.role.index')->withErrors('更新角色权限成功');
    }

    /**
     * @param Request $request
     * @param $id
     * @return $this
     * @throws \Exception
     *
     */
    public function user_role_update(Request $request, $id)
    {
        $aclRole = new AclRole();
        $resource = $request->get('resource');
        $user = User::find($id);
        $user_role = AclRole::where('role', $user->role)
            ->orWhere(['p_role_id'=>$user->role,'user_id'=>$id])->get()->toArray();
        $user_role1 = array();//旧权限
        foreach ($user_role as $key => $vel) {
            $user_role1[$key] = $vel['resource'];
        }
        $data = [];//添加的新权限
        foreach ($resource as $item) {
            $item = strtr($item, [' ' => '']);
            if (is_int(stripos($item, ','))) {
                $item = explode(',', $item);
                foreach ($item as $item2) {
                    $data[] = ['role' => $user->role, 'resource' => $item2];
                }
            } else {
                $data[] = ['role' => $user->role, 'resource' => $item];
            }
        }
        //查找差值，添加user_id入库
        $dat3 = array();
        foreach ($data as $key => $vel) {
            if (in_array($vel['resource'], $user_role1) == false) {
                $dat3[] = ['role' => NUll,
                    'p_role_id' => $user->role,
                    'resource' => $vel['resource'],
                    'user_id' => $user->id];
            }
        }
        if (!empty($dat3)) {
            $aclRole->insert($dat3);
        } else {
            $data1 = array();
            foreach ($data as $key => $vel) {
                $data1[$key] = $vel['resource'];
            }
            //拿出user_id的权限。对比传过来的权限当中有没有对比的上得。没有就删除。
            $sata = $aclRole->where('user_id', $user->id)->get()->toArray();
            if (!empty($sata)) {
                $old_user_role = array();
                foreach ($sata as $key => $vel) {
                    if (in_array($vel['resource'], $data1) == false) {
                        $old_user_role[] = ['resource' => $vel['resource'],
                            'p_role_id' => $vel['p_role_id'],
                            'user_id' => $vel['user_id']];
                    }
                }
                if (!empty($old_user_role)) {
                    foreach ($old_user_role as $key => $vel) {
                        $aclRole->where([
                            'resource' => $vel['resource'],
                            'p_role_id' => $vel['p_role_id'],
                            'user_id' => $vel['user_id']])->delete();
                    }
                }
            }
        }
        return Redirect::route('user.index')->withErrors('更新角色权限成功');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */

    /**
     * @param $id
     *
     *
     */


    public function destroy($id)
    {
        //
    }
}
