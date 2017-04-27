@extends('Admin.layout.main')

@section('title', isset($set_goods)?"商品详情":'添加商品')
@section('header_related')
    <link rel="stylesheet" href="{{ url('/css/style.css') }}" type="text/css">
    <link rel="stylesheet" type="text/css" href="{{url('js/wangEditor/dist/css/wangEditor.min.css')}}">
    {{--<script type="text/javascript" src="{{ url('/js/jquery.1.4.2-min.js') }}"></script>--}}
    <script src="{{ url('/js/jquery-1.11.2.min.js') }}"></script>
    <script type="text/javascript" src="{{ url('/js/jquery.form.min.js') }}"></script>
    @endsection
    @section('content')
            <!--<div class="main-container">
        <div class="container-fluid">
            @include('Admin.layout.breadcrumb', [
               'title' => isset($set_goods) ? '商品详情' : '添加商品',
                '' => [
                    '' => '',
                ]
            ])
            </div>
         </div>-->

    <div class="Iartice">
        <div class="IAhead"><strong style="padding-right: 10px;">@if(isset($set_goods))商品详情@else添加商品@endif</strong>
        </div>
        <div class="IAMAIN">
            <table width="100%" cellspacing="0" cellpadding="0">
                <tr>
                    <td align="right" width="120"><font color="red">*</font>所属分类：</td>
                    <td>
                        <select name="cateid" id="select_id_1" class="asnt">
                            <option value="0">请选择分类</option>
                            @if(isset($sort))
                                @foreach($sort as $key =>$vel)
                                    <option
                                            @if(isset($set_goods) && $set_goods->sort_id == $vel['id'])
                                            selected
                                            @endif
                                            value="{{$vel['id']}}"
                                    >{{$vel['name']}}</option>
                                @endforeach
                            @endif
                        </select>
                    </td>
                </tr>
                <tr>
                    <td align="right" width="120"><font color="red">*</font>所属品牌：</td>
                    <td>
                        <select name="cateid" id="set_brand" class="asnt">
                            <option value="0">请选择品牌</option>
                            @if($set_goods && get_brand($set_goods->sort_id)!==null)
                                @foreach(get_brand($set_goods->sort_id) as  $ky=>$vy)
                                    <option
                                            @if($set_goods->brand_id==$vy->id)
                                            selected
                                            @endif
                                            value="{{$vy->id}}">{{$vy->brand_name}}</option>
                                @endforeach
                            @endif
                        </select>
                    </td>
                </tr>
                <tr>
                    <td align="right">商品类型：</td>
                    <td><input type="radio" checked name="goods_sort" id="boy" value="1"> 男童 <input type="radio"
                                                                                                    name="goods_sort"
                                                                                                    id="girl" value="0">
                        女童
                    </td>
                </tr>
                <tr>
                    <td align="right">商品标题：</td>
                    <td><input type="text" name="goods_title" value="{{isset($set_goods)? $set_goods->goods_title:''}}"
                               class="Iar_input"></td>
                </tr>
                <tr>
                    <td align="right" width="120">缩略图：</td>
                    <td>
                        <div class="" style="position:relative;">
                            <form id="form_1" action="" method="post" style="aposition:relative;z-index:1000;">
                                {{csrf_field()}}
                                <input type="file" name="file" id="file_1"
                                       style="opacity:0;position:absolute;left:347px;top:0;width:68px;height:26px;cursor:pointer;"/>
                                <input type="text" name="upfile_1" id="upfile_1"
                                       value="{{isset($set_goods)?$set_goods->Thumbnails:''}}" class="Iar_inputt">
                                <input type="button" class="button" id="up_1" value="上传图片"/>
                            </form>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td align="right"></td>
                    <td>
                        <img id="uppic_1"
                             src="{{isset($set_goods)?md52url($set_goods->Thumbnails):url('images/z_add.png')}}"
                             style="width:auto; height: 80px; margin: 5px 0;">

                    </td>
                </tr>
                <tr>
                    <td align="right" width="120">展示图片：</td>
                    <td>
                        <div class="" style="position:relative;">
                            <form id="form_2" action="" method="post" style="aposition:relative;z-index:1000;">
                                {{csrf_field()}}
                                <input type="file" name="file" id="file_2"
                                       style="opacity:0;position:absolute;left:347px;top:0;width:68px;height:26px;cursor:pointer;"/>
                                <input type="text" name="upfile_2" id="upfile_2" class="Iar_inputt">
                                <input type="button" class="button" id="up_2" value="上传图片"/> <i>*最多可以上传10 张图片</i>
                            </form>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td align="right"></td>
                    <td>
                        <div id="uppic_2">

                            @if(isset($set_goods) && $set_goods->plan!==null)
                                @foreach(explode(',',$set_goods->plan) as $ky =>$vy)
                                    <img data="{{$vy}}" src="{{md52url($vy)}}"
                                         style="width:auto; height: 80px; margin: 5px;">
                                @endforeach
                            @endif
                            <img id="add_uppic_2" src="{{url('images/z_add.png')}}"
                                 style="width:auto; height: 80px; margin: 5px;">
                        </div>
                    </td>
                </tr>
                <tr>
                    <td align="right">商品总价格：</td>
                    <td><input name="price" type="text" value="{{isset($set_goods)?$set_goods->price:''}}"
                               class="Iar_inpun" style="margin-right: 10px;"><font
                                color="red">元</font></td>
                </tr>
                <tr>
                    <td align="right">库存：</td>
                    <td><input name="inventory" type="text" value="{{isset($set_goods)?$set_goods->inventory:''}}"
                               class="Iar_inpun" style="margin-right: 10px;"><font
                                color="red">个</font></td>
                </tr>
                <tr>
                    <td align="right">尺码参考：</td>
                    <td><input type="text" name="Size_reference"
                               value="{{isset($set_goods)?$set_goods->Size_reference:''}}" class="Iar_input"></td>
                </tr>
                <tr>
                    <td align="right">尺码：</td>
                    <td>
                        <table>
                            <tr>
                                <td style="color: #ff0000; padding-right: 10px;">尺码</td>
                                <td>
                                    <div data="1" class="plus-tag tagbtn clearfix"
                                         style="float: left;width: auto;">
                                        @if(isset($set_goods) && $set_goods->measure!==null)
                                            @foreach(explode(',',$set_goods->measure) as $ky =>$vy)
                                                <a value="-1" title="{{$vy}}"
                                                   href="javascript:void(0);"><span>{{$vy}}</span><em></em></a>
                                            @endforeach
                                        @endif
                                    </div>
                                    <div data="1" class="plus-tag-add" style="float: left;width: auto;">
                                        <input id="" name="measure" type="text" class="stext" maxlength="20"/>
                                        <button type="button" class="Button RedButton Button18">添加</button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="color: #ff0000; padding-right: 10px;">肩宽</td>
                                <td>
                                    <div data="2" class="plus-tag tagbtn clearfix"
                                         style="float: left;width: auto;">
                                        @if(isset($set_goods) && $set_goods->Shoulder_width!==null)
                                            @foreach(explode(',',$set_goods->Shoulder_width) as $ky =>$vy)
                                                <a value="-1" title="{{$vy}}"
                                                   href="javascript:void(0);"><span>{{$vy}}</span><em></em></a>
                                            @endforeach
                                        @endif
                                    </div>
                                    <div data="2" class="plus-tag-add" style="float: left;width: auto;">
                                        <input id="" name="Shoulder_width" type="text" class="stext" maxlength="20"/>
                                        <button type="button" class="Button RedButton Button18">添加</button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="color: #ff0000; padding-right: 10px;">衣长</td>
                                <td>
                                    <div data="3" class="plus-tag tagbtn clearfix"
                                         style="float: left;width: auto;">
                                        @if(isset($set_goods) && $set_goods->Long_clothing!==null)
                                            @foreach(explode(',',$set_goods->Long_clothing) as $ky =>$vy)
                                                <a value="-1" title="{{$vy}}"
                                                   href="javascript:void(0);"><span>{{$vy}}</span><em></em></a>
                                            @endforeach
                                        @endif
                                    </div>
                                    <div data="3" class="plus-tag-add" style="float: left;width: auto;">
                                        <input id="" name="Long_clothing" type="text" class="stext" maxlength="20"/>
                                        <button type="button" class="Button RedButton Button18">添加</button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="color: #ff0000; padding-right: 10px;">袖长</td>
                                <td>
                                    <div data="4" class="plus-tag tagbtn clearfix"
                                         style="float: left;width: auto;">
                                        @if(isset($set_goods) && $set_goods->Sleeve_Length!==null)
                                            @foreach(explode(',',$set_goods->Sleeve_Length) as $ky =>$vy)
                                                <a value="-1" title="{{$vy}}"
                                                   href="javascript:void(0);"><span>{{$vy}}</span><em></em></a>
                                            @endforeach
                                        @endif
                                    </div>
                                    <div data="4" class="plus-tag-add" style="float: left;width: auto;">
                                        <input id="" name="Sleeve_Length" type="text" class="stext" maxlength="20"/>
                                        <button type="button" class="Button RedButton Button18">添加</button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="color: #ff0000; padding-right: 10px;">胸围</td>
                                <td>
                                    <div data="5" class="plus-tag tagbtn clearfix"
                                         style="float: left;width: auto;">
                                        @if(isset($set_goods) && $set_goods->bust!==null)
                                            @foreach(explode(',',$set_goods->bust) as $ky =>$vy)
                                                <a value="-1" title="{{$vy}}"
                                                   href="javascript:void(0);"><span>{{$vy}}</span><em></em></a>
                                            @endforeach
                                        @endif
                                    </div>
                                    <div data="5" class="plus-tag-add" style="float: left;width: auto;">
                                        <input id="" name="bust" type="text" class="stext" maxlength="20"/>
                                        <button type="button" class="Button RedButton Button18">添加</button>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td align="right">材质：</td>
                    <td>


                        <div data="6" class="plus-tag tagbtn clearfix" style="float: left;width: auto;">
                            @if(isset($set_goods) && $set_goods->Material!==null)
                                @foreach(explode(',',$set_goods->Material) as $ky =>$vy)
                                    <a value="-1" title="{{$vy}}"
                                       href="javascript:void(0);"><span>{{$vy}}</span><em></em></a>
                                @endforeach
                            @endif
                        </div>
                        <div data="6" class="plus-tag-add" style="float: left;width: auto;">
                            <input id="" name="Material" type="text" class="stext" maxlength="20"/>
                            <button type="button" class="Button RedButton Button18">添加</button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td align="right">颜色：</td>
                    <td>
                        <div data="7" class="plus-tag tagbtn clearfix" style="float: left;width: auto;">

                            @if(isset($set_goods) && $set_goods->Colour!==null)
                                @foreach(explode(',',$set_goods->Colour) as $ky =>$vy)
                                    <a value="-1" title="{{$vy}}"
                                       href="javascript:void(0);"><span>{{$vy}}</span><em></em></a>
                                @endforeach
                            @endif
                        </div>
                        <div data="7" class="plus-tag-add" style="float: left;width: auto;">
                            <input id="" name="Colour" type="text" class="stext" maxlength="20"/>
                            <button type="button" class="Button RedButton Button18">添加</button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td align="right">袖型：</td>
                    <td>
                        <div data="8" class="plus-tag tagbtn clearfix" style="float: left;width: auto;">
                            @if(isset($set_goods) && $set_goods->Sleeve_Type!==null)
                                @foreach(explode(',',$set_goods->Sleeve_Type) as $ky =>$vy)
                                    <a value="-1" title="{{$vy}}"
                                       href="javascript:void(0);"><span>{{$vy}}</span><em></em></a>
                                @endforeach
                            @endif
                        </div>
                        <div data="8" class="plus-tag-add" style="float: left;width: auto;">
                            <input id="" name="Sleeve_Type" type="text" class="stext" maxlength="20"/>
                            <button type="button" class="Button RedButton Button18">添加</button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td align="right">风格：</td>
                    <td>
                        <div data="9" class="plus-tag tagbtn clearfix" style="float: left;width: auto;">
                            @if(isset($set_goods) && $set_goods->style!==null)
                                @foreach(explode(',',$set_goods->style) as $ky =>$vy)
                                    <a value="-1" title="{{$vy}}"
                                       href="javascript:void(0);"><span>{{$vy}}</span><em></em></a>
                                @endforeach
                            @endif
                        </div>
                        <div data="9" class="plus-tag-add" style="float: left;width: auto;">
                            <input id="" name="style" type="text" class="stext" maxlength="20"/>
                            <button type="button" class="Button RedButton Button18">添加</button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td align="right">版型：</td>
                    <td>
                        <div data="10" class="plus-tag tagbtn clearfix" style="float: left;width: auto;">
                            @if(isset($set_goods) && $set_goods->Version_type!==null)
                                @foreach(explode(',',$set_goods->Version_type) as $ky =>$vy)
                                    <a value="-1" title="{{$vy}}"
                                       href="javascript:void(0);"><span>{{$vy}}</span><em></em></a>
                                @endforeach
                            @endif
                        </div>
                        <div data="10" class="plus-tag-add" style="float: left;width: auto;">
                            <input id="" name="Version_type" type="text" class="stext" maxlength="20"/>
                            <button type="button" class="Button RedButton Button18">添加</button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td align="right">商品内容详情：</td>
                    <td>
                        <div style="width:70%;margin-top:8px;">
                            <div id="texDiv" style="height:400px;max-height:500px;">
                                {!!isset($set_goods)?$set_goods->content:old('content')!!}
                                @if ($errors->has('content'))
                                    <label class="error">
                                        <span class="error">{{ $errors->first('content') }}</span>
                                    </label>
                                @elseif(!isset($set_goods))
                                    <p>请输入内容...</p>
                                @endif
                            </div>
                        </div>

                        <script type="text/javascript"
                                src="{{url('/js/wangEditor/dist/js/wangEditor.min.js')}}"></script>
                        <script type="text/javascript">
                            $(function () {
                                $('#select_id_1').change(function () {
                                    var srt_id = $(this).val();
                                    var _token = "{{csrf_token()}}";
                                    var url = '{{url('goods/set_brand_sort')}}';
                                    $.ajax({
                                        url: url,
                                        data: {
                                            'sort_id': srt_id,
                                            '_token': _token
                                        },
                                        type: 'post',
                                        dataType: "json",
                                        stopAllStart: true,
                                        success: function (data) {
                                            if (data.sta == '1') {
                                                var num = data.data.length;
                                                var rst = "";
                                                for (var i = 0; i < num; i++) {
                                                    rst += "<option value=" + data.data[i]['id'] + ">" +
                                                            data.data[i]['brand_name']
                                                            + "</option>";
                                                }
                                                $("#set_brand").find("option").remove();
                                                $("#set_brand").append(rst);
                                                //插入html结构
                                                //  layer.msg(data.msg, {icon: 1});
                                                return false;
                                                /* setTimeout(window.location.href = reload_url, 1000);*/
                                            } else {
                                                layer.msg(data.msg || '请求失败');
                                            }
                                        },
                                        error: function () {
                                            return false;
                                        }
                                    });

                                });
                            });
                        </script>
                        <script type="text/javascript">
                            var editor = new wangEditor('texDiv');
                            // 上传图片
                            editor.config.uploadImgUrl = '/upload';

                            // 配置自定义参数
                            editor.config.uploadParams = {
                                _token: '{{csrf_token()}}',
                                user: '{{Auth::id()}}'
                            };

                            // 设置 headers（举例）
                            editor.config.uploadHeaders = {
                                'Accept': 'text/x-json'
                            };
                            // 隐藏掉插入网络图片功能。该配置，只有在你正确配置了图片上传功能之后才可用。
                            editor.config.hideLinkImg = false;

                            editor.create();

                        </script>

                    </td>
                </tr>
                <tr>
                    <td align="right">商品属性：</td>
                    <td><input type="checkbox" name="recommend"
                               @if(isset($set_goods)&&$set_goods->recommend !==0) checked @endif value="0"> 推荐
                    </td>
                </tr>
                <tr height="60px">
                    <td align="right"></td>
                    <td><input type="submit" name="dosubmit" class="button" id="submit"
                               value="{{isset($set_goods)?"修 改":"提 交"}}"></td>
                </tr>
            </table>
            <!--
                    </form>
            -->
        </div>
    </div>

    <!--图片上传-->
    <script>
        var options = {
            url: "{{url('upload')}}",
            type: "post",
            data: {return_type: "string"},
            enctype: 'multipart/form-data',
            success: function (ret) {
                console.log(ret)
                if (typeof(ret) == "string") {
                    ret = JSON.parse(ret);
                }
                if (ret.sta == "1") {
                    layer.msg('文件上传成功');
                    $('input[name="upfile_1"]').val(ret.md5);
                    $("#uppic_1").attr("src", ret.url);
                } else {
                    layer.msg(ret.msg);
                }
            },
            error: function (ret) {
                layer.msg("网络错误");
                console.log(ret);
            },
            clearForm: false,
            timeout: 100000
        };
        $("#up_1").click(function () {
            $("#file_1").click();
        });
        $("#uppic_1").click(function () {
            console.log("xx");
            $("#file_1").click();
            console.log("xx2");
        });
        $("#file_1").change(function () {
            $("#form_1").ajaxSubmit(options);
        });

        var options2 = {
            url: "{{url('upload')}}",
            type: "post",
            data: {return_type: "string"},
            enctype: 'multipart/form-data',
            success: function (ret) {
                console.log(ret)
                if (typeof(ret) == "string") {
                    ret = JSON.parse(ret);
                }
                if (ret.sta == "1") {
                    if ($("#uppic_2 img[data=" + ret.md5 + "]").length < 1) {
                        layer.msg('文件上传成功');
                        $('input[name="upfile_2"]').val(ret.md5);
                        var img = '<img data="' + ret.md5 + '" src="' + ret.url + '" style="width:auto; height: 80px; margin: 5px;">';
                        $("#uppic_2").prepend(img);
                    } else {
                        layer.msg("此图片已经存在");
                    }
                } else {
                    layer.msg(ret.msg);
                }
            },
            error: function (ret) {
                layer.msg("网络错误");
                console.log(ret);
            },
            clearForm: false,
            timeout: 100000
        };
        $("#add_uppic_2").click(function () {
            $("#file_2").click();
        });
        $("#up_2").click(function () {
            $("#file_2").click();
        });
        $("#file_2").change(function () {
            $("#form_2").ajaxSubmit(options2);
        });

        $("#submit").click(function () {
            var reload_url="{{url('goods/goods_list')}}";
            var dataf = [];
            dataf['cateid'] = $("#select_id_1").val();
            dataf['cateid2'] = $("#set_brand").val();
            if (dataf['cateid'] == 0) {
                layer.msg('请选择分类');
                return false
            }
            if (dataf['cateid2'] == 0) {
                layer.msg('请选择品牌');
                return false
            }
            dataf['goods_sort'] = $("input[name='goods_sort']:checked").val();
            dataf['goods_title'] = $("input[name='goods_title']").val();
            dataf['pic1'] = $("#upfile_1").val();
            dataf['pic2'] = '';
            $("#uppic_2 img").each(function (i) {
                if ($(this).attr("data")) {
                    var data = $(this).attr("data");
                    if (i > 0) {
                        dataf['pic2'] += ",";
                    }
                    dataf['pic2'] += data;
                }
            });
            dataf['price'] = $("input[name='price']").val();
            dataf['inventory'] = $("input[name='inventory']").val();
            dataf['Size_reference'] = $("input[name='Size_reference']").val();
            dataf['measure'] = getString('measure');
            dataf['Shoulder_width'] = getString('Shoulder_width');
            dataf['Long_clothing'] = getString('Long_clothing');
            dataf['Sleeve_Length'] = getString('Sleeve_Length');
            dataf['bust'] = getString('bust');
            dataf['Material'] = getString('Material');
            dataf['Colour'] = getString('Colour');
            dataf['Sleeve_Type'] = getString('Sleeve_Type');
            dataf['style'] = getString('style');
            dataf['Version_type'] = getString('Version_type');
            // 获取编辑器区域完整html代码
            dataf['content'] = editor.$txt.html();
            dataf['recommend'] = "";
            if ($("input[name=recommend]").is(":checked")) {				//我已经阅读并同意云媒体交易平台习家规则
                dataf['recommend'] = $("input[name=recommend]").val();
            }
            /* console.log(dataf);*/
            URL = "{{isset($set_goods)?route('goods.update'):url('goods/store')}}";
            $.ajax({
                url: URL,
                data: {
                    'goods_id':"{{isset($set_goods)?$set_goods->id:''}}",
                    '_token': "{{csrf_token()}}",
                    "sort_id": dataf['cateid'],
                    "brand_id": dataf['cateid2'],
                    "goods_sort": dataf['goods_sort'],
                    "goods_title": dataf['goods_title'],
                    "Thumbnails": dataf['pic1'],
                    "plan": dataf['pic2'],
                    "price": dataf['price'],
                    "inventory": dataf['inventory'],
                    "Size_reference": dataf['Size_reference'],
                    "measure": dataf['measure'],
                    "Shoulder_width": dataf['Shoulder_width'],
                    "Long_clothing": dataf['Long_clothing'],
                    "Sleeve_Length": dataf['Sleeve_Length'],
                    "bust": dataf['bust'],
                    "Material": dataf['Material'],
                    "Colour": dataf['Colour'],
                    "Sleeve_Type": dataf['Sleeve_Type'],
                    "style": dataf['style'],
                    "Version_type": dataf['Version_type'],
                    "content": dataf['content'],
                    "recommend": dataf['recommend']
                },
                type: 'post',
                dataType: "json",
                stopAllStart: true,
                success: function (data) {
                    if (data.sta == '1') {
                        layer.msg(data.msg, {icon: 1});
                          setTimeout(window.location.href = reload_url, 1000);
                    } else {
                        layer.msg(data.msg || '请求失败');
                    }
                },
                error: function (data) {
                    layer.msg(data.msg || '网络发生错误');
                    return false;
                }
            });
        });
        function getString(name) {
            var string_l = '';
            $("input[name=" + name + "]").parent().prev().find("a").each(function (i) {
                var value = $(this).attr("title");
                if (i > 0) {
                    string_l += ",";
                }
                string_l += value;
            });
            return string_l;
        }


    </script>
    <!--尺码-->
    <script type="text/javascript">
        /* var FancyForm=function(){
         return{
         inputs:".FancyForm input, .FancyForm textarea",
         setup:function(){
         var a=this;
         this.inputs=$(this.inputs);
         a.inputs.each(function(){
         var c=$(this);
         a.checkVal(c)
         });
         a.inputs.on("keyup blur",function(){
         var c=$(this);
         a.checkVal(c);
         });
         },checkVal:function(a){
         a.val().length>0?a.parent("li").addClass("val"):a.parent("li").removeClass("val")
         }
         }
         }(); */
    </script>
    <script type="text/javascript">
        /* $(document).ready(function() {
         FancyForm.setup();
         }); */
    </script>
    <script type="text/javascript">
        var searchAjax = function () {
        };
        var G_tocard_maxTips = 30;
        $(function () {
            (function () {

                $(".plus-tag-add").each(function () {
                    var $this = $(this);
                    //        var a=$(".plus-tag");
                    var a = $this.prev(".plus-tag");

                    $(".plus-tag").on("click", "a em", function () {

                        var a = $(this).parents(".plus-tag");
                        var c = $(this).parents("a"), b = c.attr("title"), d = c.attr("value");
                        delTips(b, d, a)
                    });

                    hasTips = function (b, aaa) {

                        var d = $("a", aaa), c = false;
                        d.each(function () {
                            if ($(this).attr("title") == b) {
                                c = true;
                                return false
                            }
                        });


                        return c
                    };

                    isMaxTips = function (aaa) {
                        return $("a", aaa).length >= G_tocard_maxTips;
                    };

                    setTips = function (c, d, aaa) {
                        if (hasTips(c, aaa)) {
                            return false
                        }
                        if (isMaxTips(aaa)) {
                            alert("最多添加" + G_tocard_maxTips + "个标签！");
                            return false
                        }
                        var b = d ? 'value="' + d + '"' : "";

                        aaa.append($("<a " + b + ' title="' + c + '" href="javascript:void(0);" ><span>' + c + "</span><em></em></a>"));
                        searchAjax(c, d, true);
                        return true
                    };

                    delTips = function (b, c, aaa) {

                        if (!hasTips(b, aaa)) {
                            return false
                        }
                        $("a", aaa).each(function () {
                            var d = $(this);
                            if (d.attr("title") == b) {
                                d.remove();

                                return false
                            }
                        });
                        searchAjax(b, c, false);
                        return true
                    };

                    getTips = function () {
                        var b = [];
                        $("a", a).each(function () {
                            b.push($(this).attr("title"))
                        });
                        return b
                    };

                    getTipsId = function () {
                        var b = [];
                        $("a", a).each(function () {
                            b.push($(this).attr("value"))
                        });
                        return b
                    };

                    getTipsIdAndTag = function () {
                        var b = [];
                        $("a", a).each(function () {
                            b.push($(this).attr("value") + "##" + $(this).attr("title"))
                        });
                        return b
                    }


                    var $b = $this.find('button'), $i = $this.find('input');
                    $i.keyup(function (e) {
                        if (e.keyCode == 13) {
                            $b.click();
                        }
                    });
                    $b.click(function () {
                        var name = $i.val().toLowerCase();
                        if (name != '') setTips(name, -1, a);
                        $i.val('');
                        $i.select();
                    });
                });

            })()
        });
    </script>
    <script type="text/javascript">
        // 更新选中标签标签
        $(function () {
            //   setSelectTips();
//    $('.plus-tag').append($('.plus-tag a'));
        });
        var searchAjax = function (name, id, isAdd) {
//    setSelectTips();
        };
        // 搜索
        (function () {
            /* 	$(".plus-tag-add").each(function(){
             var $this = $(this);
             //		var $b = $('.plus-tag-add button'),$i = $('.plus-tag-add input');
             var $b = $this.find('button'),$i = $this.find('input');
             $i.keyup(function(e){
             if(e.keyCode == 13){
             $b.click();
             }
             });
             $b.click(function(){
             var name = $i.val().toLowerCase();
             if(name != '') setTips(name,-1);
             $i.val('');
             $i.select();
             });
             }); */
        })();

        (function () {

            // 更新高亮显示
            setSelectTips = function () {
                var arrName = getTips();
                if (arrName.length) {
//            $('#myTags').show();
                } else {
//            $('#myTags').hide();
                }
                $('.default-tag a').removeClass('selected');
                $.each(arrName, function (index, name) {
                    $('.default-tag a').each(function () {
                        var $this = $(this);
                        if ($this.attr('title') == name) {
                            $this.addClass('selected');
                            return false;
                        }
                    })
                });
            }

        })();

    </script>




@endsection
@section('footer_related')
@endsection
