<?php

namespace App\Http\Controllers\Admin;

use Input;
use Log;
use Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Snoopy;

class PaymentController extends Controller
{






    /**
     *http://www.kuaidi100.com/openapi/applypoll.shtml
     * 查询物流
     */
    public function GetLogistics(){
        $typeCom = Input::get('Exname');//快递公司
        $typeNu = Input::get('TrackNum');  //快递单号
        //$typeCom='韵达';
        // $typeNu = "3831005363387";  //快递单号
       switch ($typeCom){
           case '韵达':
               $typeCom='yunda';
               break;
           case '顺丰':
               $typeCom='shunfeng';
               break;
           case '圆通':
               $typeCom='yuantong';
               break;
       }
        $AppKey='6e684fc8c2e71fb0';//请将XXXXXX替换成您在http://kuaidi100.com/app/reg.html申请到的KEY
        //$url='http://www.kuaidi100.com/applyurl?key='.$AppKey.'&com='.$typeCom.'&nu='.$typeNu.'&show=0&muti=1&order=desc';//拿到一条url地址
        //$url='http://api.kuaidi100.com/api?id='.$AppKey.'&com='.$typeCom.'&nu='.$typeNu.'&show=0&muti=1&order=desc';//api接口
        $url='https://m.kuaidi100.com/query?type='.$typeCom.'&postid='.$typeNu.'&id=1&valicode=&temp=0.9532360459069493';
        $httpGet = file_get_contents($url);
        return json_encode(['sta'=>'1','msg'=>'请求成功','data'=>$httpGet]);
       //请勿删除变量$powered 的信息，否者本站将不再为你提供快递接口服务。
       //$powered = '查询数据由：<a href="http://kuaidi100.com" target="_blank">KuaiDi100.Com （快递100）</a> 网站提供 ';
       //优先使用curl模式发送数据
        /*if (function_exists('curl_init') == 1){
            $curl = curl_init();
            curl_setopt ($curl, CURLOPT_URL, $url);
            curl_setopt ($curl, CURLOPT_HEADER,0);
            curl_setopt ($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt ($curl, CURLOPT_USERAGENT,$_SERVER['HTTP_USER_AGENT']);
            curl_setopt ($curl, CURLOPT_TIMEOUT,5);
            $get_content = curl_exec($curl);
            curl_close ($curl);
        }else{
            $snoopy = new Snoopy();
            $snoopy->referer = 'http://www.google.com/';//伪装来源
            $snoopy->fetch($url);
            $get_content = $snoopy->results;
        }*/
    }

    public function webpayment(){
        // 创建支付单。
        $alipay = app('alipay.web');
        $alipay->setOutTradeNo('460557839830574016');
        $alipay->setTotalFee('0.01');
        $alipay->setSubject('测试商品');
        $alipay->setBody('goods_description');
        $alipay->setQrPayMode('4'); //该设置为可选，添加该参数设置，支持二维码支付。
        // 跳转到支付页面。
        return redirect()->to($alipay->getPayLink());
    }

    /**
     * 异步通知
     */
    public function webNotify()
    {
        // 验证请求。
        if (! app('alipay.web')->verify()) {
            Log::notice('Alipay notify post data verification fail.', [
                'data' => Request::instance()->getContent()
            ]);
            return 'fail';
        }

        // 判断通知类型。
        switch (Input::get('trade_status')) {
            case 'TRADE_SUCCESS':
            case 'TRADE_FINISHED':
                // TODO: 支付成功，取得订单号进行其它相关操作。
                Log::debug('Alipay notify post data verification success.', [
                    'out_trade_no' => Input::get('out_trade_no'),
                    'trade_no' => Input::get('trade_no')
                ]);
                break;
        }

        return 'success';
    }

    /**
     * 同步通知
     */
    public function webReturn()
    {
        // 验证请求。
        if (! app('alipay.web')->verify()) {
            Log::notice('Alipay return query data verification fail.', [
                'data' => Request::getQueryString()
            ]);
            return view('alipay.fail');
        }

        // 判断通知类型。
        switch (Input::get('trade_status')) {
            case 'TRADE_SUCCESS':
            case 'TRADE_FINISHED':
                // TODO: 支付成功，取得订单号进行其它相关操作。
                Log::debug('Alipay notify get data verification success.', [
                    'out_trade_no' => Input::get('out_trade_no'),
                    'trade_no' => Input::get('trade_no')
                ]);
                break;
        }

        return view('alipay.success');
    }


    /**
     * @return mixed
     * 手机支付请求
     * 订单好，价格，商品名称，
     */
    public function mobile_alipay(){
        // 创建支付单。
        $alipay = app('alipay.mobile');
        $alipay->setOutTradeNo('order_id');
        $alipay->setTotalFee('order_price');
        $alipay->setSubject('goods_name');
        $alipay->setBody('goods_description');

        // 返回签名后的支付参数给支付宝移动端的SDK。
        return $alipay->getPayPara();
    }







    /**
     * 支付宝异步通知
     */
    public function alipayNotify()
    {
        // 验证请求。
        if (! app('alipay.mobile')->verify()) { //支付失败返回
            Log::notice('Alipay notify post data verification fail.', [
                'data' => Request::instance()->getContent()
            ]);
            return 'fail';
        }

        // 判断通知类型。
        switch (Input::get('trade_status')) {  //判断成功操作
            case 'TRADE_SUCCESS':
            case 'TRADE_FINISHED':
                // TODO: 支付成功，取得订单号进行其它相关操作。
                //更新订单表状态。
                Log::debug('Alipay notify get data verification success.', [
                    'out_trade_no' => Input::get('out_trade_no'),
                    'trade_no' => Input::get('trade_no')
                ]);
                break;
        }

        return 'success';
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
