@extends('Admin.layout.main')

@section('title', '订单详情')
@section('header_related')
   <link rel="stylesheet" href="{{ url('/css/style.css') }}" type="text/css">

@endsection
@section('content')
    <!--<div class="main-container">
        <div class="container-fluid">
            @include('Admin.layout.breadcrumb', [
                'title' => '添加文章',
                '' => [
                    '' => '',
                ]
            ])
        </div>
     </div>-->

<div class="Iartice">
    <div class="IAhead"><strong style="padding-right: 10px;">订单详情</strong><a href="{{ route('artice.order') }}">订单列表</a>|<a href="{{ route('artice.order') }}">已发货</a>|<a href="{{ route('artice.order') }}">未发货</a>|<a href="{{ route('artice.order') }}">已完成</a>|<a href="{{ route('artice.order') }}">已作废</a>|<a href="{{ route('artice.order') }}">待收货</a>|</div>
    <div class="IAMAIN">
        <div class="xORder">
            <div class="xqorder">
                <div class="xqO_img"><img src="{{url('images/c3.jpg')}}"></div>
                <h3>功能实木婴儿餐椅儿童餐椅 宝宝餐桌椅 可爱小熊坐垫</h3>
            </div>
        </div>

        <div class="xORder" style="background: #eee; width:800px; padding: 10px 25px; margin-bottom: 100px;">
            <form method="post" action="">
            <table width="100%"  cellspacing="0" cellpadding="0" >
                <tr><td>订单号：</td>
                    <td>255561ljnojo</td>
                </tr>
                <tr><td>商品价格：</td>
                    <td>500.00</td>
                </tr>
                <tr><td>购买用户：</td>
                    <td>13711174990</td>
                </tr>
                <tr><td>购买人昵称：</td>
                    <td>铃铛宝贝</td>
                </tr>
                <tr><td>购买人邮箱：</td>
                    <td></td>
                </tr>
                <tr><td>购买人手机：</td>
                    <td>13711174990</td>
                </tr>
                <tr><td>购买时间：</td>
                    <td>2016-03-23 17:50</td>
                </tr>
                <tr><td>收货地址：</td>
                    <td>广州市海珠区怡安路财京公馆515室</td>
                </tr>
                <tr><td>购买方式：</td>
                    <td>支付宝</td>
                </tr>
                <tr><td>当前状态：</td>
                    <td>已付款,未发货,未完成</td>
                </tr>
            </table>
            </form>
        </div>
    </div>
</div>

@endsection
@section('footer_related')
@endsection
