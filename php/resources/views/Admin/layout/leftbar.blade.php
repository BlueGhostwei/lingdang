<div class="left-aside desktop-view">

        <a href="{{ url('/') }}" class="iconic-logo">
            {{--<img class="common-page-logo"  src="{{url('/images/shengshilong.jpg')}} " alt="Matmix Logo" style="width: 260px">--}}
        </a>


    <div class="left-navigation">
        <ul class="list-accordion">
            <li>
                <a href="{{url('/')}}" class="{{ mla('DashboardController@index') }}">
                    <span class="nav-icon"><i class="fa fa-dashboard"></i></span>
                    <span class="nav-home">首页</span>
                </a>
            </li>
             <li>
                <a href="#" class="waves-effect {{ mla('SystemController') }}">
                    <span class="nav-icon"><i class="ico-hammer-wrench"></i></span>
                    <span class="nav-label">内容管理</span>
                </a>
                <ul>
                    <li><a href="{{ route('artice.index') }}">添加内容</a></li>
                    <li><a href="{{ route('artice.artice_list') }}">内容列表</a></li>
                    <li><a href="{{ route('artice.A_fenlei') }}">内容分类</a></li>

                </ul>
            </li>
            <li>
                <a href="#" class="waves-effect {{ mla('SystemController') }}">
                    <span class="nav-icon"><i class="ico-hammer-wrench"></i></span>
                    <span class="nav-label">商品管理</span>
                </a>
                <ul>
                    <li><a href="{{ route('goods.Add_goods') }}">添加商品</a></li>
                    <li><a href="{{ route('goods.goods_list') }}">商品列表</a></li>
                    <li><a href="{{ route('artice.goods') }}">商品分类</a></li>
                    <li><a href="{{ route('artice.Add_brand') }}">添加品牌</a></li>
                    <li><a href="{{ route('artice.brand_list') }}">品牌列表</a></li>
                    <li><a href="{{ route('artice.order') }}">订单列表</a></li>

                </ul>
            </li>
            <li>
                <a href="#" class="waves-effect {{ mla('Acl*Controller') }}">
                    <span class="nav-icon"><i class="ico-push-pin"></i></span>
                    <span class="nav-label">界面设置</span>
                </a>
                <ul>
                    <li><a href="{{ route('artice.Add_slide') }}">添加幻灯片</a></li>
                    <li><a href="{{ route('photo.slide') }}">幻灯管理</a></li>
                </ul>
            </li>
            <li>
                <a href="#" class="waves-effect {{ mla('UserController') }}">
                    <span class="nav-icon"><i class="fa fa-user"></i></span>
                    <span class="nav-label">会员管理</span>
                </a>
                <ul>
                    <li><a href="{{route('Bells.member_list') }}">会员列表</a></li>
                    <li><a href="{{route('artice.chongzhi') }}">充值记录</a></li>
                    <li><a href="{{route('artice.consumption')}}">消费记录</a></li>
                </ul>
            </li>
        </ul>
    </div>
</div>
