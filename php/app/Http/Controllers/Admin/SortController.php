<?php

namespace App\Http\Controllers\Admin;

use Hamcrest\Core\IsNull;
use Illuminate\Http\Request;
use App\Models\Good_sort;
use Input;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class SortController extends Controller
{
    /**
     * Display a listing of the resource.
     * 商品分类类
     * @return \Illuminate\Http\Response
     */
    /**
     *获取分类,页面渲染
     */
    public function index()
    {

        $sort = Good_sort::orderBy('id', 'desc')->get()->toArray();
        return view('Admin.artice.Add_brand', ['sort' => $sort]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     *
     * 添加商品分类
     * 根据分类上传商品
     */
    public function store(Request $request)
    {
        dd($request->all());

    }

    /**
     * 添加品牌
     */
    public function storeBrand()
    {
        $GetData = Input::all();
        dd($GetData);

    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
