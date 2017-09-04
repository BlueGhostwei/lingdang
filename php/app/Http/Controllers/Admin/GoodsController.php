<?php

namespace App\Http\Controllers\Admin;

use App\Models\Attributes;
use App\Models\Brand;
use App\Models\Coupon;
use App\Models\Goods;
use App\Models\Shopping;
use App\Models\Goods_param;
use App\Models\Gcollection;
use App\Models\Goods_standard;
use App\Models\Order;
use App\Models\Sort;
use Auth;
use Input;
use Illuminate\Http\Request;
use DB;
use App\Http\Requests;

use Response;
use Symfony\Component\HttpFoundation\IpUtils;
use Validator;
use App\Http\Controllers\Controller;

class GoodsController extends Controller
{
    
    /**
     * @param Request $request
     * @return mixed
     *  GoodsCouponSave
     * 创建优惠券
     */
    public function GoodsCouponSave(Request $request){
        $Coupon=new Coupon();
        $messages=[
          'name.required'=>'优惠券名称不能为空',
          'name.min'=>'优惠券名称至少3个字符',
          'condition.required'=>'优惠券面额不能为空',
          'createnum.required'=>'消费金额不能为空',
          'type.required'=>'请选择优惠券属性',
          'send_start_time.required'=>'请设置发放开始时间',
          'send_end_time.required'=>'请设置发放结束时间',
          'use_start_time.required'=>'请设置使用开始时间',
          'use_end_time.required'=>'请设置使用结束时间',
          'status.required'=>'请设置优惠券是否有效',
        ];
        $validator=Validator::make($request->all(),$Coupon->rules()['create'],$messages);
        if ($validator->fails()) {
            foreach ($messages as $k => $v) {
                return json_encode(['sta' => 0, 'msg' => $v[0], 'data' => '']);
            }
        }
        $result=$Coupon->create($request->only($Coupon->getFillable()));
        return json_encode(['sta'=>'1','msg'=>'请求成功','data'=>$result]);
     }


    /**
     * @return mixed
     * 商品优惠券添加
     */
    public function GoodsCoupon(){
      return view('Admin.goods.coupon');
    }

    /**
     * @return mixed
     * 商品优惠券列表
     * 全部，已付款，未付款
     * 已付款（已支付未发货，已发货未收货，已发货已收货）
     * 订单状态，0为未支付，1已支付待发货，2已支付已发货,3已发货已收货,4退货'
     */
    public function GoodsCouponList(){
     $type=Input::get('type');

     $coupon=Coupon::orderBy('id','desc')->paginate(10);
     $count_num=Coupon::count('id');
     return view('Admin.goods.coupon_list',['coupon'=>$coupon,'count_num'=>$count_num]);
    }


    /**
     * 展示优惠券
     *
     */
    public function coupon_show(){
        $coupon_id=Input::get('coupon_id');
        if(!$coupon_id){
            return \Redirect::back();
        }
         $couponData=Coupon::find($coupon_id);
        return view('Admin.goods.coupon',['couponData'=>$couponData]);
    }

    /**
     * 优惠券编辑更新
     */
    public function GoodsCouponUpdate(Request $request){
        $Coupon=new Coupon();
        $Coupon->update($request->only($Coupon->getFillable()));
        return json_encode(['sta'=>'1','msg'=>'请求成功','data'=>""]);
    }
    /**
     * 删除优惠券
     */
    public function coupon_dele(){
        $coupon_id=Input::get('coupon_id');
        if(!$coupon_id){
            return json_encode(['sta'=>'0','msg'=>'删除失败','data'=>'']);
        }
        Coupon::where('id',$coupon_id)->delete();
        return json_encode(['sta'=>'1','msg'=>'删除成功','data'=>'']);
    }

    /**
     * 加入购物车 /goods/shopping
     * get请求
     * 传入的参数 user_id（用户id）gid(商品的id)
     */
    public  function shopping()
    { error_reporting( E_ALL&~E_NOTICE );
        $gid=Input::get("gid");
        $user_id=Input::get("user_id")?:Auth::id();
        $specif=Input::get("specif");
        $scount=Input::get("scount");
        $brand_id=Input::get("brand_id");
        $code = $this->make_order($user_id);
        if(!$user_id)
        {
            return json_encode(['msg'=>'请先登录才能加入购物车','data'=>['collists'=>0],'sta'=>'0']);
        }
        if(!$specif)
        {
            return json_encode(['msg'=>'缺少规格参数请输入完整','data'=>['collists'=>0],'sta'=>'0']);
        }
        if(!$scount)
        {
            return json_encode(['msg'=>'缺少库存参数请输入完整','data'=>['collists'=>0],'sta'=>'0']);
        }
        if(!$brand_id)
        {
            return json_encode(['msg'=>'缺少品牌参数请输入完整','data'=>['collists'=>0],'sta'=>'0']);
        }
        $sgoods=Goods_standard::where("goods_id","=",$gid)->get()->toArray();
        if(!$sgoods)
        {
            return json_encode(['msg'=>'没有该商品','data'=>['collists'=>0],'sta'=>'0']);
        }
        $shop=new Shopping();
        $shop->gid=$gid;
        $shop->user_id=$user_id;
        $shop->brand_id=$brand_id;
        $shop->specif=$specif;
        $shop->scount=$scount;
        $shop->code=$code;
        $good = Goods::where("id", "=", $gid)->select("sort_id")->first();
        $cids = explode(",", $specif);
        $att = array();
        for ($i = 0; $i < count($cids); $i++) {
            $att[$i] = Attributes::where("arr_name", "=", "$cids[$i]")
                ->where("sort_id", "=", $good['sort_id'])
                ->select("id")
                ->get()
                ->toArray();
        }
        $arrs="";
        for ($j = 0; $j < count($att); $j++) {
            $arr[$j] = $att[$j][0];
            if($j<(count($att)-1)) {
                $arrs .= $arr[$j]["id"] . ",";
            }
            else
            {
                $arrs .= $arr[$j]["id"];
            }
        }
        $attd = Goods_standard::where("goods_id", "=", $gid)
            ->where("attributes_id", "=",$arrs)
            ->select("price", "stock")->first();
        //dd($attd);

        if(!$attd){
            return json_encode(['msg'=>'暂无改规格商品','data'=>['stock'=>0,'price'=>0],'sta'=>'0']);
        }
        //判断同一用户购买同一件商品
        $gshop=Shopping::where("gid",$gid)->where("specif","=",$specif)->where("brand_id","=",$brand_id)->where("user_id","=",$user_id)->first();
        $count=$gshop["scount"];
        if($gshop){
            $sid=$gshop['sid'];
            $counts=$count+$scount;
            $stupdates=Shopping::where('sid',"=",$sid)
                ->update(['scount' => $counts]);
            if($stupdates){
                return json_encode(['msg'=>'添加购物车成功','data'=>['collists'=>1],'sta'=>'1']);
            }else {
                return json_encode(['msg' => '添加购物车失败', 'data' => ['collists'=>0], 'sta' => '0']);
            }
        }
        else
        {
            $shop=$shop->save();
            if($shop){
                return json_encode(['msg'=>'添加购物车成功','data'=>['collists'=>1],'sta'=>'1']);
            }else {
                return json_encode(['msg' => '添加购物车失败', 'data' => ['collists'=>0], 'sta' => '0']);
            }
        }
    }

    /**
     * 删除购物车 /goods/delshop
     * 传入商品的参数 商品的gid
     */
    public  function delshop()
    {
        $gid=Input::get("gid");
        //dd($goodid);
        $user_id=Input::get("user_id")?:Auth::id();
        if(!$user_id)
        {
            return json_encode(['msg'=>'请先登录才能删除','data'=>['collists'=>0],'sta'=>'0']);
        }
        $delshop=Shopping::where("gid","=",$gid)->delete();
        if($delshop){
            return json_encode(['msg' => '删除购物车成功', 'data' => ['collists'=>1], 'sta' =>'1']);
        }
        else{
            return json_encode(['msg' => '删除购物车失败', 'data' =>['collists'=>0], 'sta' =>'0']);
        }

    }
    /**
     * 购物车列表 /goods/shoplist
     */
    public function shoplist(){
        $user_id=Input::get("user_id")?:Auth::id();
        $page=Input::get("page");
        if($page<=1 && $page)
        {
            $page=1;
        }

        if($user_id){

            $brands=Shopping::where("user_id","=",$user_id)
                ->groupBy('brand_id')
                ->get()->toArray();
            for($j=0;$j<count($brands);$j++)
            {
                $brand=Brand::where("id","=",$brands[$j]["brand_id"])->select("brand_name")->first();

                $jbrands[$j]["title"]=$brand["brand_name"];

                $colist=Shopping::join("goods","goods.id","=","shopping.gid")
                    ->join("brand","brand.id","=","shopping.brand_id")
                    ->where("shopping.user_id","=",$user_id)
                    ->where("shopping.brand_id","=",$brands[$j]["brand_id"])
                    ->select("goods_title","Thumbnails","gid","specif","scount","sid","brand_name")
                    ->orderBy("shopping.sid","desc")
                    ->offset($page-1)
                    ->limit(5)
                    ->get()
                    ->toArray();

                if($colist){
                    for($i=0;$i<count($colist);$i++)
                    {
                        $gprice=Goods_standard::where("goods_id","=",$colist[$i]["gid"])->orderBy("price")->get()->toArray();
                        if($gprice)
                        {
                            $colist[$i]["price"]=$gprice[0]["price"];
                        }
                        else
                        {
                            $colist[$i]["price"]=0;
                        }
                        $colist[$i]["Thumbnails"]=md52url($colist[$i]["Thumbnails"]);

                    }
                }
                $jbrands[$j]["brand"]=$colist;
            }
            if($jbrands){
                return json_encode(['msg' => '查看详情成功', 'data' => $jbrands, 'sta' =>'1']);
            }
            else{
                return json_encode(['msg' => '查看详情失败', 'data' =>"", 'sta' =>'0']);
            }

        }
        else
        {
            return json_encode(['msg'=>'请先登录才能查看','data'=>"",'sta'=>'0']);
        }


    }

    /**
     * 需求：用户已购买的免单商品
     *免单活动列表
     *FreeCharge
     */
    public function FreeChargeGoods(){
        $user_id=Input::get('user_id')?:Auth::id();
        $page=$this->SetPage();
        //获取当前用户订单列表，取出免单活动
        $GetUserOrder=Order::leftJoin('goods','order.goods_id','=','goods.id')
                     ->where(['order.user_id'=>$user_id,'goods.FreeCharge'=>'1'])
                     ->select('goods.*')->offset($page)->limit(10)->get()->toArray();
        //$JF_Goods= Goods::where('FreeCharge',1)->offset($page)->limit(10)->get()->toArray();
        if (!empty($GetUserOrder)) {
            foreach ($GetUserOrder as $k=>&$vel){
                $vel['Thumbnails'] = md52url($vel['Thumbnails']);
                if(!empty($vel['plan'])){
                    $img_arr=explode(',',$vel['plan']);
                   foreach ($img_arr as $r=>&$t){
                       $t=md52url($t);
                   }
                    $vel['plan']=$img_arr;
                }
                $vel["content"] = trim(htmlspecialchars(str_replace(array("\r\n", "\r", "\n"), "", strip_tags($vel["content"]))));
            }
        }
        return json_encode(['msg' => '请求成功', 'data' => $GetUserOrder, 'sta' => '1']);
    }
    /**
     * 积分商城列表
     * 商品id，商品图片，商品标题，商品价格，分页处理
     */
    public function PointsMall(){

       $page=$this->SetPage();
        $JF_Goods= Goods::where('jf_exchange',1)->offset($page)->limit(10)->get()->toArray();
        if (!empty($JF_Goods)) {
           foreach ($JF_Goods as $k=>&$vel){
               $vel['Thumbnails'] = md52url($vel['Thumbnails']);
               $vel['plan'] = md52url($vel['plan']);
            }
        }
        return json_encode(['msg' => '请求成功', 'data' => $JF_Goods, 'sta' => '1']);

    }
    /**
     *商品收藏 /goods/collection
     */

    public function collection()
    {
        $goodid = Input::get("goods_id");
        //dd($goodid);
        $user_id = Input::get("user_id") ?: Auth::id();

        if (!$user_id) {
            return json_encode(['msg' => '请先登录才能收藏', 'data' => ['collists' => 0], 'sta' => '0']);
        }
        $coll = new Gcollection();
        $collist = Gcollection::where("goodid", "=", $goodid)->first();
        if ($collist) {
            $delcoll = Gcollection::where("goodid", "=", $goodid)->delete();
            if ($delcoll) {
                return json_encode(['msg' => '取消收藏成功', 'data' => ['collists' => 0], 'sta' => '1']);
            } else {
                return json_encode(['msg' => '取消收藏失败', 'data' => ['collists' => 0], 'sta' => '0']);
            }
        }
        if ($goodid) {
            $coll->goodid = $goodid;
            $coll->usersid = $user_id;
            $coll->type = "1";
            $coll = $coll->save();
            $collists = Gcollection::where("goodid", "=", $goodid)->first();
            if ($coll) {
                return json_encode(['msg' => '收藏成功', 'data' => ['collists' => 1], 'sta' => '1']);
            } else {
                return json_encode(['msg' => '收藏失败', 'data' => ['collists' => 0], 'sta' => '0']);
            }
        } else {
            return json_encode(['msg' => '收藏失败', 'data' => ['collists' => 0], 'sta' => '0']);
        }

    }

    /**
     *  商品收藏列表 /goods/colist
     */
    public function colist()
    {
        $user_id = Input::get("user_id") ?: Auth::id();
        $page = Input::get("page");
        if ($page <= 1 && $page) {
            $page = 1;
        }
        //dd($page-1);
        if ($user_id) {
            $colist = Gcollection::join("goods", "goods.id", "=", "Gcollection.goodid")
                // ->join("goods_standard","goods_standard.goods_id","=","gcollection.goodid")
                ->where("gcollection.usersid", "=", $user_id)
                ->select("goods_title", "Thumbnails", "goods.id", "goodid")
                ->orderBy("Gcollection.id", "desc")
                ->offset($page - 1)
                ->limit(5)
                ->get()
                ->toArray();

            if ($colist) {
                for ($i = 0; $i < count($colist); $i++) {
                    $gprice = Goods_standard::where("goods_id", "=", $colist[$i]["goodid"])->orderBy("price")->get()->toArray();
                    if ($gprice) {
                        $colist[$i]["price"] = $gprice[0]["price"];
                    } else {
                        $colist[$i]["price"] = 0;
                    }
                    $colist[$i]["Thumbnails"] = md52url($colist[$i]["Thumbnails"]);

                }

            } else {
                return json_encode(['msg' => '暂无收藏列表', 'data' => '', 'sta' => '0']);
            }
            if ($colist) {
                return json_encode(['msg' => '显示成功', 'data' => $colist, 'sta' => '1']);
            } else {
                return json_encode(['msg' => '显示失败', 'data' => '', 'sta' => '0']);
            }
        } else {
            return json_encode(['msg' => '请先登录才能收藏', 'data' => "", 'sta' => '0']);
        }

    }

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
        //根据分类ID查询规格
        if (!empty(Input::get('sort_id'))) {
            $rst = Attributes::where(['sort_id' => trim(Input::get('sort_id')), 'pid' => '0'])->get()->toArray();
            return json_encode(['sta' => '1', 'msg' => "请求成功", 'data' => '']);
        }
        //查询一级分类
        $sort = Sort::where(['type' => '0', 'pid' => "0"])->select('id', 'pid', 'name')->orderBy('id', 'asc')->get()->toArray();
        //查询二级分类
        if (!empty($sort)) {
            foreach ($sort as $key => &$vel) {
                $sort[$key]['child'] = Sort::where('pid', $vel['id'])->select('id', 'name', 'img_path', 'content')->get()->toArray();
            }
        }
        return view('Admin.artice.Add_goods', ['sort' => $sort]);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * 获取子分类品牌
     * 获取分类规格
     *[
     * { "desc": "分类", "name": "裙子", "id": "3","sub": [
     * { "desc": "属性", "name": "颜色", "id": "1", "sub": [
     * { "desc": "规格", "name": "白色", "id": "1", "kucun": 0, "jiage": 0 },
     * { "desc": "规格", "name": "黑色", "id": "2", "kucun": 0, "jiage": 0 },
     * { "desc": "规格", "name": "红色", "id": "3", "kucun": 0, "jiage": 0 }
     * ]
     * },
     * { "desc": "属性", "name": "尺寸", "id": "2", "sub": [
     * { "desc": "规格", "name": "S", "id": "4", "kucun": 0, "jiage": 0 },
     * { "desc": "规格", "name": "M", "id": "5", "kucun": 0, "jiage": 0 },
     * { "desc": "规格", "name": "L", "id": "6", "kucun": 0, "jiage": 0 },
     * { "desc": "规格", "name": "XL", "id": "7", "kucun": 0, "jiage": 0 },
     * { "desc": "规格", "name": "XLL", "id": "8", "kucun": 0, "jiage": 0 }
     * ]
     * },
     * { "desc": "属性", "name": "布料", "id": "3", "sub": [
     * { "desc": "规格", "name": "纯棉", "id": "9", "kucun": 0, "jiage": 0 },
     * { "desc": "规格", "name": "羽绒", "id": "10", "kucun": 0, "jiage": 0 },
     * { "desc": "规格", "name": "蝉丝", "id": "11", "kucun": 0, "jiage": 0 }
     * ]
     * },
     * { "desc": "属性", "name": "产地", "id": "4", "sub": [
     * { "desc": "规格", "name": "深圳", "id": "12", "kucun": 0, "jiage": 0 },
     * { "desc": "规格", "name": "广州", "id": "13", "kucun": 0, "jiage": 0 },
     * { "desc": "规格", "name": "河南", "id": "14", "kucun": 0, "jiage": 0 }
     * ]
     * }
     * ]
     * }
     */
    public function set_brand_sort()
    {
        $id = Input::get('sort_id');//获取到分id，获取品牌分类
       // $id = 2;
        $sql = "select * from brand where instr(concat(',',sort_id,','),',$id,')<>0 order by brand_num DESC ";
        $rst['SortData'] = DB::select($sql);
        //获取分类
        $Set_sort = Sort::where('id', $id)->select('id', 'name', 'content', 'pid', 'img_path')->get()->toArray();
        //获取规格
        if (!empty($Set_sort)) {
            $Set_sort[0]['desc'] = "分类";
            $Set_sort[0]['sub'] = Attributes::where(['sort_id' => $id, 'pid' => '0'])
                ->select('arr_name as name', 'id', 'pid', 'store_num', 'sort_id')->get()->toArray();
            if ($Set_sort[0]['sub']) {
                foreach ($Set_sort[0]['sub'] as $k => &$v) {
                    $v['desc'] = "属性";
                    $v['sub'] = Attributes::where('pid', $v['id'])
                        ->select('arr_name as name', 'id', 'pid', 'store_num', 'sort_id')
                        ->orderBy('store_num', 'desc')->orderBy('created_at', 'dasc')
                        ->get()->toArray();
                    if (!empty($v['sub'])) {
                        foreach ($v['sub'] as $r => &$t) {
                            $t['desc'] = '规格';
                            $t['kucun'] = '0';
                            $t['jiage'] = '0 ';
                        }
                    }
                }
            }
            $rst['attribut'] = $Set_sort;
        }
        //dd($rst);
        return Response::json(['msg' => '请求成功', 'data' => $rst, 'sta' => '1']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     *
     */
    public function store(Request $request)
    {
        /*$arr=[
            ['key'=>'颜色','vel'=>'白，红，蓝'],
            ['key'=>"尺寸",'vel'=>'x,m,l'],
        ];*/
        //先保存商品信息，产生商品id，在保存商品规格及，产品参数
        //添加事务
        DB::beginTransaction();
        try {
            $goods = new Goods();
            $messages = [
                'sort_id.required' => '请选择分类',
                'brand_id.required' => '请选择品牌',
                'goods_title.required' => '请输入商品标题',
                'goods_title.unique' => '该商品标题已被占用',
                'Thumbnails' => '请上传商品缩略图',
                'plan' => '请上传商品展示图',
                //'price'=>'请输入商品价格',
                'content' => '请输入商品详情'
            ];
            $validator = Validator::make($request->all(),$goods->rules()['create'], $messages);
            $messages = $validator->messages();
            if ($validator->fails()) {
                $msg = $messages->toArray();
                foreach ($msg as $k => $v) {
                    return json_encode(['sta' => 0, 'msg' => $v[0], 'data' => '']);
                }
            }
            $result = $goods->create($request->only($goods->getFillable()));
            //获取商品ID
            $goods_id=$result->id;
            //产品数：
            $guige = Input::get('guige');//规格
            if ($guige) {
                //attributes查询分类
                foreach ($guige as $k => &$v) {
                    $v_num=count($v);
                    $arr="";
                    for ($i=0;$i<$v_num-2;$i++){
                        if (isset($arr['attributes_id'])) {
                            $arr['attributes_id'] = $arr['attributes_id'] . ',' . $v[$i];
                        } else {
                            $arr['attributes_id'] =$v[$i];
                        }
                    }
                    $num_count=$v_num-1;
                    for ($i=1;$i<=$num_count;$i++){
                        if($i == $num_count-1){
                            $arr['price'] =$v[$i];
                        }
                        if($i==$num_count){
                            $arr['stock'] = $v[$i];
                        }

                    }
                    $arr['goods_id']=$goods_id;
                    //存表处理
                    $result1 = Goods_standard::create($arr);
                }
            }
            //规格
            $para1 = Input::get('para1');
            if($para1){
                foreach ($para1 as $k=>$v){
                   if(!empty($v)){
                       $str=implode(':',$v);
                       $key=substr($str,0,strrpos($str,':'));//key
                       $vel=str_replace($key.':','',$str);//vey
                       //入库处理
                      $result2= Goods_param::create(['goods_id'=>$goods_id,'key'=>$key,'vel'=>$vel]);
                   }
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();//事务回滚
        }
        return json_encode(['msg' => '请求成功', 'data' => "", 'sta' => '1']);

    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $set_goods = Goods::find($id);
        $sort = Sort::where(['type' => '0', 'pid' => "0"])->select('id', 'pid', 'name')->orderBy('id', 'asc')->get()->toArray();
        if (!empty($sort)) {
            foreach ($sort as $key => &$vel) {
                $sort[$key]['child'] = Sort::where('pid', $vel['id'])->select('id', 'name', 'img_path', 'content')->get()->toArray();
            }
        }
        if($set_goods){
            //获取分类品牌
            $sql = "select * from brand where instr(concat(',',sort_id,','),',$set_goods->sort_id,')<>0 order by brand_num DESC ";
            $sort_brand = DB::select($sql);
            //查询参数//查询规格
            $set_goods['goods_param']=Goods_param::where('goods_id',$id)->get()->toArray();
            $standard=Goods_standard::where('goods_id',$id)->get()->toArray();
            $goods_standard=json_encode($standard);
        }else{
            $sort_brand="";
            $set_goods['goods_param']="";
            $goods_standard="";
        }

        return view('Admin.artice.Add_goods', ['sort' => $sort, 'set_goods' => $set_goods,'sort_brand'=>$sort_brand,'goods_standard'=>$goods_standard]);
    }

    /**
     * 查询商品规格
     */
    public function SelGoodStand(){
        $id=Input::get('goods_id');
        if(!$id){
            return json_encode(['sta'=>"0",'msg'=>'请求失败','data'=>'']);
        }
        $result=Goods_standard::where('goods_id',$id)->get()->toArray();
        return json_encode(['sta'=>"1",'msg'=>'请求成功','data'=>$result]);

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
        $goods_list = Goods::orderBy('id', 'desc')->paginate(10);
        return view('Admin.artice.goods_list', ['goods_list' => $goods_list]);
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
        $messages = [
            'sort_id.required' => '请选择分类',
            'brand_id.required' => '请选择品牌',
            'goods_title.required' => '请输入商品标题',
            'Thumbnails' => '请上传商品缩略图',
            'plan' => '请上传商品展示图',
            'price' => '请输入商品价格',
            'inventory' => '请输入库存',
            'content' => '请输入商品详情'
        ];
        $validator = Validator::make($request->all(), $goods->rules()['update'], $messages);
        $messages = $validator->messages();
        if ($validator->fails()) {
            $msg = $messages->toArray();
            foreach ($msg as $k => $v) {
                return json_encode(['sta' => 0, 'msg' => $v[0], 'data' => '']);
            }
        }
        $rst_data = $goods->update($request->only($goods->getFillable()));
        if ($rst_data) {
            return json_encode(['msg' => '更新成功', 'data' => "", 'sta' => '1']);
        } else {
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
