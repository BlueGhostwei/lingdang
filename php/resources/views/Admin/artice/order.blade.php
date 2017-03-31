@extends('Admin.layout.main')

@section('title', '订单管理')
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
    <div class="IAhead"><strong style="padding-right: 10px;">订单管理</strong><a href="{{ route('artice.order') }}">订单列表</a>|<a href="{{ route('artice.order') }}">已发货</a>|<a href="{{ route('artice.order') }}">未发货</a>|<a href="{{ route('artice.order') }}">已完成</a>|<a href="{{ route('artice.order') }}">已作废</a>|<a href="{{ route('artice.order') }}">待收货</a>|</div>
    <div class="IAMAIN_list">
        <div class="Alist">
            <form method="post" action="">
            <table width=""  cellspacing="0" cellpadding="0" style="float: right; margin-right: 30px;">
                <tr>
                    <td>            
                        <select name="cateid">
                            <option>订单号</option>
                            <option>订单状态</option>
                            <option>商品名称</option>
                        </select>           
                    </td>
                    <td>            
                        <select name="cateid">
                            <option>时间排序</option>
                        </select>           
                    </td>
                    <td align="right">关键字：</td>
                    <td><input type="text" value="" class="Iar_list" /></td> 
                    <td><input type="submit" name="dosubmit" class="button" value="搜 索"></td>
                </tr> 
            </table>
            </form>
        </div>

        <div class="Alist">
            <form method="post" action="">
            <table width="100%"  cellspacing="0" cellpadding="0" >
                <tr class="Alist_head">
                    <th style="width: 80px;">排序</th>
                    <th>订单号</th>
                    <th>商品标题</th>
                    <th>购买用户</th>
                    <th>购买总价</th>
                    <th>购买日期</th>
                    <th>订单状态</th>
                    <th>操作</th>
                </tr>
                <tr class="Alist_main">
                    <td class="IMar_list" />1</td>
                    <td>255561ljnojo</td>
                    <td>童装上衣</td>
                    <td>13711174990</td>
                    <td><font color="red">￥228.00</font></td>
                    <td>2017-3-30 20:12</td>
                    <td>已付款,未发货,未完成</td>
                    <td><a href="{{ route('artice.order_XQ') }}"">详情</a></td>
                </tr>
            </table>
            </form>
        </div>
    </div>
</div>

@endsection
@section('footer_related')
@endsection
