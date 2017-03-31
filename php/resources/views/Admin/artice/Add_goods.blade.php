@extends('Admin.layout.main')

@section('title', '添加商品')
@section('header_related')
   <link rel="stylesheet" href="{{ url('/css/style.css') }}" type="text/css">
   <script type="text/javascript" src="{{ url('/js/jquery.1.4.2-min.js') }}"></script>
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
    <div class="IAhead"><strong style="padding-right: 10px;">添加商品</strong></div>
    <div class="IAMAIN">
        <form method="post" action="">
            <table width="100%"  cellspacing="0" cellpadding="0">
                <tr>
                    <td align="right" width="120"><font color="red">*</font>所属分类：</td>
                    <td><input  type="text"  value="" class="Iar_list"></td>
                </tr> 
                <tr>
                    <td align="right" width="120"><font color="red">*</font>所属品牌：</td>
                    <td><input  type="text"  value="" class="Iar_list"></td>
                </tr>
                <tr>
                    <td align="right">商品类型：</td>
                    <td><input type="radio" name="radio" id="boy" value="boy"> 女童 <input type="radio" name="radio" id="girl" value="girl"> 男童</td>
                </tr> 
                <tr>
                    <td align="right">商品标题：</td>
                    <td><input  type="text"  value="" class="Iar_input"></td>
                </tr>
                <tr>
                    <td align="right" width="120">缩略图：</td>
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
                    <td align="right" width="120">展示图片：</td>
                    <td>
                        <input type="text" name="" class="Iar_inputt">
                        <input type="button" class="button" value="上传图片"/> <i>*最多可以上传10 张图片</i>
                    </td>
                </tr> 
                <tr>
                    <td align="right"></td>
                    <td>
                        <img src="{{url('images/z_add.png')}}" style="width:auto; height: 80px; margin: 5px;">
                        <img src="{{url('images/z_add.png')}}" style="width:auto; height: 80px; margin: 5px;">
                    </td>
                </tr> 
                <tr>
                    <td align="right">商品总价格：</td>
                    <td><input  type="text"  value="" class="Iar_inpun" style="margin-right: 10px;"><font color="red">元</font></td>
                </tr> 
                <tr>
                    <td align="right">尺码参考：</td>
                    <td><input type="text" name="" class="Iar_input"></td>
                </tr> 
                <tr>
                    <td align="right">尺码：</td>
                    <td><table>
                        <tr>
                            <td style="color: #ff0000; padding-right: 10px;">尺码</td>
                            <td>
                                <div class="plus-tag tagbtn clearfix" id="myTags" style="float: left;width: auto;"></div>
                                <div class="plus-tag-add" style="float: left;width: auto;">
                                    <input id="" name="" type="text" class="stext" maxlength="20" />
                                    <button type="button" class="Button RedButton Button18" >添加</button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td style="color: #ff0000; padding-right: 10px;">肩宽</td>
                            <td>
                                <div class="plus-tagJK tagbtn clearfix" id="myTags" style="float: left;width: auto;"></div>
                                <div class="plus-tag-addJK" style="float: left;width: auto;">
                                    <input id="" name="" type="text" class="stext" maxlength="20" />
                                    <button type="button" class="Button RedButton Button18" >添加</button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td style="color: #ff0000; padding-right: 10px;">衣长</td>
                            <td>
                                
                            </td>
                        </tr>
                        <tr>
                            <td style="color: #ff0000; padding-right: 10px;">袖长</td>
                            <td>
                                
                            </td>
                        </tr>
                        <tr>
                            <td style="color: #ff0000; padding-right: 10px;">胸围</td>
                            <td>
                               
                            </td>
                        </tr>
                    </table></td>
                </tr> 
                <tr>
                    <td align="right">材质：</td>
                    <td>
                        
                    </td>
                </tr>
                <tr>
                    <td align="right">颜色：</td>
                    <td></td>
                </tr>
                <tr>
                    <td align="right">袖型：</td>
                    <td></td>
                </tr>
                <tr>
                    <td align="right">风格：</td>
                    <td></td>
                </tr>
                <tr>
                    <td align="right">版型：</td>
                    <td></td>
                </tr>
                <tr>
                    <td align="right">商品内容详情：</td>
                    <td><font color="red">百度编辑器</font></td>
                </tr> 
                <tr>
                    <td align="right">商品属性：</td>
                    <td><input type="radio" name="radio" id="boy" value="boy"> 推荐 <input type="radio" name="radio" id="girl" value="girl"> 人气</td>
                </tr> 
                <tr height="60px">
                    <td align="right"></td>
                    <td><input type="submit" name="dosubmit" class="button" value="提 交"></td>
                </tr>
            </table>
        </form>
    </div>
</div>

<!---->
<script type="text/javascript">
var FancyForm=function(){
    return{
        inputs:".FancyForm input, .FancyForm textarea",
        setup:function(){
            var a=this;
            this.inputs=$(this.inputs);
            a.inputs.each(function(){
                var c=$(this);
                a.checkVal(c)
            });
            a.inputs.live("keyup blur",function(){
                var c=$(this);
                a.checkVal(c);
            });
        },checkVal:function(a){
            a.val().length>0?a.parent("li").addClass("val"):a.parent("li").removeClass("val")
        }
    }
}();
</script>

<script type="text/javascript">
$(document).ready(function() {
    FancyForm.setup();
});
</script>

<script type="text/javascript">
var searchAjax=function(){};
var G_tocard_maxTips=30;

$(function(){(
    function(){
        
        var a=$(".plus-tag");
        
        $("a em",a).live("click",function(){
            var c=$(this).parents("a"),b=c.attr("title"),d=c.attr("value");
            delTips(b,d)
        });
        
        hasTips=function(b){
            var d=$("a",a),c=false;
            d.each(function(){
                if($(this).attr("title")==b){
                    c=true;
                    return false
                }
            });
            return c
        };

        isMaxTips=function(){
            return  
            $("a",a).length>=G_tocard_maxTips
        };

        setTips=function(c,d){
            if(hasTips(c)){
                return false
            }if(isMaxTips()){
                alert("最多添加"+G_tocard_maxTips+"个标签！");
                return false
            }
            var b=d?'value="'+d+'"':"";
            a.append($("<a "+b+' title="'+c+'" href="javascript:void(0);" ><span>'+c+"</span><em></em></a>"));
            searchAjax(c,d,true);
            return true
        };

        delTips=function(b,c){
            if(!hasTips(b)){
                return false
            }
            $("a",a).each(function(){
                var d=$(this);
                if(d.attr("title")==b){
                    d.remove();
                    return false
                }
            });
            searchAjax(b,c,false);
            return true
        };

        getTips=function(){
            var b=[];
            $("a",a).each(function(){
                b.push($(this).attr("title"))
            });
            return b
        };

        getTipsId=function(){
            var b=[];
            $("a",a).each(function(){
                b.push($(this).attr("value"))
            });
            return b
        };
        
        getTipsIdAndTag=function(){
            var b=[];
            $("a",a).each(function(){
                b.push($(this).attr("value")+"##"+$(this).attr("title"))
            });
            return b
        }
    }
    
)()});
</script>


<script type="text/javascript">
// 更新选中标签标签
$(function(){
    setSelectTips();
    $('.plus-tag').append($('.plus-tag a'));
});
var searchAjax = function(name, id, isAdd){
    setSelectTips();
};
// 搜索
(function(){
    var $b = $('.plus-tag-add button'),$i = $('.plus-tag-add input');
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
})();

(function(){
    
    // 更新高亮显示
    setSelectTips = function(){
        var arrName = getTips();
        if(arrName.length){
            $('#myTags').show();
        }else{
            $('#myTags').hide();
        }
        $('.default-tag a').removeClass('selected');
        $.each(arrName, function(index,name){
            $('.default-tag a').each(function(){
                var $this = $(this);
                if($this.attr('title') == name){
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
