<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="百信店管理登陆">
    <meta name="author" content="udpower">
    <title>登入 - 百信店管理登陆</title>
    <link rel="stylesheet" href="{{ url('/css/main.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ url('/css/login.css') }}" type="text/css">
</head>
<body class="login-page">
<div class="page-container">
    <div class="login-branding">
        <a href="{{ url('/') }}"><img src="/images/logo-large.png" alt="logo"></a>
    </div>
    <div class="login-container">
        <img class="login-img-card" src="/images/avatar/jaman-01.jpg" alt="login thumb" />
        {{--<form action="{{ route('password.reset', '') }}" method="post" class="form-signin">
            {{ csrf_field() }}
            <input type="hidden" name="token" value="{{ $token }}">
            <input type="text" name="email" value="{{ old('email') }}" id="inputEmail" class="form-control floatlabel " placeholder="请确认邮箱" required autofocus>
            <input type="password" name="password" id="inputPassword" class="form-control floatlabel" placeholder="密码" required>
            <input type="password" name="password_confirmation" id="inputConfirmPassword" class="form-control floatlabel" placeholder="请再确认密码" required>
            <button class="btn btn-primary btn-block btn-signin" type="submit">重置密码</button>
        </form>--}}
        <form method="POST" action="{{route('password.reset')}}">
            {!! csrf_field() !!}
            <input type="hidden" name="token" value="{{ $token }}">

            <div>
                Email：<input type="email" name="email" value="{{ old('email') }}">
            </div>

            <div>
                新密码：<input type="password" name="password">
            </div>

            <div>
                确认密码：<input type="password" name="password_confirmation">
            </div>

            <div>
                <button type="submit">
                    重置密码
                </button>
            </div>
        </form>

        <a href="{{ route('user.login') }}" class="forgot-password">返回登录</a>

        @if ($errors->has('password'))
            <span>{{ $errors->first('password') }}</span>
        @else ($errors->has('email'))
            <span>{{ $errors->first('email') }}</span>
        @endif
    </div>

</div>
<script src="/js/jquery-1.11.2.min.js"></script>
<script src="/js/jquery-migrate-1.2.1.min.js"></script>
<script src="/js/jRespond.min.js"></script>
<script src="/js/bootstrap.min.js"></script>
<script src="/js/nav-accordion.js"></script>
<script src="/js/hoverintent.js"></script>
<script src="/js/waves.js"></script>
<script src="/js/switchery.js"></script>
<script src="/js/jquery.loadmask.js"></script>
<script src="/js/icheck.js"></script>
<script src="/js/bootbox.js"></script>
<script src="/js/animation.js"></script>
<script src="/js/colorpicker.js"></script>
<script src="/js/bootstrap-datepicker.js"></script>
<script src="/js/floatlabels.js"></script>
<script src="/js/smart-resize.js"></script>
<script src="/js/layout.init.js"></script>
<script src="/js/matmix.init.js"></script>
<script src="/js/retina.min.js"></script>
</body>
</html>
