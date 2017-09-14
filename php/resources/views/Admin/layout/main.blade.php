<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="金融后台管理">
    <meta name="author" content="">
    <title>@yield('title') - 铃铛后台管理</title>
    <link href="/getAvatar.ico" rel="shortcut icon"/>
    <link rel="stylesheet" href="{{ url('/css/main.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ url('/static/css/common.css') }}" type="text/css">
    {{--<link rel="Shortcut Icon" href="/favicon.png" />--}}
    {{--<link rel="Bookmark" href="/favicon.png" />--}}
    <script src="/js/jquery-1.11.2.min.js"></script>
    <script src="{{url("js/layer/layer.js")}}"></script>
    <!--Page's related css-->
    @yield('header_related')
</head>
<body>
<div class="bb-alert alert alert-success noty_animated fadeInUp">
    <span>{{--Table Callback Demo Content--}}</span>
</div>

<div class="page-container list-menu-view">
    <!--Left bar Start Here -->
    @include('Admin.layout.leftbar')

    <div class="page-content">
        <!--Top bar Start Here -->
        @include('Admin.layout.topbar')

        <!-- Content -->
        @yield('content')

        <!--Footer Start Here 
        <footer class="footer-container">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <div class="footer-left">
                            <span>&copy; 2016 <a href="#">金融管理后台</a></span>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="footer-right">
                        </div>
                    </div>
                </div>
            </div>
        </footer>-->
    </div>
</div>

<!--Right bar Start Here -->
{{--@include('layout.rightbar')--}}
<script id="token">
    window._token = "{{csrf_token()}}";
</script>
<script id="user_id">
    {{Auth::id()}}

</script>


<script src="/js/jquery-2.1.4.min.js?v={{ env('VERSION') }}"></script>

{{--<script src="/js/jquery-migrate-1.2.1.min.js"></script>--}}
<!--Load Mask-->
<script src="/js/jquery.loadmask.js?v={{ env('VERSION') }}"></script>
<script src="/js/jRespond.min.js?v={{ env('VERSION') }}"></script>
<script src="/js/bootstrap.min.js?v={{ env('VERSION') }}"></script>
<script src="/js/nav-accordion.js?v={{ env('VERSION') }}"></script>
<script src="/js/hoverintent.js?v={{ env('VERSION') }}"></script>
<!--Materialize Effect-->
<script src="/js/waves.js?v={{ env('VERSION') }}"></script>
<!--Smart Resize-->
<script src="/js/smart-resize.js?v={{ env('VERSION') }}"></script>
{{--js调用参考, 不要去掉注释--}}
<script src="/js/sea.js?v={{ env('VERSION') }}"></script>
<script src="{{url('js/layer/layer.js')}}"></script>
<script>
    seajs.config({
        dir_app : '/static/js/',
    })
</script>

@yield('footer_related')


        <!--Layout Initialize-->
<script src="/js/layout.init.js?v={{ time() }}"></script>
<script src="/js/matmix.init.js?v={{ time() }}"></script>
<!--High Resolution Ready-->
<script src="/js/retina.min.js?v={{ time() }}"></script>



</body>
</html>
