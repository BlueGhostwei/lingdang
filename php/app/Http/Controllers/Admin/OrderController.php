<?php

namespace App\Http\Controllers\Admin;

use App\Models\Attributes;
use App\Models\Goods_standard;
use App\Models\Order;
use App\Models\Order_goods_info;
use App\Models\Shopping;
use Illuminate\Http\Request;
use App\Models\Goods;
use Auth;
use phpDocumentor\Reflection\Types\Object_;
use Symfony\Component\VarDumper\Dumper\DataDumperInterface;
use Validator;
use App\Http\Requests;
use Input;
use App\Models\Dgoods;
use App\Http\Controllers\Controller;
use DB;
use AopClient;
use AlipayTradeAppPayRequest;
use App\Models\AliPay;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *订单管理控制器
     * @return \Illuminate\Http\Response
     */

    /**
     * 生成订单
     *需要参数：goods_id商品id，购买商品数量（scount），购买商品品牌（brand_id），购买商品规格参数（specif）
     * 接口：order/GenerateOrder 请求方式：get
     * user_id 用户id
     * gid  商品id
     * scount 购买个数
     * address 地址ID
     * specif 商品规格
     *
     * 多件商品同时购买
     * 如订单为为支付状态，在购买一件则添加商品个数
     * 购物车多件商品，同时结算
     */
    public function GenerateOrder()
    {
        //file_put_contents("goods_order.txt",var_export(Input::all(),true),FILE_APPEND);
        $goods_order = Input::get('goods_order');
        $order = new Order();
        $GetAllData = json_decode($goods_order, true);
        if (!empty($GetAllData)) {
            //获取支付方式
            $data['user_id'] = $GetAllData['user_id'] ?: Auth::id();
            if (!$data['user_id']) {
                return json_encode(['sta' => '0', 'data' => '', 'msg' => '请登陆']);
            }
            $data['remark'] = $GetAllData['remark'];
            $data['order_id'] = $this->make_order($data['user_id']);
            if ($GetAllData['goods'] && !empty($GetAllData['goods'])) {
                foreach ($GetAllData['goods'] as $k => $v) {
                    $data['goods_id'] = $v['gid'];
                    if (!$data['goods_id']) {
                        return json_encode(['sta' => '0', 'data' => '', 'msg' => '请求失败，商品不存在']);
                    }
                    $sel_goods = Goods::find($data['goods_id']);
                    if (!$sel_goods) {
                        return json_encode(['sta' => '0', 'data' => '', 'msg' => '请求失败，商品不存在']);
                    }
                    $data['goods_num'] = $v['scount'];
                    $data['address'] = $GetAllData['address'];

                    $data['goods_name'] = $sel_goods->goods_title;
                    //获取商品信息（规格）
                    $data['specif'] = $v['specif'];
                    $data['brand_id'] = $v['brand_id'];//商品品牌
                    //获取商品价格，查询商品规格表，获取规格id
                    if ($data['specif']) {
                        $order_info_arr = explode(',', $data['specif']);
                        $arr = [];
                        foreach ($order_info_arr as $n => $b) {
                            $arri_id = Attributes::where(['arr_name' => "$b", 'sort_id' => $sel_goods->sort_id])->select('id')->first();
                            $arr[$n] = $arri_id->id;
                        }
                        $arr_info = implode(',', $arr);
                        $SetGoodstand = Goods_standard::where(['attributes_id' => $arr_info, 'goods_id' => $v['gid']])->first();
                        if (!$SetGoodstand) {
                            return json_encode(['sta' => '0', 'data' => '', 'msg' => '请求失败，商品参数错误']);
                        }
                        if (isset($data['order_price'])) {
                            $data['order_price'] = $data['order_price'] + $data['goods_num'] * $SetGoodstand['price'];
                        } else {
                            $data['order_price'] = $data['goods_num'] * $SetGoodstand['price'];
                        }
                        $data['specif'] = $arr_info;
                        //修改库存
                        if ($SetGoodstand->stock == 0 || $SetGoodstand->stock - $data['goods_num'] < 0) {
                            return json_encode(['sta' => '0', 'data' => '', 'msg' => '商品名：' . $data['goods_name'] . '|-商品库存紧缺']);
                        }
                        Goods_standard::where(['attributes_id' => $arr_info, 'goods_id' => $v['gid']])->update(['stock' => $SetGoodstand->stock - $data['goods_num']]);
                    } else {
                        return json_encode(['sta' => '0', 'data' => '', 'msg' => '请选择商品规格']);
                    }
                    //查询用户是否重复购买同一种规格产品
                    $setorder = Order::join('order_goods_info', 'order.order_id', '=', 'order_goods_info.order_id')
                        ->where(['order_goods_info.goods_id' => $data['goods_id'],
                            'order.user_id' => $data['user_id'],
                            'order_goods_info.specif' => $data['specif'],
                            'order_goods_info.brand_id' => $data['brand_id']])
                        ->first();
                    $data['set_order'] = $setorder;
                    //判断商品是否已加入购物车
                    if ($v['sid']) {
                        $shop = Shopping::where('sid', $v['sid'])->delete();
                    }
                    if ($setorder) {
                        //更新价格订单价格与购买商品数量
                        $num = $setorder->goods_num + $data['goods_num'];
                        $result = Order_goods_info::where([
                            'order_id' => $setorder->order_id,
                            'goods_id' => $setorder->goods_id,
                            'specif' => $setorder->specif])
                            ->update(['goods_num' => $num]);
                    } else {
                        /**'order_id','specif','brand_id','goods_name','goods_num',*/
                        $rst_order_info = Order_goods_info::create([
                            'order_id' => $data['order_id'],
                            'specif' => $data['specif'],
                            'goods_id' => $data['goods_id'],
                            'brand_id' => $data['brand_id'],
                            'goods_name' => $data['goods_name'],
                            'goods_num' => $data['goods_num']
                        ]);
                        if (!$rst_order_info) {
                            Order_goods_info::where('order_id', $data['order_id'])->delete();
                            return json_encode(['sta' => '0', 'msg' => "服务器错误，请求失败", 'data' => ""]);
                        }
                    }
                }
            }
            /*** user_id',* 'order_id',* 'goods_id',* 'address',* 'status'*/
            if (!empty($data) && !empty($data['set_order'])) {
                //更新订单价格
                $price = $data['set_order']->order_price + $data['order_price'];
                $result = Order::where(['user_id' => $data['user_id'],
                    'order_id' => $data['set_order']->order_id])
                    ->update(['order_price' => $price]);
                $order = $result = Order::where(['user_id' => $data['user_id'], 'order_id' => $data['set_order']->order_id])->get()->toArray();
            } elseif (!empty($data)) {
                $result = Order::create(['user_id' => $data['user_id'],
                    'order_id' => $data['order_id'],
                    'address' => $data['address'],
                    'order_price' => $data['order_price'],
                    'paymethod'=>$data['paymethod']
                ]);

                $order = Order::where('id', $result->id)->get()->toArray();
            }
            return json_encode(['sta' => '1', 'msg' => "请求成功", 'data' => $this->SetOrderId($order)]);
        } else {
            return json_encode(['sta' => '0', 'msg' => "请求失败", 'data' => ""]);
        }
    }

    /**
     * @return mixed
     *订单列表
     */
    public function OrderList()
    {
        $user_id = Input::get('user_id');
        $page = $this->SetPage();
        if ($user_id) {
            $OrderList = Order::where('user_id', $user_id)
                ->select('order_id','user_id','order_price','remark','status','address','eval')
                ->offset($page)->limit(10)->get()->toArray();
            if ($OrderList) {
                $OrderList = $this->OrderInfo($OrderList);
            }
            return json_encode(['sta' => '1', 'msg' => "请求成功", 'data' => $OrderList]);
        }
        return json_encode(['sta' => '0', 'msg' => "请求失败", 'data' => ""]);
    }

    /**
     * @param $DataList
     * @return mixed
     * 获取订单号
     */
    protected function SetOrderId($DataList)
    {
        if ($DataList) {
            foreach ($DataList as $k => &$vel) {
                return $vel['order_id'];
            }
        }
    }


    /**
     * 查看订单看详情
     */
    public function order_infomation()
    {
        $order_id = Input::get('order_id');//订单号
        $user_id = Input::get('user_id');
        $set_order = Order::where(['order_id' => $order_id, 'user_id' => $user_id])->get()->toArray();
        if ($set_order) {
          $set_order =$this->OrderInfo($set_order);
        }
        return json_encode(['sta' => '1', 'msg' => '请求成功', 'data' => $set_order]);
    }
    /**
     * Remove the specified resource from storage.
     *  删掉(取消)订单
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        $order_id = Input::get('order_id');
        $user_id = Input::get('user_id');
        if(!$user_id){
            return json_encode(['sta' => '0', 'msg' => '请登陆', 'data' => '']);
        }
        $GetOrder = Order::where(['order_id' => $order_id, 'user_id' => $user_id])->get()->toArray();
        if ($GetOrder) {
            foreach ($GetOrder as $key =>$vey){
                if($vey['status']=="0" || $vey['status']=="3"){
                        //获取购买商品个数,更新库存
                        $SeletGoods=Order_goods_info::where('order_id',$order_id)->get()->toArray();
                        foreach ($SeletGoods as $r=>$b){
                           $result= Goods_standard::where(['attributes_id'=>$b['specif'],'goods_id'=>$b['goods_id']])->first();
                                    Goods_standard::where(['attributes_id'=>$b['specif'],'goods_id'=>$b['goods_id']])
                                                  ->update(['stock'=>$result['stock']+$b['goods_num']]);
                        }
                }
                Order::where(['order_id' => $order_id, 'status' => $vey['status'], 'user_id' => $user_id])->delete();
                Order_goods_info::where('order_id', $order_id)->delete();
            }
            return json_encode(['sta' => '1', 'msg' =>'订单删除成功', 'data' => '']);
        }else{
            return json_encode(['sta' => '0', 'msg' => '找不到该订单', 'data' => '']);
        }
    }

    /**
     * @return mixed
     * 手机支付宝签名
     */
    public function AlipayMobile(){
        //$OrderId="460557839830574016";
        $OrderId=Input::get('order_id');
        $Price=Input::get('price');
        $user_id=Input::get('user_id');
        $result=Order::where(['order_id'=>$OrderId,'user_id'=>$user_id])->first();
        if($result){
            $OrderInfo = Order_goods_info::where('order_id', $result->order_id)->get()->toArray();
            if ($OrderInfo) {
                  $title=$this->GetGoodsTitle($OrderInfo);
            }else{
                 $title="";
            }
            $arr=[
                'body'=>$title,
                'subject'=>'小日记商品支付',
                'out_trade_no'=>$OrderId,
                'timeout_express'=>'30m',
                'total_amount'=>'0.01',
                'product_code'=>'QUICK_MSECURITY_PAY'
            ];
            // 返回签名后的支付参数给支付宝移动端的SDK。
            //file_put_contents("AliPayClient.txt",var_export($this->AliPayClient(json_encode($arr)),true),FILE_APPEND);
            //dd($this->AlipaySDK($OrderId,$Price));
            return json_encode(['sta'=>"1",'msg'=>'请求成功','data'=>$this->AliPayClient(json_encode($arr))]);
        }else{
            return json_encode(['sta'=>"0",'msg'=>'请求失败，找不到该订单','data'=>""]);
        }
    }

    /**
     * @param $order_id
     * @param null $price
     * @return stringSDK
     * 调用支付
     */
  /* private function AlipaySDK($order_id,$price=null){
        $pay=New AliPay();
        return $pay->getData($order_id,'0.01');
   }*/
    /**
     * ios支付宝签名备用
     */
    public function AliPayClient($json){
        $aop = new AopClient;
        $aop->gatewayUrl = "https://openapi.alipay.com/gateway.do";
        $aop->appId = "2017032106327228";
        $aop->rsaPrivateKey = 'MIIEvAIBADANBgkqhkiG9w0BAQEFAASCBKYwggSiAgEAAoIBAQCr5b+I8keyMiUd1LzJvjjEwglheQuUQrYWszy+ErLf6vsVLg4Cv6DhbztKvQzfpSjLOWKRGHDnsRLRrZ69GoqsY4B9nxlLFQpnAl4TVp4O7Jovjh/NxXcrOuU0uFsxql/aVXsAzddUDCnOgUjJNQa7Jx4OnZwKkPAYCrspxdDaFAohDO1XHrFDQMzXpHY7Rd/68BMtmkC95JPJvln5mHwweph2lnUURgZFJhyzDwWTbzE206DJys7vCFrTOEkaVAIj0t0HJqqLzDgI/19oKPSZive3tGrdkWzUQOkKSWflEEDsTKktTuDXxRwMeXtFFBJRa7Z+9D4DePfnqUem/zLdAgMBAAECggEAVMMJW0H80IWhf8AzB1fhLkRv07yYVRdAKplfTmpyAbAg9ySqi/hqID91ATmPa4hJQUyeqeVfZyANo471Q1IfJzo5VbhqBHfvlTO5p9eCQOGyddijHhhM1uhHtWNitG7KrSKRcKgPkcYdp1JgzbZ0Bz0WuSZGl384pOJFwCdnAOEpDpi+nrvU7IrfyK0IzIjmuIClHu7cLrwgarJL0UMiqFP2/aL4wl/wvZL50cKlLr7dSvsPCrprrDeXlJMucSb/WSW2oDNFn6ykEK1Gi0ZqxnWXNpezD/DQrQzZNq5HY5h5yVHbgYqqfnOxTjch54AaM/uaWM+1WcUSxqBZt6a6gQKBgQDl10+NzqaKj9KiTIKzkHWe19S53CUwO0cn6o/8zJVom8jCvW/rNWCQ/Dur3mVKhRfQy6TJxdCqLASuKNzoS8DtFs5B6xX25Cm7Yaaon84gzIlezwKhmRmQrTz+C6ynC2RTgnRis2iP3JKqJc1aRH6p96gBPsd897f+I1P8va+omQKBgQC/di61UG1ZPSTfEYKl2esxwf2tStW3lWcl6oDrrRl62nLo4Zly2u4NZw1tl8G5534ZE5C8q15RtHGxk1ynRsCUt4ysDAxYoEwL7qne7QJXO16V7c4BnCW43rF7XVxZSDJ91DihEwazRAdB4Ug39F5CMt7AFZpPmCv6h6CsaZuy5QKBgDZHS8VMeS4d2vtzICaxxeU2SUl/QNUMGrjFfy2PTvV+XMIIpMaiO2Th/GGRStB3b/FiNk9kROv7KzvJ8Kl3Ql97VEhi8TP2HBjhbc9CthYu134pWxC4rD3re4zvSt3EJfRGyZ+JiPb4ezZtaPqZVGRlVSq+HbRYd/4vb6UvUq15AoGAEkDKIy8Pvbo+kaWxtu4Xph7AeIzx4xazRsIcmFtgWn4JBnq7jl+g4lY4yYH2TirrsqhS3CnaTB/P1wYdhzUPlx4Ioz5izvA5T8npF/+wgXB/i/un8C9ayU0xznkQHNLtPWHGJFUUBnMt3fIEWJFLizQeWGG23G+9gZz8jHNlDKECgYAQDv/55SKtK4zzywz7kB3FYcmzOfD+QICd11+QRqiY6RiJTvft3JmQOPcLma0GkNvy9p5JVv3O+rhfj7K1Tw4ZlpQvpvx5mEsbgxhbctd1Ts9kZgwwnhPRJgoSn1U7B7+8uY+/QEE0v+knh3Inw54Qhe1KzNrU5bk87lHu8Ow1vA==';
        $aop->format = "json";
        $aop->charset = "UTF-8";
        $aop->signType = "RSA2";
        $aop->alipayrsaPublicKey ='MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAq+W/iPJHsjIlHdS8yb44xMIJYXkLlEK2FrM8vhKy3+r7FS4OAr+g4W87Sr0M36UoyzlikRhw57ES0a2evRqKrGOAfZ8ZSxUKZwJeE1aeDuyaL44fzcV3KzrlNLhbMapf2lV7AM3XVAwpzoFIyTUGuyceDp2cCpDwGAq7KcXQ2hQKIQztVx6xQ0DM16R2O0Xf+vATLZpAveSTyb5Z+Zh8MHqYdpZ1FEYGRSYcsw8Fk28xNtOgycrO7wha0zhJGlQCI9LdByaqi8w4CP9faCj0mYr3t7Rq3ZFs1EDpCkln5RBA7EypLU7g18UcDHl7RRQSUWu2fvQ+A3j356lHpv8y3QIDAQAB';//请填写支付宝公钥，一行字符串
//实例化具体API对应的request类,类名称和接口名称对应,当前调用接口名称：alipay.trade.app.pay
        $request = new AlipayTradeAppPayRequest();
//SDK已经封装掉了公共参数，这里只需要传入业务参数
        /*$bizcontent = "{\"body\":\"我是测试数据\","
            . "\"subject\": \"App支付测试\","
            . "\"out_trade_no\": \"20170125test01\","
            . "\"timeout_express\": \"30m\","
            . "\"total_amount\": \"0.01\","
            . "\"product_code\":\"QUICK_MSECURITY_PAY\""
            . "}";*/
        $bizcontent=$json;
        $request->setNotifyUrl(env('assets').'/alipay/alipayNotify');
        $request->setBizContent($bizcontent);
        //这里和普通的接口调用不同，使用的是sdkExecute
        $response = $aop->sdkExecute($request);
        //htmlspecialchars是为了输出到页面时防止被浏览器将关键参数html转义，实际打印到日志以及http传输不会有这个问题
        return htmlspecialchars($response);//就是orderString 可以直接给客户端请求，无需再做处理。
    }
    /**
     * @param $OrderInfo
     * @return mixed|string
     */
    protected  function GetGoodsTitle($OrderInfo){
        $title = "";
        foreach ($OrderInfo as $key => $vey) {
            if(count($OrderInfo) > 1){
                if ($title == "") {
                    $set_tit = Goods::find($vey['id']);
                    if ($set_tit) {
                        $title = $set_tit->goods_title . '等多件商品';
                    }
                }
            }else{
                if ($title == "") {
                    $set_tit = Goods::find($vey['id']);
                    if ($set_tit) {
                        $title = $set_tit->goods_title;
                    }
                }
            }

        }
        return $title;
    }
    

    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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


}
