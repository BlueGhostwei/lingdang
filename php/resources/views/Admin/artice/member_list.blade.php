@extends('Admin.layout.main')

@section('title', '会员管理')
@section('header_related')
    <link rel="stylesheet" href="{{ url('/css/style.css') }}" type="text/css">

    @endsection
    @section('content')
            <!--<div class="main-container">
        <div class="container-fluid">
            @include('Admin.layout.breadcrumb', [
                'title' => '会员管理',
                '' => [
                    '' => '',
                ]
            ])
            </div>
         </div>-->

    <div class="Iartice">
        <div class="IAhead"><strong style="padding-right: 10px;">会员管理</strong><a
                    href="{{ route('Bells.member_list') }}">会员列表</a>|<a href="{{ route('artice.member') }}">添加会员</a>|<a
                    href="{{ route('artice.chongzhi') }}">充值记录</a>|<a href="{{ route('artice.consumption') }}">消费记录</a>|
        </div>
        <div class="IAMAIN_list">
            <div class="Alist">
                <form method="post" action="">
                    <table width="" cellspacing="0" cellpadding="0" style="float: right; margin-right: 30px;">
                        <tr>
                            <td><input type="text" value="" class="Iar_list"/></td>
                            <td><input type="submit" name="dosubmit" class="button" value="搜 索"></td>
                        </tr>
                    </table>
                </form>
            </div>

            <div class="Alist">
                <form method="post" action="">
                    <table width="100%" cellspacing="0" cellpadding="0">
                        <tr class="Alist_head">
                            <th style="width: 80px;">UID</th>
                            <th>用户名</th>
                            <th>昵称</th>
                            <th>手机</th>
                            <th>邮箱</th>
                            <th>地址</th>
                            <th>账户余额</th>
                            <th style="width: 130px;">管理操作</th>
                        </tr>
                        <tr class="Alist_main">
                            @if(isset($member_list) && count($member_list)!='')
                                @foreach($member_list as $key =>$vay)
                                    <td class="IMar_list" />{{$vay['id']}}</td>
                                    <td>{{$vay['name']}}</td>
                                    <td>{{$vay['nickname']}}</td>
                                    <td>{{$vay['phone']}}</td>
                                    <td>{{$vay['email']}}</td>
                                    <td>{{$vay['location']}}</td>
                                    <td><font color="red">￥228.00</font></td>
                                    <td><a href="">修改 </a>|<a href=""> 删除</a></td>
                                @endforeach
                                @else
                                <td class="IMar_list" />1</td>
                                <td>铃铛</td>
                                <td>铃铛宝贝</td>
                                <td>13711174990</td>
                                <td>1171801173@qq.com</td>
                                <td>广州市海珠区怡安路财京公馆515室</td>
                                <td><font color="red">￥228.00</font></td>
                                <td><a href="">修改 </a>|<a href=""> 删除</a></td>
                            @endif
                        </tr>
                    </table>
                </form>
            </div>
        </div>
    </div>

@endsection
@section('footer_related')
@endsection
