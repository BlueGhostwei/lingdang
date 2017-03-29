@extends('Admin.layout.main')

@section('title', '首页')
@section('header_related')
    <style>

    </style>
@endsection
@section('content')
    <div class="main-container">
        <div class="container-fluid">
            @include('Admin.layout.breadcrumb', [
                'title' => '首页',
                '' => [
                    '' => '',
                ]
            ])
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

