@extends('Admin.layout.main')

@section('title', '订单管理')
@section('header_related')
   <link rel="stylesheet" href="{{ url('/css/style.css') }}" type="text/css">

@endsection
@section('content')
    <!--<div class="main-container">
        <div class="container-fluid">
            @include('Admin.layout.breadcrumb', [
                'title' => '订单列表',
                '' => [
                    '' => '',
                ]
            ])
        </div>
     </div>-->

<div class="Iartice">
    <div class="IAhead"><strong style="padding-right: 10px;">订单管理</strong><a href="{{ route('artice.order') }}">订单列表</a>|<a href="{{ route('artice.B_dingdan_completelist') }}">已完成</a>|<a href="{{ route('artice.B_dingdan_deliverylist') }}">已发货</a>|<a href="{{ route('artice.B_dingdan_Nodeliverylist') }}">未发货</a>|<a href="{{ route('artice.B_dingdan_backlist') }}">退单</a>|</div>
    <div class="IAMAIN_list">
        <div class="Alist">
            <form method="post" action="">
            <table width=""  cellspacing="0" cellpadding="0" style="float: right; margin-right: 30px;">
                <tr>
                    <td align="right">关键字：</td>
                    <td><input type="text" value="" class="Iar_list" /></td> 
                    <td><input type="submit" name="dosubmit" class="button" value="搜 索"></td>
                </tr> 
            </table>
            </form>
        </div>

        <div class="Alist">
                <form method="post" action="">
                    <table width="100%" cellspacing="0" cellpadding="0">
                        <tr class="Alist_head">
                        	<th style="width: 150px;">订单号</th>
                            <th>商品标题</th>  
                            <th style="width: 120px;">商品类型</th>
                            <th style="width: 150px;">购买用户</th>
                            <th style="width: 100px;">购买总价</th>
                            <th style="width: 180px;">购买日期</th>
                            <th style="width: 100px;">订单状态</th>
                            <th>备注</th>
                            <th style="width: 100px;">管理操作</th>
                        </tr>
                        @if(isset($orderList) && !empty($orderList))
                            @foreach($orderList as $key =>$vel)
                                <tr class="Alist_main">
                                    <td class="IMar_list"/>{{$vel['order_id']}}</td>
                                    <td>{{$vel['goods_name']}}</td>
                                    <td>直购系列</td>
                                    <td>{{$vel['username']}}</td>
                                    <td><font color="red">￥{{$vel['order_price']}}</font></td>
                                    <td>{{$vel['created_at']}}</td>
                                    <td>@if($vel['status']=='0')
                                            待支付
                                    @endif
                                    </td>
                                    <td>暂无</td>
                                    <td><a href="{{ route('artice.B_dingdan_read').'?order_id='.$vel['order_id'] }}">查看</a></td>
                                </tr>
                                @endforeach
                        @endif
                        {{--<tr class="Alist_main">
                            <td class="IMar_list"/>1dfs5654445</td>
                            <td>安徽省-蚌埠市-禹会区</td>
                            <td>直购系列</td>
                            <td>1171801173</td>
                            <td><font color="red">￥0.0</font></td>
                            <td>2017-07-19</td>
                            <td>安徽省-蚌埠市-禹会区</td>
                            <td>已完成</td>
                            <td>如果是退单的退单原因</td>
                            <td><a href="{{ route('artice.B_dingdan_read') }}">查看</a></td>
                        </tr>--}}
                        
                    </table>
                </form>
            </div>
    </div>
</div>

@endsection
@section('footer_related')
@endsection
