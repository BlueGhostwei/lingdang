@extends('Admin.layout.main')

@section('title', '商品分类管理')
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
    <div class="IAhead"><strong style="padding-right: 10px;">商品分类管理</strong><a href="{{ route('artice.goods') }}">分类列表</a>|<a href="{{ route('artice.Add_brand') }}">添加分类</a>|<a href="{{ route('artice.goods_list') }}">商品列表</a>|<a href="{{ route('artice.brand_list') }}">品牌列表</a>|</div>
    <div class="IAMAIN_list">
        <div class="Alist">
            <form method="post" action="">
            <table width="100%"  cellspacing="0" cellpadding="0" >
                <tr class="Alist_head">
                    <th style="width: 80px;">排序</th>
                    <th style="text-align: left; padding-left: 20px;">栏目名称</th>
                    <th style="width: 250px">操作</th>
                </tr>
                <tr class="Alist_main">
                    <td class="IMar_list" style="font-weight: 700;" />1</td>
                    <td style="text-align: left; padding-left: 20px;">可米宝贝</td>
                    <td><a href="{{ route('artice.Add_subtopic') }}">添加子栏目 </a>|<a href=""> 修改 </a>|<a href=""> 删除</a></td>
                </tr>
                <tr class="Alist_main">
                    <td class="IMar_list" />1</td>
                    <td style="text-align: left; padding-left: 20px;">├─ 可米宝贝</td>
                    <td><a href=""> 修改 </a>|<a href=""> 删除</a></td>
                </tr>
                <tr class="Alist_main">
                    <td class="IMar_list" />2</td>
                    <td style="text-align: left; padding-left: 20px;">├─ 可米宝贝</td>
                    <td><a href=""> 修改 </a>|<a href=""> 删除</a></td>
                </tr>
                <tr class="Alist_main">
                    <td class="IMar_list" />3</td>
                    <td style="text-align: left; padding-left: 20px;">├─ 可米宝贝</td>
                    <td><a href=""> 修改 </a>|<a href=""> 删除</a></td>
                </tr>
                <tr class="Alist_main">
                    <td class="IMar_list" style="font-weight: 700;"/>2</td>
                    <td style="text-align: left; padding-left: 20px;">可米宝贝</td>
                    <td><a href="{{ route('artice.Add_subtopic') }}">添加子栏目 </a>|<a href=""> 修改 </a>|<a href=""> 删除</a></td>
                </tr>
            </table>
            </form>
        </div>
    </div>
</div>

@endsection
@section('footer_related')
@endsection
