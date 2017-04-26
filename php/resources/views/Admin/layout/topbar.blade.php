<header class="top-bar">
    <div class="container-fluid top-nav">
        <div class="search-form search-bar">
            <form>
                <input name="searchbox" value="" placeholder="Search Topic..." class="search-input">
            </form>
            <span class="search-close waves-effect"><i class="ico-cross"></i></span>
        </div>
        <div class="row">
            <div class="col-md-2">
                <div class="clearfix top-bar-action">
                    <span class="leftbar-action-mobile waves-effect"><i class="fa fa-bars "></i></span>
                    <span class="leftbar-action desktop waves-effect"><i class="fa fa-bars "></i></span>
                    {{--<span class="waves-effect search-btn mobile-search-btn"><i class="fa fa-search"></i></span>--}}
                    {{--<span class="rightbar-action waves-effect"><i class="fa fa-bars"></i></span>--}}
                </div>
            </div>
            <div class="col-md-4 responsive-fix top-mid">
            </div>
            <div class="col-md-6 responsive-fix">
                <div class="top-aside-right">
                    <div class="user-nav" style="   margin-right: 0">
                        <ul>
                            <li class="dropdown">
                                <a data-toggle="dropdown" href="#" class="clearfix dropdown-toggle waves-effect waves-block waves-classic">
                                    <span class="user-info">{{ Auth::user()->name }} <cite>{{ Auth::user()->real_name }}</cite></span>
                                    @if(isset(Auth::user()->avatar) && Auth::user()->avatar!=null)
                                        <span class="user-thumb"><img src="{{ md52url(Auth::user()->avatar, false, '') }}" alt="image"></span>
                                        @else
                                        <span class="user-thumb"><img src="{{url('/images/touxiang_gg.jpg')}}" alt="image"></span>
                                    @endif
                                </a>
                                <ul role="menu" class="dropdown-menu fadeInUp">

                                    <li><a href="{{ route('user.my') }}"><span class="user-nav-icon"><i class="fa fa-user"></i></span><span class="user-nav-label">我的资料</span></a>
                                    </li>

                                    <li><a href="{{ route('user.logout') }}"><span class="user-nav-icon"><i class="fa fa-lock"></i></span><span class="user-nav-label">退出登陆</span></a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-6 responsive-fix top-mid" style="float: right;padding-right: 47px;">
                        <div class="notification-nav">
                        </div>
                        <div class="pull-left mobile-search">
						<span class=" waves-effect search-btn">
						<i class="fa fa-search"></i>
						</span>
                        </div>
                    </div>
                    {{--<span class="rightbar-action waves-effect"><i class="fa fa-bars"></i></span>--}}
                </div>
            </div>
        </div>
    </div>
</header>



