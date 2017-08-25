@extends('Admin.layout.main')

@section('title', '账户查询')
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
    <div class="IAhead"><strong style="padding-right: 10px;">账户查询</strong><a href="{{ route('artice.consumption') }}">消费记录</a>|<a href="{{ route('artice.chongzhi') }}">充值记录</a>|<a href="{{ route('Bells.member_list') }}">会员列表</a>|<a href="{{ route('artice.member') }}">添加会员</a>|</div>
    <div class="IAMAIN_list">
        <div class="Alist">
            <form method="post" action="">
            <table width=""  cellspacing="0" cellpadding="0" style="float: right; margin-right: 30px;">
                <tr>
                    <td>            
                        <select name="cateid">
                            <option>用户名</option>
                            <option>订单号</option>
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
                    <th>用户名</th>
                    <th>订单号</th>
                    <th>商品类型</th>
                    <th>商品名称</th>
                    <th>消费金额</th>
                    <th style="width: 150px;">时间</th>
                </tr>
                <tr class="Alist_main">
                    <td class="IMar_list" />1</td>
                    <td>13711174990</td>
                    <td>255561ljnojo</td>
                    <td>童装上衣</td>
                    <td>童装上衣</td>
                    <td><font color="red">￥228.00</font></td>
                    <td>2017-3-30 20:12</td>
                </tr>
            </table>
            </form>
        </div>
    </div>
</div>

@endsection
@section('footer_related')
@endsection
