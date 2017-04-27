<?php

namespace App\Http\Controllers\Admin;

use App\Models\Brand;
use App\Models\Goods;
use App\Models\Sort;
use Input;
use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use Response;
use Validator;
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
        return view('Admin.artice.Add_goods', ['sort' => $sort]);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * 获取子分类品牌
     */
    public function set_brand_sort()
    {
        $id = Input::get('sort_id');//获取到分id，获取品牌分类
        $sql = "select * from brand where instr(concat(',',sort_id,','),',$id,')<>0 order by brand_num DESC ";
        $rst = DB::select($sql);
        return Response::json(['msg' => '请求成功', 'data' => $rst, 'sta' => '1']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $goods = new Goods();
        $messages=[
            'sort_id.required'=>'请选择分类',
            'brand_id.required'=>'请选择品牌',
            'goods_title.required'=>'请输入商品标题',
            'goods_title.unique'=>'该商品标题已被占用',
            'Thumbnails'=>'请上传商品缩略图',
            'plan'=>'请上传商品展示图',
            'price'=>'请输入商品价格',
            'inventory'=>'请输入库存',
            'content'=>'请输入商品详情'
        ];
        $validator = Validator::make($request->all(), $goods->rules()['create'],$messages);
        $messages = $validator->messages();
        if ($validator->fails()) {
            $msg = $messages->toArray();
            foreach ($msg as $k => $v) {
                return json_encode(['sta' => 0, 'msg' => $v[0], 'data' => '']);
            }
        }
        $rst_data=$goods->create($request->only($goods->getFillable()));
        if($rst_data){
            return json_encode(['msg'=>'请求成功','data'=>$rst_data->id,'sta'=>'1']);
        }else {
            return json_encode(['msg' => '请求失败', 'data' => '', 'sta' => 0,]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $set_goods=Goods::find($id);
        $sort = Sort::where(['type' => '0', 'pid' => "0"])->select('id', 'pid', 'name')->orderBy('id', 'asc')->get()->toArray();
        return view('Admin.artice.Add_goods', ['sort'=>$sort,'set_goods' => $set_goods]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function goods_list()
    {
        $goods_list=Goods::orderBy('id','desc')->paginate(10);
        return view('Admin.artice.goods_list',['goods_list'=>$goods_list]);
    }

    /**set_brand_sort
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        $goods = Goods::find($request->goods_id);
        $messages=[
            'sort_id.required'=>'请选择分类',
            'brand_id.required'=>'请选择品牌',
            'goods_title.required'=>'请输入商品标题',
            'Thumbnails'=>'请上传商品缩略图',
            'plan'=>'请上传商品展示图',
            'price'=>'请输入商品价格',
            'inventory'=>'请输入库存',
            'content'=>'请输入商品详情'
        ];
        $validator = Validator::make($request->all(), $goods->rules()['update'],$messages);
        $messages = $validator->messages();
        if ($validator->fails()) {
            $msg = $messages->toArray();
            foreach ($msg as $k => $v) {
                return json_encode(['sta' => 0, 'msg' => $v[0], 'data' => '']);
            }
        }
        $rst_data=$goods->update($request->only($goods->getFillable()));
        if($rst_data){
            return json_encode(['msg'=>'更新成功','data'=>"",'sta'=>'1']);
        }else {
            return json_encode(['msg' => '更新失败', 'data' => '', 'sta' => 0,]);
        }


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
