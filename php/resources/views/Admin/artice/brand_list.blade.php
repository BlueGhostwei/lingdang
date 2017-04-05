@extends('Admin.layout.main')

@section('title', '品牌管理')
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
    <div class="IAhead"><strong style="padding-right: 10px;">品牌管理</strong><a href="{{ route('artice.brand_list') }}">品牌列表</a>|<a href="{{ route('artice.Add_brand') }}">添加品牌</a>|<a href="{{ route('artice.goods_list') }}">商品列表</a>|<a href="{{ route('artice.Add_goods') }}">添加商品</a>|</div>
    <div class="IAMAIN_list">
        <div class="Alist">
            <form method="post" action="">
            <table width="100%"  cellspacing="0" cellpadding="0" >
                <tr class="Alist_head">
                    <th style="width: 80px;">排序</th>
                    <th>品牌名称</th>
                    <th>所属栏目</th>
                    <th>操作</th>
                </tr>
                <tr class="Alist_main">
                    <td class="IMar_list" />1</td>
                    <td>可米宝贝</td>
                    <td >[宝宝服饰]&nbsp;&nbsp;[婴儿鞋帽袜]</td>
                    <td><a href="{{ route('artice.Add_brand') }}">修改 </a>|<a href=""> 删除</a></td>
                </tr>
            </table>
            </form>
        </div>
    </div>
</div>

@endsection
@section('footer_related')
@endsection
