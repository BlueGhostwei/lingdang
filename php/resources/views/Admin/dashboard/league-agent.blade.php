@extends('Admin.layout.main')

@section('title', '首页')
@section('header_related')
<link rel="stylesheet" href="{{ url('/css/style.css') }}" type="text/css">
@endsection
@section('content')
   <!-- <div class="main-container">
        <div class="container-fluid">
            @include('Admin.layout.breadcrumb', [
                'title' => '首页',
                '' => [
                    '' => '',
                ]
            ])
        </div>

        </div>-->
<div class="Imain">
    <div class="container">
        <div class="centermain">
            <div class="templatemo_link" style="background: #cc9933; margin-bottom: 15px;"><a href="">添加商品</a></div>
            <div class="img_Imain"><img src="{{url('images/templatemo_home1.jpg')}}" alt="logo"></div>
        </div>
        <div class="centermain">
            <div class="img_Imain"><img src="{{url('images/templatemo_home2.jpg')}}" alt="logo"></div>
            <div class="templatemo_link" style="background: #993333; margin-top: 15px;"><a href="">管理员</a></div>
        </div>
        <div class="centermain">
            <div class="templatemo_link" style="background: #1ab394; margin-bottom: 15px;"><a href="">会员管理</a></div>
            <div class="img_Imain"><img src="{{url('images/templatemo_home3.jpg')}}" alt="logo"></div>
        </div>
        <div class="centermain">
            <div class="img_Imain"><img src="{{url('images/templatemo_home2.jpg')}}" alt="logo"></div>
            <div class="templatemo_link" style="background: #006699; margin-top: 15px;"><a href="">退出</a></div>
        </div>
    </div>
</div>


@endsection
@section('footer_related')
@endsection


<script src="/js/jquery-1.11.2.min.js"></script>
<script>
    $(function (){
        $('.list-accordion a:first').addClass('active');
        var $store_box = $('.store-box');
        for (var i = 0, len = $store_box.length; i < len; i++){
            if ((i+1)%6 == 0){
                $store_box[i].style.marginRight = 0 +'px';
            }
        }

    })
</script>

