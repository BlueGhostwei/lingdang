@extends('Admin.layout.main')

@section('title', '添加内容')
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
    <div class="IAhead"><strong style="padding-right: 10px;">添加内容</strong></div>
    <div class="IAMAIN">
        <form method="post" action="">
            <table width="100%"  cellspacing="0" cellpadding="0">
                <tr>
                    <td align="right" width="120"><font color="red">*</font>所属分类：</td>
                    <td>            
                        <select name="cateid">
                            <option>请选择栏目</option>
                        </select>           
                    </td>
                </tr> 
                <tr>
                    <td align="right"><font color="red">*</font>内容标题：</td>
                    <td><input  type="text"  value="" class="Iar_input"></td>
                </tr> 
                <tr>
                    <td align="right">作者：</td>
                    <td><input type="text" value="" class="Iar_inpun" /></td>            
                </tr>  
                <td align="right">缩略图：</td>
                    <td>
                        <input type="text" name="" class="Iar_inputt">
                        <input type="button" class="button" value="上传图片"/>
                    </td>
                </tr>
                <tr>
                    <td  align="right"><font color="red">*</font>内容详情：</td>
                    <td>
                        <div id='txtDiv' style='border:1px solid #cccccc; height:300px; width: 80%;'>
                            <p>请输入内容...</p>
                        </div>

                        <div style='margin-top:10px;width: 80%;'>
                            <button id='btnHtml'>查看html</button>
                            <button id='btnText'>查看text</button>
                            <button id='btnHide'>隐藏</button>
                            <textarea id='textarea' style='width:100%; height:100px; margin-top:10px;'></textarea>
                        </div>
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

                        <!--引入 jquery.js 文本框-->
                        <script src="../js/jquery-1.10.2.min.js" type="text/javascript"></script>

                        <!--引入 wangEditor.js-->
                        <script type="text/javascript" src='../js/wangEditor-1.1.0-min.js'></script>
                        <script type="text/javascript">
                            $(function(){
                                $('#spanTime').text((new Date()).toString());

                                //一句话，即可把一个div 变为一个富文本框！o(∩_∩)o 
                                var $editor = $('#txtDiv').wangEditor();

                                //显示 html / text
                                var $textarea = $('#textarea'),
                                    $btnHtml = $('#btnHtml'),
                                    $btnText = $('#btnText'),
                                    $btnHide = $('#btnHide');
                                $textarea.hide();
                                $btnHtml.click(function(){
                                    $textarea.show();
                                    $textarea.val( $editor.html() );
                                });
                                $btnText.click(function(){
                                    $textarea.show();
                                    $textarea.val( $editor.text() );
                                });
                                $btnHide.click(function(){
                                    $textarea.hide();
                                });
                            });
                        </script>

