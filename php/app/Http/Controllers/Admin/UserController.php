<?php

namespace App\Http\Controllers\Admin;

use Auth;
use Input;
use phpDocumentor\Reflection\Types\Null_;
use Redirect;
use Response;
use App\Models\User;
use App\Http\Requests;
use Validator;
use App\Models\SendSMS;
use App\Models\AclUser;
use App\Models\AclRole;
use App\Models\AclResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * 用户相关逻辑: 管理, 个人信息维护, 登入, 登出, 申请加盟(预注册)
 *
 * @package App\Http\Controllers
 *
 * @author fengqi <lyf362345@gmail.com>
 * @copyright Copyright (c) 2015 udpower.cn all rights reserved.
 */
class UserController extends Controller
{

    public function GEt_token(){
        return csrf_token();
    }
    
    /**
     * 用户列表, 排除已经删除的
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = User::orderBy('id', 'desc')->with('loginHistory')->whereNull('deleted_at');

        $keyword = Input::get('keyword');
        if ($keyword) {
            $user = $user->where('id', $keyword)->orWhere('name', 'like', "%$keyword%")->orWhere('email', 'like', "%$keyword%")->orWhere('real_name', 'like', "%$keyword%");
        }

        $user = $user->paginate(10)->appends(['keyword' => $keyword]);
        //dd($user->toArray());
        foreach ($user as $k => $item) {
            if ($item->created_by) {
                $user[$k]['createdBy'] = User::find($item->created_by)->name;
            } else {
                $user[$k]['createdBy'] = 'Admin';
            }
        }
        // dd($user->toArray());
        return view('Admin/user.index', [
            'keyword' => $keyword,
            'user' => $user
        ]);
    }

    /**
     * 已经删除的用户
     *
     * @return \Illuminate\View\View
     */
    public function trash()
    {


        $user = User::orderBy('deleted_at', 'desc')->with('loginHistory')->whereNotNull('deleted_at');
        $keyword = Input::get('keyword');
        if ($keyword) {
            $user = $user->where('id', $keyword)->orWhere('name', $keyword)->orWhere('email', $keyword);
        }

        $user = $user->paginate(10);

        return view('Admin/user.trash', [
            'keyword' => $keyword,
            'user' => $user
        ]);
    }

    /**
     * 恢复用户
     *
     * @param $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function restore($id)
    {
        //$user = User::withTrashed()->find($id);
        $user = User::whereNotNull('deleted_at')->find($id);

        $rst = User::where('id', $id)->update(['deleted_at' => NULL]);
        //dd($rst);
        if (!$user) {
            return Response::json(['state' => 0, 'message' => '用户已彻底删除, 不可恢复.']);
        }

        //$user->restore();
        if ($rst) {
            return Response::json(['state' => 1, 'message' => '用户状态已经正常.']);
        } else {
            return Response::json(['state' => 0, 'message' => '用户已是正常用户.']);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function member_list()
    {

        return view('Admin.artice.member_list');
    }

    /**
     * 显示创建用户表单
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $data = AclUser::get();
        return view('Admin.user.form', [
            'acl_user' => $data
        ]);
    }

    /**
     * 创建用户
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        //dd(Auth::user()->id);
        $user = new User;
        $data = $request->all();
        $validate = Validator::make($data, $user->rules()['create']);
        $messages = $validate->messages();
        if ($validate->fails()) {
            $msg = $messages->toArray();
            foreach ($msg as $k => $v) {
                return json_encode(['sta' => 0, 'msg' => $v[0], 'data' => '']);
            }
        }
        /*if(isset($data['email'])){
           $tit=User::where('email',$data['email'])->first();
            if(!empty($tit)){
                return json_encode(['sta' => 0, 'msg' =>'邮箱已存在', 'data' => '']);
            }
        }*/
        $user->create($request->only($user->getFillable()));
        $data = $user->where('name',$data['name'])->update(['created_by' => Auth::id()]);

        if ($data) {
            return json_encode(['sta' => 1, 'msg' => '请求成功', 'data' => '']);
        }
        return json_encode(['sta' => 0, 'msg' => '请求失败', 'data' => '']);
    }


    /**
     * 用户修改用户表单
     *
     * @param $id
     *
     * @return \Illuminate\View\View
     */

    public function edit($id)
    {
        $user = User::find($id);

        return view('Admin/user.form')->withUser($user);
    }

    /* public function edit($id)
     {
         $user = User::find($id);
         return view('user.form')->withUser($user);
     }*/

    /**
     * 更新用户
     *
     * @param Request $request
     * @param $id
     *
     * @return mixed
     */
    public function update(Request $request, $id)
    {
        //dd(Input::all());
        $id = Input::get('id');
        $user = User::find($id);
        if ($user) {
            $data = $request->all();
            if (!empty($data['password_confirmation']) && !empty($data['password'])) {
                //dd(12341);
                if ($data['password_confirmation'] != $data['password']) {
                    return json_encode(['sta' => 0, 'msg' => '两次密码不一致', 'data' => '']);
                }
            }
            $user->update($request->only($user->getFillable()));
            if($user){
                return json_encode(['sta' => 1, 'msg' => '请求成功', 'data' => '']);
            }
        } else {
            return json_encode(['sta' => 0, 'msg' => '请求失败', 'data' => '']);
        }
    }

    /*public function m_update()
    {
        $callback=Input::get('callback');
        $user = User::find(Auth::id());
        $id_card = json_decode(stripslashes(Input::get('identity_card_file')),true);
        $data = Input::all();
        $data['identity_card_file'] = $id_card;
        if($data){
            $rst = $user->update($data);
            if ($rst) {
                return $callback.'('.json_encode([
                    'data' => $rst,
                    'sta' => 1,
                    'msg' => '修改成功'
                ]).')';
            }else{
                return $callback.'('.json_encode([
                    'data' => $rst,
                    'sta' => 0,
                    'msg' => '修改失败'
                ]).')';

            }
        }else{
            return $callback.'('.json_encode([
                'data' => $data,
                'sta' => 0,
                'msg' => '修改失败'
            ]).')';

        }

    }*/
    /* public function update(Request $request, $id)
     {
         $user = User::find($id);
         //$this->validate($request, $user->rules()['update']);
         //dump($request->only($user->getFillable()));exit;
         $user->update($request->only($user->getFillable()));
         return Redirect::route('user.index')->withMessage('修改成功');
     }*/

    /**
     * 删除用户
     *
     * @param $id
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $user = User::find($id);
        if (!$user) {
            return Response::json(['state' => 0, 'message' => '用户不存在!']);
        }

        if ($user->id == Auth::id()) {
            return Response::json(['state' => 0, 'message' => '你不能删除自己!']);
        }

        $user->delete();
        return Response::json(['state' => 1, 'message' => '删除成功']);
    }

    /**
     * 个人资料
     *
     * @return mixed
     */
    public function m_my()
    {
        $data = User::find(Auth::id())->toArray();
        $callback = Input::get('callback');
        $data['a_pic'] = $data['avatar'];
        $data['avatar'] = resize_img($data['avatar']);
        //dd($data);
        if (is_array($data) != null) {
            return $callback . '(' . json_encode([
                'callback' => $callback,
                'data' => $data,
                'sta' => 1,
                'msg' => '请求成功'
            ]) . ')';

        } else {
            return $callback . '(' . json_encode([
                'callback' => $callback,
                'data' => $data,
                'sta' => 0,
                'msg' => '请求失败'
            ]) . ')';

        }
    }

    /**
     * 显示用户信息
     *
     * @param $id
     *
     * @return mixed
     */
    public function show($id)
    {
        //dd($id);
        //$user = User::find($id);
        // dd(Auth::user()->toArray());

        return view('Admin/user.form');
    }


    public function my()
    {
        $data = User::find(Auth::id());
        $data_user = User::where('id', $data['id'])->get();
        foreach ($data_user as $user) {
            return view('Admin/user.my', ['user' => $user]);
        }


    }
    /*public function my()
    {
        //dump(User::find(Auth::id()));exit;
        return view('user.my')->withUser(User::find(Auth::id()));
    }*/

    /**
     * 显示登入表单
     *
     * @return \Illuminate\View\View
     */
    public function getLogin()
    {
        return view('Admin.user.login');

    }

    /**
     * 处理登入请求
     *
     * @return mixed
     */
    public function postLogin()
    {
        $data = $this->_postLogin();
        //验证表单提交是否与数据库匹配
        if (is_array($data)) {
            if ($data['rst'] == true) {
                return redirect()->intended($data['redirect'])->withMessage('登录成功');//登录成功，跳转页面
            } else {
                return Redirect::back()->withMessage('用户名或者密码错误')->withInput();
            }
        } else {

            return Redirect::back()->withMessage('用户名或者密码错误')->withInput();
        }


    }


    public function _postLogin()
    {
        $username = Input::get('username');
        $password = Input::get('password');
       // dd($password);
        $remember = Input::get('remember', false);
        $field = isEmail($username) ? 'email' : 'name';
        $redirect = urldecode(Input::get('redirect', '/'));
        $data['id'] = User::where(array(
            'name' => $username,
            'deleted_at' => NULL,
            'type'=>NULL
        ))->get();
        if (count($data['id']->toArray()) > 0) {
            $id_data = $data['id']->toArray();
            $data['id'] = $id_data['0']['id'];
            $rst = Auth::attempt([$field => $username, $field => $username, 'password' => $password], $remember);
            return $data = ([
                'id' => $data['id'],
                'rst' => $rst,
                'username' => $username,
                'password' => $password,
                'redirect' => $redirect,
            ]);
        } else {
            return Redirect::back()->withMessage('用户名或者密码错误')->withInput();
        }
    }


    /**
     * 登出
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getLogout()
    {
        Auth::logout();
        return Redirect::route('user.login');
    }

    public function m_getLogout()
    {
        $callback = Input::get('callback');
        //dd(Auth::logout());
        Auth::logout();
        return $callback . '(' . json_encode([
            'sta' => '1',
            'msg' => '登出成功',
            'callback' => $callback,
        ]) . ')';


    }

    /**
     * 搜索用户
     *
     * @return string
     */
    public function search()
    {
        $keyword = Input::get('keyword');

        return User::where('name', 'like', $keyword . '%')->limit(10)->get()->toJson();
    }

    /**
     * 锁定用户
     *
     * @param $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function lock($id)
    {
        $user = User::find($id);
        if (!$user) {
            return Response::json(['state' => 0, 'message' => '用户不存在!']);
        }

        if ($user->id == Auth::id()) {
            return Response::json(['state' => 0, 'message' => '你不能锁定自己!']);
        }

        $user->lock = User::LOCK;
        $user->save();
        return Response::json(['state' => 1, 'message' => '锁定成功']);
    }

    /**
     * 解除锁定/启动用户
     *
     * @param $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function unlock($id)
    {
        $user = User::find($id);
        if (!$user) {
            return Response::json(['state' => 0, 'message' => '用户不存在!']);
        }

        if ($user->id == Auth::id()) {
            return Response::json(['state' => 0, 'message' => '你不能锁定活解除锁定自己!']);
        }

        $user->lock = User::UNLOCK;

        $user->save();
        return Response::json(['state' => 1, 'message' => '启用成功']);
    }
}
