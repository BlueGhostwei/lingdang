@extends('Admin.layout.main')

@section('title', '添加商品分类')
@section('header_related')
    <link rel="stylesheet" href="{{ url('/css/style.css') }}" type="text/css">

    @endsection
    @section('content')
            <!--<div class="main-container">
        <div class="container-fluid">
            @include('Admin.layout.breadcrumb', [
                'title' => '添加商品分类',
                '' => [
                    '' => '',
                ]
            ])
            </div>
         </div>-->

    <div class="Iartice">
        <div class="IAhead"><strong style="padding-right: 10px;">添加商品分类</strong></div>
        <div class="IAMAIN">
            <form method="post"
                  @if(isset($edit_sort))
                  action="{{route('sort.update',$edit_sort->id)}}"
                  @else
                  action="{{route('sort.store')}}"
                    @endif
            >
                {{csrf_field()}}
                <table width="100%" cellspacing="0" cellpadding="0">
                    <tr style=" height: auto">
                        <td align="right" valign="top"><font color="red">*</font>上级栏目：</td>
                        <td>
                            <select name="cateid" id="good_sort" onchange="gradeChange()">
                                <option data_id="0">作为一级分类</option>
                                @if(isset($sort))
                                    @foreach($sort as $key =>$vel)
                                        <option
                                                @if(isset($id) && $id == $vel['id'])
                                                selected
                                                @endif
                                                data_id="{{$vel['id']}}"

                                        >{{$vel['name']}}</option>
                                        @if(isset($vel['child']) && !empty($vel['child']))
                                            @foreach($vel['child'] as $rst=>$rvb)
                                                <option
                                                        @if(isset($set_goods) && $set_goods->sort_id == $rvb['id'])
                                                        selected
                                                        @endif
                                                        data_id="{{$rvb['id']}}"
                                                >
                                                    {{"|--".$rvb['name']}}

                                                </option>
                                            @endforeach
                                        @endif
                                    @endforeach
                                @endif

                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td align="right"><font color="red">*</font>分类名称：</td>
                        <td>
                            <input type="hidden" name="sort_id" value="">
                            <input type="hidden" name="edit_id" value="{{isset($edit_sort) ? $edit_sort->id : ""}}">
                            <input type="text" name="name"
                                   value="{{isset($edit_sort) ? $edit_sort->name :old('name')}}" {{--class="Iar_input"--}}>
                            @if ($errors->has('name'))
                                <label class="error">
                                    <span class="error">{{ $errors->first('name') }}</span>
                                </label>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td align="right"><font color="red">*</font>缩略图：</td>
                        <td>
                            <div class="" style="position:relative;">
                                    <input type="file" name="file" id="doc" multiple="multiple" style="width:450px;"
                                           onchange="javascript:setImagePreview();">
                                    <input type="hidden" name="img_path" id="img" value="{{isset($edit_sort)?$edit_sort->img_path:""}}">

                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td align="right"></td>
                        <td>
                            <img id="preview"
                                 src=" @if(isset($set_goods)) {{md52url($set_goods->Thumbnails)}}@elseif(isset($edit_sort->img_path)) {{md52url($edit_sort->img_path)}} @else url('images/z_add.png')@endif"
                                 width="100" height="100" style="display: block;"/>
                        </td>
                    </tr>


                    <script type="text/javascript">


                        //下面用于图片上传预览功能
                        function setImagePreview(avalue) {
                            //input
                            var docObj = document.getElementById("doc");
//img
                            var imgObjPreview = document.getElementById("preview");
                            //div
                            var divs = document.getElementById("localImag");
                            if (docObj.files && docObj.files[0]) {
                                //火狐下，直接设img属性
                                imgObjPreview.style.display = 'block';
                                imgObjPreview.style.width = '100px';
                                imgObjPreview.style.height = '100px';
                                //imgObjPreview.src = docObj.files[0].getAsDataURL();
                                //火狐7以上版本不能用上面的getAsDataURL()方式获取，需要一下方式
                                imgObjPreview.src = window.URL.createObjectURL(docObj.files[0]);
                            } else {
                                //IE下，使用滤镜
                                docObj.select();
                                var imgSrc = document.selection.createRange().text;
                                var localImagId = document.getElementById("localImag");
                                //必须设置初始大小
                                localImagId.style.width = "100px";
                                localImagId.style.height = "100px";
                                //图片异常的捕捉，防止用户修改后缀来伪造图片
                                try {
                                    localImagId.style.filter = "progid:DXImageTransform.Microsoft.AlphaImageLoader(sizingMethod=scale)";
                                    localImagId.filters.item("DXImageTransform.Microsoft.AlphaImageLoader").src = imgSrc;
                                } catch (e) {
                                    alert("您上传的图片格式不正确，请重新选择!");
                                    return false;
                                }
                                imgObjPreview.style.display = 'none';
                                document.selection.empty();
                            }
                            var Upload = "{{url('upload')}}";
                            var data = new FormData();
                            //为FormData对象添加数据
                            $.each($('#doc')[0].files, function (i, file) {
                                data.append('_token',"{{csrf_token()}}");
                                data.append('file', file);
                            });
                            $.ajax({
                                url: Upload,
                                type: 'POST',
                                data: data,
                                cache: false,
                                dataType: "json",
                                contentType: false,    //不可缺
                                processData: false,    //不可缺
                                success: function (data) {
                                    //$img.attr('src', data.url);
                                    document.getElementById("img").value = data.md5;
                                },
                                error:function (data) {

                                }
                            });

                            //document.getElementById("img").value = imgObjPreview.src;
                            return true;
                        }
                    </script>

                    <tr>
                        <td align="right"><font color="red">*</font>栏目简介：</td>
                        <td><textarea name="content" class="describe">{{ isset($edit_sort)? $edit_sort->content:old('content')}}</textarea></td>
                    </tr>
                    <tr>
                        <td align="right">排列顺序：</td>
                        <td><input type="text" name="num" value="{{ isset($edit_sort)? $edit_sort->num :old('num')}}"
                                   class="Iar_inpun"/></td>
                    </tr>

                    <tr height="60px">
                        <td align="right"></td>
                        <td><input type="submit" name="dosubmit" class="button" value="提 交"></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
@endsection
@section('footer_related')
    <script type="text/javascript">
        $(document).ready(function () {
            var sort = $('#good_sort option:selected').attr('data_id');
            $("input[name='sort_id']").val(sort);
        });
        function gradeChange() {
            var sort = $('#good_sort option:selected').attr('data_id');
            $("input[name='sort_id']").val(sort);
        }
    </script>
@endsection
