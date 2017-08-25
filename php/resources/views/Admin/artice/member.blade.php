@extends('Admin.layout.main')

@section('title', '添加会员')
@section('header_related')
   <link rel="stylesheet" href="{{ url('/css/style.css') }}" type="text/css">

@endsection
@section('content')
    <!--<div class="main-container">
        <div class="container-fluid">
            @include('Admin.layout.breadcrumb', [
                'title' => '添加文章',
                '' => [
                    '' => '',
                ]
            ])
        </div>
     </div>-->

<div class="Iartice">
    <div class="IAhead"><strong style="padding-right: 10px;">添加会员</strong></div>
    <div class="IAMAIN">
        <form method="post" action="">
            <table width="100%"  cellspacing="0" cellpadding="0">
                <tr>
                    <td align="right" width="120"><font color="red">*</font>用户名：</td>
                    <td><input  type="text"  value="" class="Iar_list"><i>*登录用户名</i></td>
                </tr> 
                <tr>
                    <td align="right" width="120"><font color="red">*</font>密码：</td>
                    <td><input  type="text"  value="" class="Iar_list"><i>*不填写默认为原密码</i></td>
                </tr>
                <tr>
                        <td align="right"><font color="red">*</font>缩略图：</td>
                        <td>
							<div class="" style="position:relative;">
								<form method="get" action="xznetwork" name="textfile">
						   <input type="file" name="file" id="doc" multiple="multiple" style="width:450px;" onchange="javascript:setImagePreview();">
						</form>
							</div>
						</td>
                    </tr>
					<tr>
						<td align="right"></td>
						<td>							
							<img id="preview" src="{{isset($set_goods)?md52url($set_goods->Thumbnails):url('images/z_add.png')}}" width="100" height="100" style="display: block;" />
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
                return true;
            }
        </script>
		
                <tr>
                    <td align="right">昵称：</td>
                    <td><input  type="text"  value="" class="Iar_list"></td>
                </tr> 
                <tr>
                    <td align="right">签名：</td>
                    <td><input  type="text"  value="" class="Iar_input"></td>
                </tr> 
                <tr>
                    <td align="right">账户金额：</td>
                    <td><input  type="text"  value="" class="Iar_inpun" style="margin-right: 10px;"><font color="red">元</font></td>
                </tr> 
                <tr>
                    <td align="right">积分：</td>
                    <td><input  type="text"  value="" class="Iar_inpun"></td>
                </tr> 
                <tr>
                    <td align="right">手机：</td>
                    <td><input  type="text"  value="" class="Iar_list"></td>
                </tr> 
                <tr>
                    <td align="right">邮箱：</td>
                    <td><input  type="text"  value="" class="Iar_list"></td>
                </tr> 
                <tr>
                    <td align="right">性别：</td>
                    <td><input type="radio" name="radio" id="boy" value="boy"> 男 <input type="radio" name="radio" id="girl" value="girl"> 女</td>
                </tr> 
                <tr>
                    <td align="right">生日：</td>
                    <td><input  type="text"  value="" class="Iar_list"></td>
                </tr> 
                <tr>
                    <td align="right">身高：</td>
                    <td><input  type="text"  value="" class="Iar_inpun"></td>
                </tr> 
                <tr>
                    <td align="right">地址：</td>
                    <td><input type="text" value="" class="Iar_input" /></td>            
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
