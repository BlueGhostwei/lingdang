@extends('Admin.layout.main')

@section('title', '添加幻灯片')
@section('header_related')
   <link rel="stylesheet" href="{{ url('/css/style.css') }}" type="text/css">

@endsection
@section('content')
   {{-- <div class="main-container">
        <div class="container-fluid">
            @include('Admin.layout.breadcrumb', [
                'title' => '添加文章',
                '' => [
                    '' => '',
                ]
            ])--}}

<div class="Iartice">
    <div class="IAhead"><strong style="padding-right: 10px;">添加幻灯片</strong></div>
    <div class="IAMAIN">
        <form method="post" action="">
            <table width="100%"  cellspacing="0" cellpadding="0">
                <tr>
                    <td align="right"><font color="red">*</font>幻灯名称：</td>
                    <td><input  type="name"  value="" class="Iar_input"></td>
                </tr> 
                <tr>
                    <td align="right"><font color="red">*</font>图片地址：</td>
                    <td><input type="url_line" name="" class="Iar_inputt">
                        <input type="button" class="button" value="上传图片"/></td>
                </tr> 
                <tr>
                    <td align="right"></td>
                    <td><img src="{{url('images/z_add.png')}}" style="width:auto; height: 80px; margin: 5px 0;"></td>
                </tr> 
               <tr>
                    <td align="right"><font color="red">*</font>链接地址：</td>
                    <td><input  type="text"  value="" class="Iar_input" placeholder="http://"></td>
                </tr> 
                <tr>
                    <td align="right">排列顺序:：</td>
                    <td><input type="text" value="" class="Iar_inpun" /></td>            
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
