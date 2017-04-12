<?php

namespace App\Http\Controllers\Admin;

use Redirect;
use Response;
use App\Http\Requests;
use App\Models\AclResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * 权限管理
 *
 * Class AclResourceController
 * @package App\Models
 *
 * @author  fengqi <lyf362345@gmail.com>
 * @copyright Copyright (c) 2015 udpower.cn all rights reserved.
 */
class AclResourceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $resource = (new AclResource())->AclResource;

        return view('Admin.acl.resource.index')->withResource($resource);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Admin.acl.resource.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $resource = new AclResource();
        
        $this->validate($request, $resource->rules()['create']);

        $resource->create($request->only($resource->getFillable()));

        return Redirect::route('acl.resource.index')->with('message', '添加成功');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $resource = AclResource::find($id);

        if (!$resource) {
            return Redirect::route('acl.resource.index')->withErrors('记录不存在, 请先创建');
        }

        return view('Admin.acl.resource.form')->withResource($resource);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $resource = AclResource::find($id);

        if (!$resource) {
            return Redirect::back()->withErrors('记录不存在, 请先创建');
        }

        $this->validate($request, $resource->rules()['update']);

        $resource->update($request->only($resource->getFillable()));

        return Redirect::route('acl.resource.index')->with('message', '修改成功');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $resource = AclResource::find($id);

        if (!$resource) {
            return Response::json(['state' => 0, 'message' => '文章不存在!']);
        }

        $resource->delete();

        return Response::json(['state' => 1, 'message' => '删除成功']);
    }
}
