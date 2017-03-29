@extends('Admin.layout.main')

@section('title', isset($user) ? '编辑用户' : '创建用户')

@section('header_related')
    <style>
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
            width: 100px;
        }

        .imgPreViewi-close {
            position: absolute;
            top: 5px;
            right: 5px;
            -webkit-text-stroke: .2px #fff;
            color: #a94442;
            cursor: pointer;
        }
    </style>
@endsection

@section('content')
    <div class="main-container">
        <div class="container-fluid">
            @include('Admin.layout.breadcrumb', [
                 'title' => isset($user) ? '编辑用户' : '创建用户',

                 'breadcrumb' => [
                 /*'首页' => url('/'),.*/
                 '用户中心' => '',
                 isset($user) ? '编辑用户' : '创建用户' => ''
             ]
         ])

            <div class="row">
                <div class="col-md-12">
                    <div class="box-widget widget-module">
                        <div class="widget-container">
                            <div class=" widget-block">

                                @if (isset($user))
                                    <form id="user_create_form" {{--action="{{ route('user.update',$user->id) }}"
                                          method="post" --}}class="form-horizontal bv-form" novalidate="novalidate">
                                        {{ method_field('put') }}
                                        @else
                                            <form id="user_create_form" {{--action="{{ route('user.store') }}" method="post"--}}
                                                  class="form-horizontal bv-form" novalidate="novalidate">
                                                @endif
                                                <button type="submit" class="bv-hidden-submit"
                                                        style="display: none; width: 0px; height: 0px;"></button>
                                                {{ csrf_field() }}

                                                {{--<div class="form-group">
                                                    <label class="col-lg-2 control-label">用户角色</label>
                                                    <div class="col-md-8">
                                                        <label class="checkbox-inline">
                                                            <input type="radio" name="role" value="0" required @if((isset($user) && $user->role == 0) || old('role') == 0 || old('role') == null){{ 'checked' }}@endif>主编</label>
                                                        --}}{{--<label class="checkbox-inline">
                                                            <input type="radio" name="role" value="1" required @if((isset($user) && $user->role == 1) || old('role') == 1){{ 'checked' }}@endif> 代理商 </label>--}}{{--
                                                        <label class="checkbox-inline">
                                                            <input type="radio" name="role" value="2" required @if((isset($user) && $user->role == 2) || old('role') == 2){{ 'checked' }}@endif> 小编 </label>
                                                        <label class="checkbox-inline">
                                                            <input type="radio" name="role" value="4" required @if((isset($user) && $user->role == 4) || old('role') == 4){{ 'checked' }}@endif> 记者 </label>
                                                        --}}{{--<label class="checkbox-inline">
                                                            <input type="radio" name="role" value="5" required @if((isset($user) && $user->role == 5) || old('role') == 5){{ 'checked' }}@endif> 招商 </label>
                                                        <label class="checkbox-inline">
                                                            <input type="radio" name="role" value="99" required @if((isset($user) && $user->role == 99) || old('role') == 99){{ 'checked' }}@endif> 微商 </label>--}}{{--
                                                    </div>
                                                </div>--}}
                                                @if(isset($user))
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
                                                @else
                                                    <div class="form-group">

                                                        <label class="col-lg-2 control-label">用户类型</label>

                                                        <div class="col-md-8">
                                                            @if(isset($acl_user))
                                                                @foreach($acl_user as $k => $v)
                                                                    @if($v->id==0)
                                                                        {{--超级管理员不给予创建--}}
                                                                    @else
                                                                        @if($v -> id==2)
                                                                            <label class="checkbox-inline">

                                                                                <input checked="checked" type="radio"
                                                                                       name="role"
                                                                                       value="{{$v -> id}}"> {{$v-> acl_name}}
                                                                            </label>
                                                                        @else
                                                                            <label class="checkbox-inline">
                                                                                <input type="radio" name="role"
                                                                                       value="{{$v -> id}}"> {{$v -> acl_name}}
                                                                            </label>
                                                                        @endif
                                                                    @endif
                                                                @endforeach
                                                            @endif
                                                        </div>
                                                    </div>
                                                @endif


                                                <div class="form-group">
                                                    <label class="col-lg-2 control-label">用户名</label>

                                                    <div class="col-lg-8">
                                                        <input type="text" name="name"
                                                               @if (isset($user)) readonly @endif
                                                               value="{{ isset($user) ? $user->name : old('name') }}"
                                                               class="form-control" placeholder="请输入用户名"
                                                               user_id="{{isset($user->id)?$user->id:''}}"/>
                                                        {{--@if (isset($user))@else
                                                            @if ($errors->has('name'))
                                                                <label class="error">
                                                                    <span class="error">{{ $errors->first('name') }}</span>
                                                                </label>
                                                            @endif
                                                        @endif--}}
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-lg-2 control-label">密码</label>

                                                    <div class="col-lg-8">
                                                        <input id="password" type="password" name="password"
                                                               value="{{ isset($user) ? '' : old('password') }}"
                                                               class="password form-control" placeholder="请输入密码">
                                                        {{--@if (isset($user))

                                                        @else
                                                            @if ($errors->has('password'))
                                                                <label class="error">
                                                                    <span class="error">{{ $errors->first('password') }}</span>
                                                                </label>
                                                            @endif
                                                        @endif--}}
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-lg-2 control-label">确认密码</label>

                                                    <div class="col-lg-8">
                                                        <input type="password" name="password_confirmation"
                                                               value="{{ old('password_confirmation') }}"
                                                               class="password form-control" placeholder="请再次输入密码">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-lg-2 control-label">邮箱</label>

                                                    <div class="col-lg-8">
                                                        <input type="email" name="email"
                                                               value="{{ isset($user) ? $user->email : old('email') }}"
                                                               class="form-control" placeholder="请输入邮箱">
                                                        {{-- @if (isset($user))

                                                         @else
                                                             @if ($errors->has('email'))
                                                                 <label class="error">
                                                                     <span class="error">{{ $errors->first('email') }}</span>
                                                                 </label>
                                                             @endif
                                                         @endif--}}

                                                    </div>
                                                </div>

                                                <div class="form-group avatar">
                                                    <label class="col-lg-2 control-label">头像</label>

                                                    <div class="col-lg-8">
                                                        <div class="imgPreViewBox col-lg-cover">

                                                            @if (isset($user) && $user->avatar != null)
                                                                <div class="imgPreView-item">
                                                                    <div class="glyphicon glyphicon-remove imgPreViewi-close"></div>
                                                                    <img src="{{md52url($user->avatar)}}"
                                                                         class="imgPreViewi-img">
                                                                </div>
                                                            @else
                                                                <div class="imgPreView-item">
                                                                    <div class="glyphicon glyphicon-remove imgPreViewi-close"></div>
                                                                    <img src="{{url('/images/touxiang_gg.jpg')}}"
                                                                         class="imgPreViewi-img">
                                                                    {{--<img src="http://img3.imgtn.bdimg.com/it/u=3693293767,1501712154&fm=21&gp=0.jpg" class="imgPreViewi-img">--}}
                                                                </div>
                                                            @endif
                                                            {{-- @if(isset($user))
                                                                 <div class="imgPreView-item">
                                                                     <div class="glyphicon glyphicon-remove imgPreViewi-close"></div>
                                                                     <img src="{{ md52url($user->avatar, false, '') }}"
                                                                          class="imgPreViewi-img">
                                                                 </div>
                                                             @endif--}}
                                                        </div>
                                                        <div class="imgPreViewVal">

                                                            @if (isset($user))
                                                                <input type="hidden" name="avatar"
                                                                       value="{{$user->avatar}}">
                                                            @endif

                                                        </div>
                                                        <input type="file" class="form-control" name="fourthFile"
                                                               data-bv-field="fourthFile" id="product-inp">

                                                        {{--@if(isset($user))--}}
                                                        {{--@else--}}
                                                        {{--@if ($errors->has('avatar'))--}}
                                                        {{--<label class="error">--}}
                                                        {{--<span class="error">{{$errors->first('avatar') }}</span>--}}
                                                        {{--</label>--}}
                                                        {{--@endif--}}
                                                        {{--@endif--}}

                                                    </div>
                                                </div>


                                                <div class="form-group">
                                                    <label class="col-lg-2 control-label">真实姓名</label>

                                                    <div class="col-lg-8">
                                                        <input type="text" name="real_name"
                                                               value="{{ isset($user) ? $user->real_name : old('real_name') }}"
                                                               class="form-control" placeholder="请输入姓名">
                                                        {{--@if ($errors->has('real_name'))
                                                            <label class="error">
                                                                <span class="error">{{ $errors->first('real_name') }}</span>
                                                            </label>
                                                        @endif--}}
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
                                                            <input type="radio" name="gender" value="1"
                                                            @if((isset($user) && $user->gender == 1) || old('gender') == 1){{ 'checked' }}@endif>
                                                            女 </label>
                                                        {{-- @if ($errors->has('gender'))
                                                             <label class="error">
                                                                 <span class="error">{{ $errors->first('gender') }}</span>
                                                             </label>
                                                         @endif--}}
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-lg-2 control-label">电话号码</label>

                                                    <div class="col-lg-8">
                                                        <input type="number" name="phone"
                                                               value="{{ isset($user) ? $user->phone : old('phone') }}"
                                                               class="form-control" placeholder="请输入电话">
                                                        {{--@if ($errors->has('phone'))
                                                            <label class="error">
                                                                <span class="error">{{ $errors->first('phone') }}</span>
                                                            </label>
                                                        @endif--}}
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

                                                {{--<div class="form-group">
                                                    <label class="col-lg-2 control-label">住址</label>
                                                    <div class="col-lg-8">
                                                        <input type="text" name="address" value="{{ isset($user) ? $user->address : old('address') }}" class="form-control" placeholder="请输入住址">
                                                        @if ($errors->has('address'))
                                                            <label class="error">
                                                                <span class="error">{{ $errors->first('address') }}</span>
                                                            </label>
                                                        @endif
                                                    </div>
                                                </div>--}}

                                                <div class="form-group">
                                                    <label class="col-lg-2 control-label">
                                                        &nbsp;
                                                    </label>

                                                    <div class="col-lg-8">
                                                        <div class="form-actions">
                                                            <div type="submit" class="create-btn btn btn-primary">
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
            </div>
        </div>
    </div>
@endsection

@section('footer_related')
    {{--<script src="/js/summernote.min.js"></script>
    <script src="/js/summernote/lang/summernote-zh-CN.js"></script>--}}
    <script src="/js/jquery.validate.js"></script>
    {{--<script src="/js/form/bootstrapValidator.js"></script>
    <script src="/js/form/bootstrapValidator.js"></script>--}}
    {{--<script src="/js/switchery.js"></script>--}}
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

                }
            }

            validator();

            //创建用户的时候验证
            var create_val = $('.breadcrumb-titles').text().replace(/\s/g, '') == '创建用户',
                    validate_form = $("#user_create_form");
            if (create_val) {
                validate_form.validate({
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

                    },
                    messages: {
                        name: {
                            required: "请输入用户名",
                            minlength: "用户名长度不能小于 2 位字符",
                            maxlength: "用户名长度不能大于 32 位字符"
                        },
                        //real_name: "请输入您的真实姓名",
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
            } else {
                $doc.on('blur', '.password', function () {
                    var $that = $(this);
                    if ($that.val().length > 0) {
                        validate_form.validate({
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
                    } else {

                    }
                })
            }

            $doc.on('click', '.create-btn', function () {

                if (!$('#user_create_form').valid() && create_val) {
                    validator()
                    return;
                }

                var file_val = $('input[type="file"]').val();
                if (file_val != '' && !/^[a-zA-Z]:(\\.+)(.JPEG|.jpeg|.JPG|.jpg|.GIF|.gif|.BMP|.bmp|.PNG|.png)$/i.test(file_val)) {
                    common.alert('请选择正确的图片格式');
                    return false;
                }

                if ($('#password').val() != $('input[name="password_confirmation"]').val()) {
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
                            if (create_val) {
                                common.alert('创建成功');
                                location.href = '/user'
                            } else {
                                common.alert('修改成功');
                            }

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
