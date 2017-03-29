@extends('Admin.layout.main')

@section('title', '我的资料')
@section('header_related')
    <style>
        .dis-in {
            display: inline-block;
        }

        .type-numb {
            font-size: 20px;
            color: red;
            line-height: 35px;
        }

        textarea {
            min-height: 100px;
        }

        a {
            cursor: pointer;
        }

        .c-gry {
            color: #454545;
        }

        .col-xs-6 {
            padding-left: 0;
        }

        .text-ring {
            display: -webkit-box;
            width: 35px;
            height: 35px;
            border: 1px solid #e1e1e1;
            border-radius: 25px;
            text-align: center;
            line-height: 35px;
            -webkit-box-align: center;
            -webkit-box-pack: center;
            margin-right: 5px;

        }

        .pad-left {
            padding-left: 34%;
        }

        .top-tic-item {
            -webkit-box-flex: 1;
            display: -webkit-box;
            margin-right: 10px;
            position: relative;
        }

        .top-tic-item .fa {
            display: none;
        }

        .top-tic-item .text-ring .num {
            color: #b7b7b7;
        }

        .top-tic-item.finish .fa {
            display: block;
        }

        .top-tic-item.finish .tic-text {
            color: #565656;
        }

        .top-tic-item.finish .num {
            display: none;
        }

        .tic-text {
            line-height: 34px;
            color: #b7b7b7;
        }

        .tio-tic-pay {
            position: absolute;
            bottom: -27px;
            left: 61px;
            display: block;
            font-size: 12px;
            font-weight: bold;
            padding: 1px 5px;
            border-radius: 4px;
            border: 1px solid #c00000;
            color: #454545;
        }

        .aff_type label {
            margin-right: 10px;
        }

        .store-address .col-lg-5 {
            padding: 0;
            width: 30%;
            margin-right: 10px;
        }

        #add_aff .control-label {
            width: 36%;
        }

        .feedback-item {
            margin-bottom: 10px;
        }

        .mar-r {
            margin-right: 15px;
        }

        .feedback-item small {
            display: block;
        }

        .f-r {
            float: right;
        }

        .imgPreViewBox img {
            width: 100px;
            height: 100px;
        }

        .imgPreViewBox {
            overflow: hidden;
        }

        .imgPreViewBox img:last-child {
            margin-right: 0;
        }

        .imgPreView-item {
            position: relative;
            float: left;
            margin-bottom: 10px;
            margin-right: 10px;
        }

        .imgPreViewi-close {
            position: absolute;
            top: 5px;
            right: 5px;
            -webkit-text-stroke: .2px #fff;
            color: #a94442;
            cursor: pointer;
        }

        .lc-SelNet-item {
            padding-left: 0;
        }
    </style>
@endsection
@section('content')
    <div class="main-container">
        <div class="container-fluid">
            @include('Admin.layout.breadcrumb', [
                'title' => '我的资料',
                'breadcrumb' => [
                '用户中心' => '',
                    '我的资料' => ''
                ]
            ])
            <div class="row">
                <div class="col-md-12">
                    <div class="box-widget widget-module">
                        <div class="widget-head clearfix">
                            <span class="h-icon"><i class="fa fa-file-text"></i></span>
                            <h4>我的资料</h4>
                        </div>
                        <div class="widget-container">
                            <div class=" widget-block">
                                <form id="user_create_form" {{--action="{{ route('user.update',$user->id) }}" method="post"--}}
                                      class="form-horizontal bv-form" novalidate="novalidate">
                                    {{ method_field('put') }}
                                    <button type="submit" class="bv-hidden-submit"
                                            style="display: none; width: 0px; height: 0px;"></button>
                                    {{ csrf_field() }}
                                    <div class="form-group">
                                        <label class="col-lg-2 control-label">用户类型</label>
                                        <div class="col-lg-8" style="line-height: 33px">
                                            @if($user -> role==0)
                                                超级管理员
                                            @else
                                                {{$user -> role()}}
                                            @endif

                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-2 control-label">用户名</label>

                                        <div class="col-lg-8">
                                            <input type="text" name="name" readonly
                                                   value="{{ isset($user) ? $user->name : old('name') }}"
                                                   class="form-control" placeholder="请输入用户名"
                                                   user_id="{{isset($user->id)?$user->id:''}}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-2 control-label">密码</label>

                                        <div class="col-lg-8">
                                            <input id="password" type="password" name="password"
                                                   value="{{ isset($user) ? '' : old('password') }}"
                                                   class="password form-control" placeholder="请输入密码">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-lg-2 control-label">确认密码</label>

                                        <div class="col-lg-8">
                                            <input type="password" name="password_confirmation"
                                                   value="{{ old('password_confirmation') }}" class="password form-control"
                                                   placeholder="请再次输入密码">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-lg-2 control-label">邮箱</label>

                                        <div class="col-lg-8">
                                            <input type="email" name="email"
                                                   value="{{ isset($user) ? $user->email : old('email') }}"
                                                   class="form-control" placeholder="请输入邮箱">
                                        </div>
                                    </div>

                                    <div class="form-group avatar">
                                        <label class="col-lg-2 control-label">头像</label>

                                        <div class="col-lg-8">
                                            <div class="imgPreViewBox col-lg-cover">
                                                @if (isset($user) && $user->avatar != null)
                                                    <div class="imgPreView-item">
                                                        <div class="glyphicon glyphicon-remove imgPreViewi-close"></div>
                                                        <img src="{{md52url($user->avatar)}}" class="imgPreViewi-img">
                                                    </div>
                                                @else
                                                    <div class="imgPreView-item">
                                                        <div class="glyphicon glyphicon-remove imgPreViewi-close"></div>
                                                        <img src="{{url('/images/touxiang_gg.jpg')}}"
                                                             class="imgPreViewi-img">
                                                        {{--<img src="http://img3.imgtn.bdimg.com/it/u=3693293767,1501712154&fm=21&gp=0.jpg" class="imgPreViewi-img">--}}
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="imgPreViewVal">
                                                @if (isset($user))
                                                    <input type="hidden" name="avatar" value="{{$user->avatar}}">
                                                @else
                                                    <input type="hidden" name="avatar" value="">
                                                @endif

                                            </div>
                                            <input type="file" class="form-control" name="fourthFile"
                                                   data-bv-field="fourthFile" id="product-inp">


                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label class="col-lg-2 control-label">真实姓名</label>

                                        <div class="col-lg-8">
                                            <input type="text" name="real_name"
                                                   value="{{ isset($user) ? $user->real_name : old('real_name') }}"
                                                   class="form-control" placeholder="请输入姓名">
                                            @if ($errors->has('real_name'))
                                                <label class="error">
                                                    <span class="error">{{ $errors->first('real_name') }}</span>
                                                </label>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-lg-2 control-label">性别</label>

                                        <div class="col-md-8">
                                            <label class="checkbox-inline">
                                                <input type="radio" name="gender"
                                                       value="0" @if((isset($user) && $user->gender == 0) || old('gender') == 0 || old('gender') == null){{ 'checked' }}@endif>
                                                男 </label>
                                            <label class="checkbox-inline">
                                                <input type="radio" name="gender"
                                                       value="1" @if((isset($user) && $user->gender == 1) || old('gender') == 1){{ 'checked' }}@endif>
                                                女 </label>
                                            @if ($errors->has('gender'))
                                                <label class="error">
                                                    <span class="error">{{ $errors->first('gender') }}</span>
                                                </label>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-2 control-label">电话号码</label>

                                        <div class="col-lg-8">
                                            <input type="number" name="phone"
                                                   value="{{ isset($user) ? $user->phone : old('phone') }}"
                                                   class="form-control" placeholder="请输入电话">
                                            @if ($errors->has('phone'))
                                                <label class="error">
                                                    <span class="error">{{ $errors->first('phone') }}</span>
                                                </label>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-lg-2 control-label">微信号</label>

                                        <div class="col-lg-8">
                                            <input type="text" name="wechat"
                                                   value="{{ isset($user) ? $user->wechat : old('wechat') }}"
                                                   class="form-control" placeholder="请输入微信号">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-lg-2 control-label">QQ号</label>

                                        <div class="col-lg-8">
                                            <input type="number" name="qq"
                                                   value="{{ isset($user) ? $user->qq : old('qq') }}"
                                                   class="form-control" placeholder="请输入QQ号">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-lg-2 control-label">
                                            &nbsp;
                                        </label>

                                        <div class="col-lg-8">
                                            <div class="form-actions">
                                                <div type="submit"
                                                     class="create-btn btn btn-primary {{mla('UserController@edit', 'UserController@update')}}">
                                                    提交
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!--<div class="col-md-4">
                    <div class="box-widget widget-module">
                        <div class="widget-head clearfix">
                            <span class="h-icon"><i class="fa fa-credit-card"></i></span>
                            <h4>收款账户</h4>
                        </div>
                        <div class="widget-container">
                            <form class="dis-in widget-block">
                                <div class="form-group dis-in">
                                    <small style="padding-right: 0; line-height: 33px" class="col-md-4 control-label">支付宝账号</small>
                                    <div class=" col-md-8">
                                        <input name="alipay" type="text" class="form-control" placeholder="">
                                    </div>
                                </div>
                                <div class="form-group dis-in  pad-left">

                                    <div class=" col-md-8 ">
                                        <button type="submit" class="btn btn-primary">提交</button>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>  -->
            </div>
        </div>
    </div>


@endsection

@section('footer_related')
    {{--<script src="/js/summernote.min.js"></script>
    <script src="/js/summernote/lang/summernote-zh-CN.js"></script>--}}
    <script src="/js/jquery.validate.js"></script>
    {{--<script src="/js/form/bootstrapValidator.js"></script>
    <script src="/js/form/bootstrapValidator.js"></script>
    <script src="/js/switchery.js"></script>--}}
    <script>
        /*seajs.config({
         dir_app: '/js/',
         })*/
        define('app', function (require, exports, module) {
            'use strict';
            window.$ = jQuery;
            window._token = "{{csrf_token()}}"
            window.common = require('widget/common');
            window.form = require('widget/form');
            window.C = require('core/config')
            var $doc = $(document);

            $.ajaxSetup({
                dataType: 'json'
            });

            /*

             var $cover = $('#cover-inp');

             $cover.change(function () {
             common.uploadImg(this, {inp_name: 'cover'});
             })
             */

            var $proImgs = $('#product-inp');
            $proImgs.change(function () {
                common.uploadImg(this)
                this.onUploadEnd = function (data) {
                    $(this).prevAll('.imgPreViewVal').html('<input type="hidden" name="avatar" value="' + data.md5 + '" />');
                    $(this).prevAll('.imgPreViewBox').css('display', 'inline-block').html('<div class="imgPreView-item"><div class="glyphicon glyphicon-remove imgPreViewi-close"></div><img src="' + data.url + '" class="imgPreViewi-img" /></div>');
                }
            })

            /*var $cardImgs = $('#card_id');
             $cardImgs.change(function () {
             common.uploadImg(this, {inp_name: 'identity_card_file[]', max: 2});
             })*/


            function validator() {

                $.ajax({
                    url: '/upload/config',
                    success: _success
                })

                function _success(data) {
                    var fileType = [], i;
                    for (i in data.fileType) {
                        fileType.push(data.fileType[i]);
                    }
                    fileType = fileType.join(',');
                    /*$("#user_create_form").validate({
                     rules: {
                     name: {
                     required: true,
                     minlength: 2,
                     maxlength: 32,
                     },
                     password: {
                     required: true,
                     minlength: 6,
                     maxlength: 16
                     },
                     password_confirmation: {
                     required: true,
                     minlength: 6,
                     maxlength: 16,
                     equalTo: "#password"
                     },
                     //avatar : 'required',
                     /!*fourthFile: {
                     required: true,
                     },*!/
                     //real_name: 'required',

                     /!*email: {
                     required: true,
                     email: true
                     },*!/
                     /!*phone: {
                     required: true,
                     },*!/


                     },
                     messages: {
                     name: {
                     required:  "请输入用户名",
                     minlength: "用户名长度不能小于 2 位字符",
                     maxlength: "用户名长度不能大于 32 位字符"
                     },
                     //real_name: "请输入您的真实姓名",
                     password: {
                     required: "请输入密码",
                     minlength: "密码长度不能小于 6 位字符",
                     maxlength:"密码长度不能大于 16 位字符"
                     },
                     password_confirmation: {
                     required: "请输入密码",
                     minlength: "密码长度不能小于 6 位字符",
                     maxlength:"密码长度不能大于 16 位字符",
                     equalTo: "两次密码输入不一致"
                     },
                     /!*email: "请输入一个正确的邮箱",
                     fourthFile: "请上传头像",*!/
                     //phone: "请输入您的电话号码"
                     }
                     });*/

                }
            }

            validator();

            $doc.on('blur', '.password', function () {
                var $that = $(this);
                if ($that.val().length > 0) {
                    $("#user_create_form").validate({
                        rules: {
                            password: {
                                required: true,
                                minlength: 6,
                                maxlength: 16
                            },
                            password_confirmation: {
                                required: true,
                                minlength: 6,
                                maxlength: 16,
                                equalTo: "#password"
                            },

                        },
                        messages: {
                            password: {
                                required: "请输入密码",
                                minlength: "密码长度不能小于 6 位字符",
                                maxlength: "密码长度不能大于 16 位字符"
                            },
                            password_confirmation: {
                                required: "请输入密码",
                                minlength: "密码长度不能小于 6 位字符",
                                maxlength: "密码长度不能大于 16 位字符",
                                equalTo: "两次密码输入不一致"
                            },

                        }
                    });
                }else{

                }
            })

            $doc.on('click', '.create-btn', function () {

                if (!$('#user_create_form').valid()) {
                    validator()
                    return;
                }


                var file_val = $('input[type="file"]').val();
                if (file_val != '' && !/^[a-zA-Z]:(\\.+)(.JPEG|.jpeg|.JPG|.jpg|.GIF|.gif|.BMP|.bmp|.PNG|.png)$/i.test(file_val)) {
                    common.alert('请选择正确的图片格式');
                    return false;
                }

                var _form = form.getFormData('#user_create_form');
                _form.email = $('input[name="email"]').val();
                _form.id = $('input[name="name"]').attr('user_id');

                $.ajax({
                    url: C.api.user_store,
                    data: _form,
                    type: 'post',
                    stopAllStart: true,
                    success: function (data) {
                        if (data.sta == '1') {
                            common.alert('修改成功');
                            location.href = 'my'
                        } else {
                            if (data.msg !== '') {
                                common.alert(data.msg || '请求失败');
                            }
                        }
                    },
                    error: function () {
                        common.alert('网络发生错误');
                        return false;
                    }
                })
            })




        })

        seajs.use('app');


    </script>


@endsection
