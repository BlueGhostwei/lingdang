@extends('Admin.layout.main')

@section('title', '内容分类')
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
    <div class="IAhead"><strong style="padding-right: 10px;">分类管理</strong><a href="{{ route('artice.A_fenlei') }}">内容分类</a>|<a href="{{ route('artice.Add_fenlei') }}">添加分类</a>|</div>
    <div class="IAMAIN_list">
        <div class="Alist">
            <form method="post" action="">
            <table width="100%"  cellspacing="0" cellpadding="0" >
                <tr class="Alist_head">
                    <th style="width: 120px;">排序</th>
                    <th style="width: 150px;">catid</th>
                    <th>栏目名称</th>
                    <th>栏目类型</th>
                    <th  style="width: 250px;">管理操作</th>
                </tr>
                <tr class="Alist_main">
                    <td class="IMar_list" />1</td>
                    <td>20</td>
                    <td>最新资讯</td>
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
