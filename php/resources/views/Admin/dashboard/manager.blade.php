@extends('Admin.layout.main')

@section('title', '首页')
    <div class="page-container list-menu-view">
        <!--Left bar Start Here -->
        @include('Admin.layout.leftbar')
        <div class="page-content">
            <!--Top bar Start Here -->
            @include('Admin.layout.top')

            <!-- Content -->
            @yield('content')

            <!--Footer Start Here -->
            <footer class="footer-container">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6 col-sm-6">
                            <div class="footer-left">
                                {{--<span>&copy; 2015 <a href="#">美邻美家</a></span>--}}
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="footer-right">
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
@endsection
@section('footer_related')
    <script src="/js/bootbox.js"></script>
    <script src="/js/highcharts.js"></script>
@endsection