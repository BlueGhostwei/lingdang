<?php

namespace App\Http\Controllers\Admin;

use App\Models\Brand;
use App\Models\Sort;
use Input;
use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use Response;
use App\Http\Controllers\Controller;

class GoodsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //7
    }

    /**
     * Display a listing of the resource.
     *获取分类商品分类，通过商品分类获取品牌
     * @return \Illuminate\Http\Response
     */
    public function Add_goods()
    {
        $sort = Sort::where(['type' => '0', 'pid' => "0"])->select('id', 'pid', 'name')->orderBy('id', 'asc')->get()->toArray();
        return view('Admin.artice.Add_goods',['sort'=>$sort]);
    }

    public function set_brand_sort(){
     $id=Input::get('sort_id');//获取到分id，获取品牌分类
     $sql="select * from brand where instr(concat(',',sort_id,','),',$id,')<>0 order by brand_num DESC ";
     $rst=DB::select($sql);
     return Response::json(['msg'=>'请求成功','data'=>$rst,'sta'=>'1']);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
