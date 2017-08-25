<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="金融管理后台">
<meta name="author" content="udpower">
<title>铃铛APP后台管理系统</title>
<link rel="stylesheet" href="{{ url('/css/main.css') }}" type="text/css">
</head>
<body class="login-page">
<div class="page-container">
    <div class="login-branding">
        <a href="{{ url('/') }}"><img src="{{url('images/getAvatar.do.jpg')}}" alt="logo"></a>
    </div>
    <div class="login-container">

        <div style="text-align: center;font-size: 20px;color: #808080;font-weight: bold">铃铛APP后台管理系统</div>
        <form action="{{ route('user.login') }}" method="post" class="form-signin">
            {!!csrf_field()!!}
            <input type="text" name="username" id="inputEmail" class="form-control floatlabel " value="" placeholder="用户名或邮箱" required autofocus >
            <input type="password" name="password" id="inputPassword" class="form-control floatlabel " value="" placeholder="密码" required >
            <div id="remember" class="checkbox">
                <label>
                    <input type="checkbox" name="remember" class="switch-mini" /> 记住我
                </label>
            </div>
            <button style="background-color:#FACE08; border-color: #FACE08; font-size: 16px; font-weight: 700; color: #5C5447" class="btn btn-primary btn-block btn-signin" type="submit">登 入</button>
        </form>
        <a href="{{ route('password.email') }}" class="forgot-password">忘记密码</a>
        @if(Session::has('message'))
            <span>{{ Session::get('message') }}</span>
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
