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
                    <td align="right" width="120">头像：</td>
                    <td>
                        <input type="text" name="" class="Iar_inputt">
                        <input type="button" class="button" value="上传图片"/>
                    </td>
                </tr> 
                <tr>
                    <td align="right"></td>
                    <td><img src="{{url('images/z_add.png')}}" style="width:auto; height: 80px; margin: 5px 0;"></td>
                </tr>
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
