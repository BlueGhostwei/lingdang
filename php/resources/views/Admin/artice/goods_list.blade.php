@extends('Admin.layout.main')

@section('title', '商品管理')
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
    <div class="IAhead"><strong style="padding-right: 10px;">商品管理</strong></div>
    <div class="IAMAIN">
        <div class="Alist" style="background: #e9eaea">
            <form method="post" action="">
            <table width=""  cellspacing="0" cellpadding="0" style="float: right; margin-right: 30px;">
                <tr>
                    <td>            
                        <select name="cateid">
                            <option>直购商品</option>
                            <option>积分商品</option>
                            <option>商品名称</option>
                        </select>           
                    </td>
                    <td>            
                        <select name="cateid">
                            <option>ID排序</option>
                        </select>           
                    </td>
                    <td align="right">关键字：</td>
                    <td><input type="text" value="" class="Iar_list" /></td> 
                    <td><input type="submit" name="dosubmit" class="button" value="搜 索"></td>
                </tr> 
            </table>
            </form>
        </div>
        <div class="Goodslist">
            <div class="GoodsLmain">
                <div><img src="{{url('images/c3.jpg')}}"></div>
                <div class="GoodsML_head"><font color="red">¥99.00</font><span>已兑换/总库存：<font color="red">0/50</font></span></div>
                <div class="GoodsML_head">功能实木婴儿餐椅儿童餐椅 宝宝餐桌椅 可爱小熊坐垫</div>
                <div class="Gbottom">
                    <div class="jifen"><a href="">加入积分商城</a></div>
                    <div class="zhigou"><a href="">加入直购商城</a></div>
                    <a href="">查看详情</a>
                    <a href="">删除</a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('footer_related')
@endsection
