@extends('Admin.layout.main')

@section('title', '添加商品分类')
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
    <div class="IAhead"><strong style="padding-right: 10px;">添加商品分类</strong></div>
    <div class="IAMAIN">
        <form method="post" action="">
            <table width="100%"  cellspacing="0" cellpadding="0">
                <tr style=" height: auto">
                    <td align="right" valign="top"><font color="red">*</font>上级栏目：</td>
                    <td>
                        <select name="cateid">
                            <option>作为一级分类</option>
                            <option><div style="float: left;">宝宝服饰</div></option>
                                <!--<ul>
                                    <li><option> ├─防辐射服</option></li>
                                    <li><option> ├─文胸内裤</option></li>
                                </ul>-->
                            <option>妈咪包背婴带</option>
                            <option>妈妈专区</option>
                        </select>
                    </td>
                </tr> 
                <tr>
                    <td align="right"><font color="red">*</font>分类名称：</td>
                    <td><input  type="text"  value="" class="Iar_input"></td>
                </tr> 
                <tr>
                    <td align="right">排列顺序：</td>
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
