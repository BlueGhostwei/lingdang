@extends('Admin.layout.main')

@section('title', isset($set_goods)?"商品详情":'添加商品')
@section('header_related')
    <link rel="stylesheet" href="{{ url('/css/style.css') }}" type="text/css">
    <link rel="stylesheet" type="text/css" href="{{url('js/wangEditor/dist/css/wangEditor.min.css')}}">
    {{--<script type="text/javascript" src="{{ url('/js/jquery.1.4.2-min.js') }}"></script>--}}
    <script src="{{ url('/js/jquery-1.11.2.min.js') }}"></script>
    <script type="text/javascript" src="{{ url('/js/jquery.form.min.js') }}"></script>
    <style>
        .cfix:after {
            clear: both;
            content: ".";
            display: block;
            height: 0;
            overflow: hidden;
            visibility: hidden;
        }
        .cfix {
            zoom: 1;
        }
        #para1_list p {
            color: #333333;
            display: block;
            float: left;
            clear: both;
            height: 28px;
            line-height: 28px;
            overflow: hidden;
            margin: 0 10px 10px 0;
            padding: 0 10px 0 5px;
            white-space: nowrap;
            background: url(/images/tagbg.png) no-repeat;
            background: #ddd;
        }
        #para1_list p a {
            text-decoration: none;
            font-weight: 700;
            color: #23527c;
        }

        #para1_list p span {
            afloat: left;
        }
        #para1_list p em {
            display: inline-block;
            afloat: left;
            margin: 5px 0 0 8px;
            width: 13px;
            height: 13px;
            overflow: hidden;
            background: url(/images/tagbg.png) no-repeat;
            background-position: -165px -98px;
            cursor: pointer;
        }

        #para_list p:hover em {
            background-position: -168px -64px;
        }

        #para2_list {
        }

        #para2_list {
        }

        #para2_list p {
            color: #333333;
            display: block;
            float: left;
            height: 28px;
            line-height: 28px;
            overflow: hidden;
            margin: 0 10px 10px 0;
            padding: 0 10px 0 5px;
            white-space: nowrap;
            background: url(/images/tagbg.png) no-repeat;
            background: #ddd;
        }

        #para2_list p.p1 {
            display: table-cell;
            acolor: #9eadb3;
            abackground: #777;
        }

        #para2_list p.p2 {
            display: table-cell;
        }

        #para2_list p.p3 {
            display: table-cell;
        }

        #para2_list p em {
            display: inline-block;
            afloat: left;
            margin: 5px 0 0 8px;
            width: 13px;
            height: 13px;
            overflow: hidden;
            background: url(/images/tagbg.png) no-repeat;
            background-position: -165px -98px;
            cursor: pointer;
        }

        #para2_list p:hover em {
            background-position: -168px -64px;
        }

        #para2_list p a {
            text-decoration: none;
        }

        #para2_list p.p1 a {
            font-weight: 700;
            color: #23527c;
        }

        #para2_list p.p2 a {
            font-weight: 700;
            color: blue;
        }

        #para2_list p.p3 a {
            font-weight: 700;
            color: red;
        }

        #para2_list p.p4 a {
            font-weight: 400;
        }

        #para2_list div ul {
            list-style: none;
            margin: 0;
            display: table-cell;
            padding: 0;
        }

        #para2_list div ul li {
            list-style: none;
            color: #333333;
            display: block;
            afloat: left;
            aheight: 28px;
            line-height: 28px;
            overflow: hidden;
            margin: 0 10px 0px 0;
            padding: 0 10px 0 0px;
            white-space: nowrap;
            abackground: url(/images/tagbg.png) no-repeat;
        }

        #para2_list div ul li div {
            display: table-cell;
            float: none;
        }

        #para2_list div ul li a {
        }

        #para2_list div ul li span {
            padding: 0 2px 0 8px;
        }

        #para2_list div ul li em {
            display: inline-block;
            afloat: left;
            margin: 5px 0 0 8px;
            width: 13px;
            height: 13px;
            overflow: hidden;
            background: url(/images/tagbg.png) no-repeat;
            background-position: -165px -98px;
            cursor: pointer;
        }

        #para2_list div ul li:hover em {
            background-position: -168px -64px;
        }

        #para2_list div li li li {
            float: left;
            margin: 0;
            padding: 0;
        }

        .para_level {
            height: 26px;
            padding: 0px 5px;
            vertical-align: middle;
            padding: 3px;
        }

        .para_add label {
            margin-bottom: 0;
        }

        .para_add label b {
            font-weight: 400;
            padding: 0 2px 0 5px;
        }

        .para_add label input {
            width: 110px;
            height: 26px;
            vertical-align: middle;
        }

        .para_add button {
            vertical-align: middle;
        }

        #para2_level2,
        #para2_level3,
        .para2_else {
            display: none;
        }

        .para_kucun {
        }
    </style>
    <style>
        #guige {
            width: 80%;
            aborder: 1px solid #999;
            padding: 0px;
            margin: 5px 0 0;
        }

        #guige h3 {
            margin: 0;
            font-size: 14px;
            font-weight: 700;
        }

        #guige_list {
            amin-height: 100px;
            padding-top: 20px;
        }

        #goods_spec_table1 {
            background: #fff;
        }

        #goods_spec_table2 {
            width: 80%;
        }

        #goods_spec_table1 th,
        #goods_spec_table2 th,
        #goods_spec_table1 td,
        #goods_spec_table2 td {
            padding: 8px;
            line-height: 1.42857143;
            vertical-align: middle;
            border: 1px solid #ddd;
        }

        #goods_spec_table1 th,
        #goods_spec_table2 th {
            font-weight: 700;
        }

        .btn-default {
            background-color: buttonface;
        }
    </style>
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
                        <select name="sort_id" id="select_id_1" class="asnt">
                            <option value="0">请选择分类</option>
                            @if(isset($sort))
                                @foreach($sort as $key =>$vel)
                                    <option
                                            @if(isset($set_goods) && $set_goods->sort_id == $vel['id'])
                                            selected
                                            @endif
                                            value="{{$vel['id']}}"
                                    >
                                        {{$vel['name']}}

                                    </option>
                                    {{--渲染二级分类--}}
                                    @if(isset($vel['child']) && !empty($vel['child']))
                                        @foreach($vel['child'] as $rst=>$rvb)
                                            <option
                                                    @if(isset($set_goods) && $set_goods->sort_id == $rvb['id'])
                                                    selected
                                                    @endif
                                                    value="{{$rvb['id']}}"
                                            >
                                                {{$rvb['name']}}

                                            </option>
                                        @endforeach
                                    @endif
                                @endforeach
                            @endif
                        </select>
                    </td>
                </tr>
                <tr>
                    <td align="right" width="120"><font color="red">*</font>所属品牌：</td>
                    <td>
                        <select name="brand_id" id="set_brand" class="asnt">
                            <option value="0">请选择品牌</option>
                            @if(isset($sort_brand) && !empty($sort_brand))
                                    @foreach($sort_brand as $key =>$vey)
                                    <option
                                            @if(isset($set_goods) && $set_goods->brand_id == $vey->id)
                                            selected
                                            @endif
                                            value="{{$vey->id}}">{{$vey->brand_name}}</option>
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
                                <input type="text" name="upfile_2" id="upfile_2" class="Iar_inputt" value="{{isset($set_goods)?$set_goods->plan:""}}">
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
                    <td align="right">尺码参考：</td>
                    <td><input type="text" name="Size_reference"
                               value="{{isset($set_goods)?$set_goods->Size_reference:''}}" class="Iar_input"></td>
                </tr>
                <tr>
                    <td align="right" style="vertical-align:top;padding-top:8px;">产品参数：</td>

                    <td>
                        <div id="para1_list" class="cfix">
                         @if(isset($set_goods['goods_param']) &&!empty($set_goods['goods_param']))
                                @foreach($set_goods['goods_param'] as $k=>$v)
                                <p><a href="javascript:void(0);">{{$v['key']}}</a>：<span>{{$v['vel']}}</span><em></em></p>
                                @endforeach
                         @endif
                        </div>
                        <div class="para_add">
                            <label><input type="text" name="para1_name" id="para1_name"/></label>
                            <label><input type="text" name="para1_value" id="para1_value"/></label>
                            <button id="para1_btn" class="">添加</button>
                        </div>
                        <script>
                            //var data1 = { data: [ {"name": "", "value": ""}, {"name": "", "value": ""} ] }
                            var data1 = {data: []};
                            console.log(JSON.stringify(data1, null, "\t"));		//格式化输出json

                            $("#para1_btn").click(function () {
                                var p_name = $.trim($("#para1_name").val());
                                var p_value = $.trim($("#para1_value").val());

//                                console.log("p_name:" + p_name);
//                                console.log("p_value:" + p_value);

                                if (p_name == "") {
                                    layer.msg("参数名不能为空");
                                    $("#para1_name").focus();
                                    return false;
                                }
                                if (p_value == "") {
                                    layer.msg("参数值不能为空");
                                    $("#para1_value").focus();
                                    return false;
                                }

                                if (checkExist1(p_name)) {
                                    layer.msg("此参数已经存在");
                                    $("#para1_name").focus();
                                    return false;
                                }
                                data1.data.push({"name": p_name, "value": p_value});
//                                console.log(JSON.stringify(data1, null, "\t"));		//格式化输出json

                                reList();
                                $("#para1_name").val("");
                                $("#para1_value").val("");

                                return false;
                            });
                            $("#para1_list").on("click", "p em", function () {			//删除
                                var d_name = $(this).siblings("a").html();
                                $.each(data1.data, function (i) {
                                    if (data1.data[i].name == d_name) {
                                        data1.data.splice(i, 1);
                                        reList();			//刷新	显示列表
                                        return false;
                                    }
                                });
//                                console.log(JSON.stringify(data1, null, "\t"));		//格式化输出json
                            });
                            function reList() {			//刷新	显示列表
                                var str = '';
                                if (data1.data.length > 0) {
                                    $.each(data1.data, function (i) {
                                        str += '<p><a href="javascript:void(0);">' + data1.data[i].name + '</a>：<span>' + data1.data[i].value + '</span><em></em></p>';
                                    });
                                }
                                $("#para1_list").html(str);
                            }
                            function checkExist1(arg1) {			//检查要添加的参数是否已存在
                                var flag = 0;
                                if (!arg1) {
                                    return false;
                                }			//无参数
                                $.each(data1.data, function (i, obji) {
                                    if (obji.name == arg1) {
                                        flag = 1;
                                        return false;
                                    }
                                });
                                return flag;			//返回值为1表示已存在，为0不存在
                            }
                        </script>


                    </td>
                </tr>
                <tr>
                    <td align="right">商品规格：</td>
                    <td>
                        <div id="guige">
                            <div id="guige_list">

                                <table class="table table-border2" id="goods_spec_table1">
                                    <tbody>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>

                        <div id="goods_spec_table2">
                            <table class="table table-border2" id="spec_input_tab">
                                <thead>
                                <tr>
                                    <th>价格</th>
                                    <th>库存</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td></td>
                                    <td></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>

                    </td>
                </tr>

                <script>
                   /* {
                        data: [
                            {
                                "desc": "分类", "name": "裙子", "id": "3", "sub": [
                                {
                                    "desc": "属性", "name": "颜色", "id": "1", "sub": [
                                    {"desc": "规格", "name": "白色", "id": "1", "kucun": 0, "jiage": 0},
                                    {"desc": "规格", "name": "黑色", "id": "2", "kucun": 0, "jiage": 0},
                                    {"desc": "规格", "name": "红色", "id": "3", "kucun": 0, "jiage": 0}
                                ]
                                },
                                {
                                    "desc": "属性", "name": "尺寸", "id": "2", "sub": [
                                    {"desc": "规格", "name": "S", "id": "4", "kucun": 0, "jiage": 0},
                                    {"desc": "规格", "name": "M", "id": "5", "kucun": 0, "jiage": 0},
                                    {"desc": "规格", "name": "L", "id": "6", "kucun": 0, "jiage": 0},
                                    {"desc": "规格", "name": "XL", "id": "7", "kucun": 0, "jiage": 0},
                                    {"desc": "规格", "name": "XLL", "id": "8", "kucun": 0, "jiage": 0}
                                ]
                                },
                                {
                                    "desc": "属性", "name": "布料", "id": "3", "sub": [
                                    {"desc": "规格", "name": "纯棉", "id": "9", "kucun": 0, "jiage": 0},
                                    {"desc": "规格", "name": "羽绒", "id": "10", "kucun": 0, "jiage": 0},
                                    {"desc": "规格", "name": "蝉丝", "id": "11", "kucun": 0, "jiage": 0}
                                ]
                                },
                                {
                                    "desc": "属性", "name": "产地", "id": "4", "sub": [
                                    {"desc": "规格", "name": "深圳", "id": "12", "kucun": 0, "jiage": 0},
                                    {"desc": "规格", "name": "广州", "id": "13", "kucun": 0, "jiage": 0},
                                    {"desc": "规格", "name": "河南", "id": "14", "kucun": 0, "jiage": 0}
                                ]
                                }
                            ]
                            }
                        ]
                    }*/
                    var data3 ="";
                    function getName(num, depth) {			//根据 ID 和 深度 获得 名称，属性 深度为 2, 规格 深度 为 3
                        var name = "";
                        var lei = $("#select_id_1").val();
                        $.each(data3, function (i, itemi) {
                            if (itemi.id == lei) {
                                $.each(itemi.sub, function (j, itemj) {
                                    if (depth == 2) {
                                        if (itemj.id == num) {
                                            name = itemj.name;
                                            return false;
                                        }
                                    } else if (depth == 3) {
                                        $.each(itemj.sub, function (k, itemk) {
                                            if (itemk.id == num) {
                                                name = itemk.name;
                                                return false;
                                            }
                                        });
                                    }
                                });
                            }
                        });
                        return name;
                    }

                    //console.log("data3:", JSON.stringify(data3, null, "\t"));		//格式化输出json

                    $("#goods_spec_table1 tbody").on("click", "tr td button", function () {
                        $(this).toggleClass("btn-default btn-success");
                        resetGuigeList2();
                    });

                    //上传图片
                    function GetUploadify3(k) {
                        cur_item_id = k; //当前规格图片id
//		console.log("k",k);
                        $('input#upfile_n').click();
                        option_n = {
                            url: "http://lingdang.laba.tw/Pic_upload",
                            type: "post",
                            data: {return_type: "string"},
                            enctype: 'multipart/form-data',
                            success: function (ret) {
                                console.log(ret)
//				console.log("cur_item_id", cur_item_id);
                                if (typeof(ret) == "string") {
                                    ret = JSON.parse(ret);
                                }
                                if (ret.sta == "1") {
                                    layer.msg('文件上传成功');
                                    $("#item_img_" + cur_item_id).attr("src", ret.data.url);
                                    $("#item_img_" + cur_item_id).attr("data-md5", ret.data.md5);
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
                        $("input#upfile_n").change(function () {
                            $("#form_n").ajaxSubmit(option_n);
                            $('input#upfile_n').unbind("change");
                            $('input#upfile_n').remove();
                            var count_n = $("#form_n").attr("data");
                            count_n++;
                            $("#form_n").attr("data", count_n);
                            $("#form_n").append('<input type="file" name="file" id="upfile_n" data="' + count_n + '" />');
                        });
                    }

                    function resetGuigeList() {			//显示规格列表
                        var str = "";
                        var fenlei = $("#select_id_1").val();
                        $.each(data3, function (i, itemi) {//
                            if (itemi.id == fenlei) {
                                $.each(itemi.sub, function (j, itemj) {
                                    str += "<tr>";
                                    str += "<td><span>" + itemj.name + "</span>:</td>";
                                    str += "<td>";
                                    $.each(itemj.sub, function (k, itemk) {
                                        str += '<button type="button" data-spec_id="' + itemj.id + '" data-item_id="' + itemk.id + '" class="btn btn-default">' + itemk.name + '</button>';
                                        str += '<img width="35" height="35" src="/images/add-button.jpg" id="item_img_' + itemk.id + '" onclick="GetUploadify3(\'' + itemk.id + '\');">';
                                        str += '&nbsp;&nbsp;&nbsp;';
                                    });
                                    str += "</td>";
                                    str += "</tr>";
                                });
                            }
                        });
                        if (str == "") {
                            str = "<tr><td></td><td></td></tr>";
                        }
                        $("#guige_list table#goods_spec_table1 tbody").html(str);
                    }

                    function resetGuigeList2() {			//显示 价格、库存 输入列表
                        if ($("#goods_spec_table1 button.btn-success").length > 0) {
                            ajaxGetSpecInput();
                        } else {
                            var str1 = "<tr><th>价格</th><th>库存</th></tr>";
                            var str2 = "<tr><td></td><td></td></tr>";
                            $("#spec_input_tab thead").html(str1);
                            $("#spec_input_tab tbody").html(str2);
                        }
                    }

                    function ajaxGetSpecInput() {
//		var spec_arr = {1:[1,2]};// 用户选择的规格数组 	  
//		spec_arr[2] = [3,4]; 
                        var spec_arr = {};// 用户选择的规格数组
                        $("#goods_spec_table1 button").each(function () {
                            if ($(this).hasClass('btn-success')) {
                                var rename = $(this).closest("td").prev("td").find("span").html();
                                var name = $(this).html();
                                var spec_id = $(this).data('spec_id');
//				var spec_id = rename;
                                var item_id = $(this).data('item_id');
//				var item_id = name;

//				console.log("spec_id:"+spec_id);
//				console.log("item_id:"+item_id);
                                if (!spec_arr.hasOwnProperty(spec_id))
                                    spec_arr[spec_id] = [];
                                spec_arr[spec_id].push(item_id);
                            }
                        });

//						console.log("spec_arr", JSON.stringify(spec_arr, null, "\t"));	//{ "颜色": [ "红色", "绿色", "黄色" ], "尺码": [  "M", "L2" ]}
                        getArr2(spec_arr);			//获得组合数组
                        getArr2Html(results);			//获得组合数组后重组html
                    }

                    var temp1 = [];
                    var results = [];
                    var indexs = {};
                    //	var array = [[['颜色','白色'], ['颜色','红色'], ['颜色','黑色']], [['内存','4g'],['内存','16g']]];
                    var array = [];
                    var len = array.length;

                    function getArr2(obj) {			//获得组合数组
                        temp1 = [];
                        var temp2 = [];
                        for (var i in obj) {
                            temp2 = [];
                            //		console.log(i);			//颜色
                            //		console.log(obj[i]);		//["绿色", "黄色"]
                            for (var j in obj[i]) {
                                //			console.log(j);			//0
                                //			console.log(obj[i][j]);		//绿色
                                temp2.push([i, obj[i][j]]);
                            }
//			console.log("temp2:",JSON.stringify(temp2) );
                            //temp2: [["颜色","红色"],["颜色","绿色"],["颜色","黄色"]]
                            //temp2: [["尺码","M"],["尺码","L2"]]
                            temp1.push(temp2);
                        }
//						console.log("temp1:", JSON.stringify(temp1));
                        //temp1: [ [ ["颜色","红色"], ["颜色","绿色"], ["颜色","黄色"] ], [ ["尺码","M"], ["尺码","L2"] ] ]

                        array = temp1;
                        len = array.length;
                        results = [];
                        indexs = {};
                        specialSort(-1);
//		console.log( "results",JSON.stringify( results ) );
//		console.log( "results",JSON.stringify( results, null, "\t") );

                        //	return temp1;
                    }

                    function getArr2Html(arr) {
						var str1 = "";			//tr th
						var str2 = "";			//tr td
						var ids0 ;
						var ids ;
						$.each( arr, function(i,itemi){
				//			console.log("i",i);
				//			console.log("itemi",JSON.stringify(itemi) );
							if( i==0 ){	str1 += "<tr>";	}
							str2 += "<tr class='data-tr'>";
							ids0 = "";
							ids = "";
							$.each( itemi, function(j,itemj){
				//				console.log("j",j);
				//				console.log("itemj",JSON.stringify(itemj) );
				//				console.log("itemj",JSON.stringify(itemj[0]) );
				//				console.log("itemj",JSON.stringify(itemj[1]) );
				//				if( i==0 ){	str1 += "<th>" + itemj[0] + "</th>"; }
								if( i==0 ){	str1 += "<th>" + getName( itemj[0], 2 ) + "</th>"; }
				//				str2 += "<td>" + itemj[1] + "</td>";
								str2 += "<td>" + getName( itemj[1], 3 ) + "</td>";
								if( ids0 == "" ){
									ids0 += itemj[0];
								}else{
									ids0 += "," + itemj[0];
								}
								if( ids == "" ){
									ids += itemj[1];
								}else{
									ids += "," + itemj[1];
								}
							});
							if( i==0 ){
								str1 += "<th>价格</th>";
								str1 += "<th>库存</th>";
								str1 += "</tr>\n";
							}
							
							str2 += '<td><input class="jiage_i" data-cid="' + ids0 + '" data-gid="' + ids + '" name="item[' + ids + '][price]" value="0" /></td>';
							str2 += '<td><input class="kucun_i" data-cid="' + ids0 + '" data-gid="' + ids + '" name="item[' + ids + '][store_count]" value="0" /></td>';
							str2 += "</tr>\n";
				//			console.log("str1",str1);
						});

                        $("#spec_input_tab thead").html(str1);
                        $("#spec_input_tab tbody").html(str2);
                        hbdyg();
//		console.log("str2",str2);
                    }

					//获得价格库存列表
					function getInput(){
						var arr = [];
						var temp = [];
						$(".jiage_i").each(function(i){
				//			console.log("i:", i);
							var dataGid = $(this).attr("data-gid");
							var jiage = $(this).val();
							var kucun = $(this).closest("tr").find(".kucun_i").val();
							temp = dataGid.split(",");
							temp.push(jiage);
							temp.push(kucun);		
							arr.push(temp);
						});
//						console.log("arr:", JSON.stringify(arr));
						return arr;
					}
					
                    $("#spec_input_tab tbody").on("keyup", "td input", function () {
                        $(this)[0].value = $(this)[0].value.replace(/[^\d.]/g, "");
                    });
                    $("#spec_input_tab tbody").on("paste", "td input", function () {
                        $(this)[0].value = $(this)[0].value.replace(/[^\d.]/g, "");
                    });

                    // 合并单元格
                    function hbdyg() {
                        var tab = document.getElementById("spec_input_tab"); //要合并的tableID
                        var maxCol = 2, val, count, start;  //maxCol：合并单元格作用到多少列
                        maxCol = $(tab).find("th").length - 2;
//			console.log("maxCol:",maxCol);
                        if (tab != null) {
                            for (var col = maxCol - 1; col >= 0; col--) {
                                count = 1;
                                val = "";
//				for (var i = 0; i < tab.rows.length; i++) {			//与表头一样时会有问题
                                for (var i = 1; i < tab.rows.length; i++) {
                                    if (val == tab.rows[i].cells[col].innerHTML) {
                                        count++;
                                    } else {
                                        if (count > 1) { //合并
                                            start = i - count;
                                            tab.rows[start].cells[col].rowSpan = count;
                                            for (var j = start + 1; j < i; j++) {
                                                tab.rows[j].cells[col].style.display = "none";
                                            }
                                            count = 1;
                                        }
                                        val = tab.rows[i].cells[col].innerHTML;
                                    }
                                }
                                if (count > 1) { //合并，最后几行相同的情况下
                                    start = i - count;
                                    tab.rows[start].cells[col].rowSpan = count;
                                    for (var j = start + 1; j < i; j++) {
                                        tab.rows[j].cells[col].style.display = "none";
                                    }
                                }
                            }
                        }
                    }
                    /*	定义、初始化必要参数
                     var array = [['1', '2', '3'], ['4', '5']];
                     var len = array.length;
                     var results = [];
                     var indexs = {};
                     */
                    function specialSort(start) {
                        start++;
                        if (start > len - 1) {
                            return;
                        }
                        if (!indexs[start]) {
                            indexs[start] = 0;
                        }
                        if (!(array[start] instanceof Array)) {
                            array[start] = [array[start]];
                        }
                        for (indexs[start] = 0; indexs[start] < array[start].length; indexs[start]++) {
                            specialSort(start);
                            if (start == len - 1) {
                                var temp = [];
                                for (var i = len - 1; i >= 0; i--) {
                                    if (!(array[start - i] instanceof Array)) {
                                        array[start - i] = [array[start - i]];
                                    }
                                    temp.push(array[start - i][indexs[start - i]]);
                                }
                                results.push(temp);
                            }
                        }
                    }

                </script>


                <tr>
                    <td align="right">总库存：</td>
                    <td><input name="inventory" type="text" value="{{isset($set_goods)?$set_goods->inventory:''}}"
                               class="Iar_inpun" style="margin-right: 10px;"><font
                                color="red">件</font></td>
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
                                                var num = data.data.SortData.length;
                                                var rst = "";
                                                for (var i = 0; i < num; i++) {
                                                    rst += "<option value=" + data.data.SortData[i]['id'] + ">" + data.data.SortData[i]['brand_name'] + "</option>";
                                                }
                                                $("#set_brand").find("option").remove();
                                                $("#set_brand").append(rst);
                                                data3=data.data.attribut;
                                                resetGuigeList();
                                                resetGuigeList2();
                                                //插入html结构
                                                //  layer.msg(data.msg, {icon: 1});
                                                return true;
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
                            editor.config.uploadImgUrl = "{{route('user.Pic_upload')}}";

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
                <tr>
                    <td align="right">是否积分兑换：</td>
                    <td>
                        <div style=" float:left;">
                            <input type="radio" name="jifenS" id="JFYes" value="1" onclick="JiFen.style.display='';"
                                   > 是
                            <input type="radio" name="jifenS" id="JFNo" value="0" onclick="JiFen.style.display='none';" checked >
                            否
                        </div>
                        <div id="JiFen" style=" float:left;display:none;">
							<input name="jifen_price" type="text" value="" class="Iar_inpun" style="margin:0 10px;">积分/元
                        </div>
                    </td>
                </tr>
                <tr>
                    <td align="right">是否免单：</td>
                    <td>
                        <div style=" float:left;">
                            <input type="radio" name="miandan" id="Yes" value="1" onclick="sd.style.display='';"
                                   > 是
                            <input type="radio" name="miandan" id="No" value="0" onclick="sd.style.display='none';" checked > 否
                        </div>
                        <div id="sd" style=" float:left;display:none;">
							<input name="miandan_num" type="text" value="" class="Iar_inpun" style="margin:0 10px;">免单人数
                        </div>
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
    <script type="text/javascript">
        var options = {
            url: "{{url('Pic_upload')}}",
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
                    $('input[name="upfile_1"]').val(ret.data.md5);
                    $("#uppic_1").attr("src", ret.data.url);
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
 //           console.log("xx");
            $("#file_1").click();
   //         console.log("xx2");
        });
        $("#file_1").change(function () {
            $("#form_1").ajaxSubmit(options);
        });

        var options2 = {
            url: "{{url('Pic_upload')}}",
            type: "post",
            data: {return_type: "string"},
            enctype: 'multipart/form-data',
            success: function (ret) {
                console.log(ret)
                if (typeof(ret) == "string") {
                    ret = JSON.parse(ret);
                }
                if (ret.sta == "1") {
                    if ($("#uppic_2 img[data=" + ret.data.md5 + "]").length < 1) {
                        layer.msg('文件上传成功');
                        $('input[name="upfile_2"]').val(ret.data.md5);
                        var img = '<img data="' + ret.data.md5 + '" src="' + ret.data.url + '" style="width:auto; height: 80px; margin: 5px;">';
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
            var reload_url = "{{url('goods/goods_list')}}";
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
//            dataf['price'] = $("input[name='price']").val();
            dataf['inventory'] = $("input[name='inventory']").val();
            dataf['Size_reference'] = $("input[name='Size_reference']").val();

//            dataf['para1_name'] = $("input[name='para1_name']").val();
//            dataf['para1_value'] = $("input[name='para1_value']").val();
            // 获取编辑器区域完整html代码
            dataf['content'] = editor.$txt.html();

            dataf['recommend'] = "";
            if ($("input[name=recommend]").is(":checked")) {				//我已经阅读并同意云媒体交易平台习家规则
                dataf['recommend'] = $("input[name=recommend]").val();
            }
	//商品参数
			dataf['para1'] = [];
			$("#para1_list p").each(function(){
				var temp = [];
				var name = $(this).find("a").html();
				var value = $(this).find("span").html();
				var temp2 = value.split(",");
				temp.push(name);
				Array.prototype.push.apply(temp, temp2);
				dataf['para1'].push(temp);
			});
		//	console.log(JSON.stringify(dataf['para1']));
			
	//商品规格
//			dataf['guige'] = [];
			dataf['guige'] = getInput();
	
	//是否积分兑换
			dataf['jf_exchange'] = $("input[name='jifenS']:checked").val();
			dataf['jf_price'] = $("input[name='jifen_price']").val();
			
	//是否免单
			dataf['miandan_yes'] = $("input[name='miandan']:checked").val();
			dataf['miandan_num'] = $("input[name='miandan_num']").val();
			
            console.log(dataf);
            URL = "{{isset($set_goods)?route('goods.update'):url('goods/store')}}";
            $.ajax({
                url: URL,
                data: {
                    'goods_id': "{{isset($set_goods)?$set_goods->id:''}}",
                    '_token': "{{csrf_token()}}",
                    "sort_id": dataf['cateid'],
                    "brand_id": dataf['cateid2'],
                    "goods_sort": dataf['goods_sort'],
                    "goods_title": dataf['goods_title'],
                    "Thumbnails": dataf['pic1'],
                    "plan": dataf['pic2'],
//                    "price": dataf['price'],
                    "inventory": dataf['inventory'],
                    "Size_reference": dataf['Size_reference'],
//                    "para1_name": dataf['para1_name'],
//                    "para1_value": dataf['para1_value'],
                    "content": dataf['content'],
                    "recommend": dataf['recommend'],
					"para1": dataf['para1'],
					"guige": dataf['guige'],
					"jf_exchange": dataf['jf_exchange'],
					"jf_price": dataf['jf_price'],
					"FreeCharge": dataf['miandan_yes'],
					"FreeCharge_num": dataf['miandan_num']
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
    {{--更新时触发加载规格--}}
    <script type="text/javascript">
        //当存在sort_goods时触发
        var sort_id="{{isset($set_goods)?$set_goods->sort_id:''}}";
        if(sort_id){
            $.ajax({
                url: "{{url('goods/set_brand_sort')}}",
                data: {
                    'sort_id': sort_id,
                    '_token': "{{csrf_token()}}"
                },
                type: 'post',
                dataType: "json",
                stopAllStart: true,
                success: function (data) {
                    if (data.sta == '1') {
                        data3=data.data.attribut;
                        resetGuigeList();
                        resetGuigeList2();
                        //添加选中效果





                        //插入html结构
                        //  layer.msg(data.msg, {icon: 1});
                        return true;
                        /* setTimeout(window.location.href = reload_url, 1000);*/
                    } else {
                        layer.msg(data.msg || '请求失败');
                    }
                },
                error: function () {
                    return false;
                }
            });
        }
		
		
$(function(){
	//商品规格
	var goods_standard="";//商品规格
	var goods_id="{{isset($set_goods)?$set_goods->id:''}}";
	if(goods_id !=''){
		setTimeout(function(){
			$.ajax({
				url: "{{route('goods.SelGoodStand')}}",
				data: {
					'goods_id':goods_id,
					'_token':"{{csrf_token()}}"
				},
				type: 'get',
				dataType: "json",
				stopAllStart: true,
				success: function (data) {
					if (data.sta == '1') {
						goods_standard=data.data;
						console.log("goods_standard:", JSON.stringify(goods_standard) );//商品规格
						
						var a = [];
						var b = [];
						$.each( goods_standard, function(i,itemi){
							Array.prototype.push.apply(a, itemi.attributes_id.split(","));
						});
						$.each( a, function(i, itemi){
							var data_ok = $("[data-item_id=" + itemi + "]").attr("data-ok");
							if( data_ok != "ok" ){
								console.log($("button[data-item_id='" + itemi + "']").length);
								$("button[data-item_id='" + itemi + "']").click();;
								$("button[data-item_id='" + itemi + "']").attr("data-ok","ok");		
								b.push(itemi);
							}
							if( i == (a.length - 1) ){
						//		console.log("b:",b);
								$.each( goods_standard, function(j,itemj){
									var id = itemj.attributes_id;
									var price = itemj.price;
									var stock = itemj.stock;
									$("[name='item[" + id + "][price]']").val(price);
									$("[name='item[" + id + "][store_count]']").val(stock);
								});		
							}
						});

						console.log(goods_standard);//商品规格
						return true;
					} else {
						layer.msg(data.msg || '请求失败');
					}
				},
				error: function () {
					return false;
				}
			});
		},1000);
	}
});							
    </script>
    <div id="upload_pic" style="display:none;">
        <form id="form_n" action="" method="post" style="" data="0">
            {{csrf_field()}}
            <input type="file" name="file" id="upfile_n" data="0"/>
        </form>
    </div>
	
	
	

@endsection
@section('footer_related')
@endsection
