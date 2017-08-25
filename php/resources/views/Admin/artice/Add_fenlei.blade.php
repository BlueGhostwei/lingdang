@extends('Admin.layout.main')

@section('title', '添加文章分类')
@section('header_related')
    <link rel="stylesheet" href="{{ url('/css/style.css') }}" type="text/css">
    @endsection
    @section('content')
            <!--<div class="main-container">
        <div class="container-fluid">
            @include('Admin.layout.breadcrumb', [
                'title' => '添加文章分类',
                '' => [
                    '' => '',
                ]
            ])
            </div>
         </div>-->

    <div class="Iartice">
        <div class="IAhead"><strong style="padding-right: 10px;">添加分类</strong></div>
        <div class="IAMAIN">
            <form method="post"
                  action="@if(isset($Rst_Data)){{route('support.update')}}@else{{route('artice.save_fenlei')}}@endif">
                {{csrf_field()}}
                <table width="100%" cellspacing="0" cellpadding="0">
                    <tr>
                        <td align="right"><font color="red">*</font>栏目类型：</td>
                        <td>内容管理</td>
                    </tr>
                    <tr>
                        <td align="right"><font color="red">*</font>栏目名称：</td>
                        <td>
                            @if(isset($Rst_Data))
                                <input type="hidden" name="id" value="{{$Rst_Data->id}}">
                            @endif
                            <input type="text" name="sort_name"
                                   value="{{isset($Rst_Data)?$Rst_Data->name:old('sort_name')}}" class="Iar_input">
                            @if ($errors->has('sort_name'))
                                <label class="error">
                                    <span class="error">{{ $errors->first('sort_name') }}</span>
                                </label>
                            @endif</td>


                    </tr>
					<tr>
                        <td align="right"><font color="red">*</font>缩略图：</td>
                        <td>
							<div class="" style="position:relative;">
								<form method="get" action="xznetwork" name="textfile">
						   <input type="file" name="file" id="doc" multiple="multiple" style="width:450px;" onchange="javascript:setImagePreview();">
						          <input type="hidden"  name="img_path" id="img" value="{{isset($Rst_Data)?$Rst_Data->img_path:""}}">
						</form>
							</div>
						</td>
                    </tr>
					<tr>
						<td align="right"></td>
						<td>							
							<img id="preview" src="{{isset($Rst_Data)?md52url($Rst_Data->img_path):url('images/z_add.png')}}" width="100" height="100" style="display: block;" />
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
                    } catch(e) {
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
                        <td align="right">排列顺序：</td>
                        <td><input type="text" name="sort_num"
                                   value="{{ isset($Rst_Data)? $Rst_Data->num:old('sort_num')}}" class="Iar_inpun"/>
                        </td>
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
@endsection
