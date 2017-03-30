@extends('Admin.layout.main')

@section('title', '幻灯管理')
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
    <div class="IAhead"><strong style="padding-right: 10px;">幻灯管理</strong><a href="{{ route('artice.slide') }}">幻灯管理</a>|<a href="{{ route('artice.Add_slide') }}">添加幻灯片</a>|</div>
    <div class="IAMAIN_list">
        <div class="Alist">
            <form method="post" action="">
            <table width="100%"  cellspacing="0" cellpadding="0" >
                <tr class="Alist_head">
                    <th style="width: 120px;">排序</th>
                    <th>id</th>
                    <th>幻灯图片</th>
                    <th>链接地址</th>
                    <th  style="width: 250px;">管理操作</th>
                </tr>
                <tr class="Alist_main">
                    <td class="IMar_list" />1</td>
                    <td>20</td>
                    <td><img src="{{url('images/c3.jpg')}}" style="width:auto; height: 50px; margin: 5px 0;"></td>
                    <td>内容管理</td>
                    <td><a href="">修改 </a>|<a href=""> 删除</a></td>
                </tr>
            </table>
            </form>
        </div>
    </div>
</div>

@endsection
@section('footer_related')
@endsection
