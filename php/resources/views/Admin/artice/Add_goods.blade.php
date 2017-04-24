@extends('Admin.layout.main')

@section('title', '添加商品')
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
                'title' => '添加商品',
                '' => [
                    '' => '',
                ]
            ])
        </div>
     </div>-->

<div class="Iartice">
    <div class="IAhead"><strong style="padding-right: 10px;">添加商品</strong></div>
    <div class="IAMAIN">
<!--
        <form method="post" action="">
-->
            <table width="100%"  cellspacing="0" cellpadding="0">
                <tr>
                    <td align="right" width="120"><font color="red">*</font>所属分类：</td>
                    <td>
                        <select name="cateid" id="select_id_1" class="asnt" >
                            <option value="0" >请选择分类</option>
                            @if(isset($sort))
                                @foreach($sort as $key =>$vel)
                                    <option
                                            @if(isset($id) && $id == $vel['id'])
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
                        <select name="cateid" class="asnt">
                            <option value="0">请选择品牌</option>
                            <option>所属分类</option>
                            <option>所属分类</option>
                        </select>  
                    </td>
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
<div class="" style="position:relative;">
	<form id="form_1" action="" method="post" style="aposition:relative;z-index:1000;">
		<input type="file" name="file" id="file_1" style="opacity:0;position:absolute;left:347px;top:0;width:68px;height:26px;cursor:pointer;"	/>
		<input type="text" name="upfile_1" id="upfile_1" class="Iar_inputt">
		<input type="button" class="button" id="up_1" value="上传图片"/>
	</form>
</div>
                    </td>
                </tr> 
                <tr>
                    <td align="right"></td>
                    <td>
						<img id="uppic_1" src="{{url('images/z_add.png')}}" style="width:auto; height: 80px; margin: 5px 0;">
					</td>
                </tr> 
                <tr>
                    <td align="right" width="120">展示图片：</td>
                    <td>
<div class="" style="position:relative;">
	<form id="form_2" action="" method="post" style="aposition:relative;z-index:1000;">
		<input type="file" name="file" id="file_2" style="opacity:0;position:absolute;left:347px;top:0;width:68px;height:26px;cursor:pointer;"	/>
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
							<img id="add_uppic_2" src="{{url('images/z_add.png')}}" style="width:auto; height: 80px; margin: 5px;">
						</div>
                    </td>
                </tr> 
                <tr>
                    <td align="right">商品总价格：</td>
                    <td><input  type="text"  value="" class="Iar_inpun" style="margin-right: 10px;"><font color="red">元</font></td>
                </tr> 
                <tr>
                    <td align="right">库存：</td>
                    <td><input  type="text"  value="" class="Iar_inpun" style="margin-right: 10px;"><font color="red">个</font></td>
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
                                <div data="1" class="plus-tag tagbtn clearfix" style="float: left;width: auto;"></div>
                                <div data="1" class="plus-tag-add" style="float: left;width: auto;">
                                    <input id="" name="" type="text" class="stext" maxlength="20" />
                                    <button type="button" class="Button RedButton Button18" >添加</button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td style="color: #ff0000; padding-right: 10px;">肩宽</td>
                            <td>
                                <div data="2" class="plus-tag tagbtn clearfix" style="float: left;width: auto;"></div>
                                <div data="2" class="plus-tag-add" style="float: left;width: auto;">
                                    <input id="" name="" type="text" class="stext" maxlength="20" />
                                    <button type="button" class="Button RedButton Button18" >添加</button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td style="color: #ff0000; padding-right: 10px;">衣长</td>
                            <td>
                                <div data="3" class="plus-tag tagbtn clearfix" style="float: left;width: auto;"></div>
                                <div data="3" class="plus-tag-add" style="float: left;width: auto;">
                                    <input id="" name="" type="text" class="stext" maxlength="20" />
                                    <button type="button" class="Button RedButton Button18" >添加</button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td style="color: #ff0000; padding-right: 10px;">袖长</td>
                            <td>
                                <div data="4" class="plus-tag tagbtn clearfix" style="float: left;width: auto;"></div>
                                <div data="4" class="plus-tag-add" style="float: left;width: auto;">
                                    <input id="" name="" type="text" class="stext" maxlength="20" />
                                    <button type="button" class="Button RedButton Button18" >添加</button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td style="color: #ff0000; padding-right: 10px;">胸围</td>
                            <td>
                                <div data="5" class="plus-tag tagbtn clearfix" style="float: left;width: auto;"></div>
                                <div data="5" class="plus-tag-add" style="float: left;width: auto;">
                                    <input id="" name="" type="text" class="stext" maxlength="20" />
                                    <button type="button" class="Button RedButton Button18" >添加</button>
                                </div>
                            </td>
                        </tr>
                    </table></td>
                </tr> 
                <tr>
                    <td align="right">材质：</td>
                    <td>
                                <div data="6" class="plus-tag tagbtn clearfix" style="float: left;width: auto;"></div>
                                <div data="6" class="plus-tag-add" style="float: left;width: auto;">
                                    <input id="" name="" type="text" class="stext" maxlength="20" />
                                    <button type="button" class="Button RedButton Button18" >添加</button>
                                </div>
                    </td>
                </tr>
                <tr>
                    <td align="right">颜色：</td>
                    <td>
                                <div data="7" class="plus-tag tagbtn clearfix" style="float: left;width: auto;"></div>
                                <div data="7" class="plus-tag-add" style="float: left;width: auto;">
                                    <input id="" name="" type="text" class="stext" maxlength="20" />
                                    <button type="button" class="Button RedButton Button18" >添加</button>
                                </div>
					</td>
                </tr>
                <tr>
                    <td align="right">袖型：</td>
                    <td>
                                <div data="8" class="plus-tag tagbtn clearfix" style="float: left;width: auto;"></div>
                                <div data="8" class="plus-tag-add" style="float: left;width: auto;">
                                    <input id="" name="" type="text" class="stext" maxlength="20" />
                                    <button type="button" class="Button RedButton Button18" >添加</button>
                                </div>
					</td>
                </tr>
                <tr>
                    <td align="right">风格：</td>
                    <td>
                                <div data="9" class="plus-tag tagbtn clearfix" style="float: left;width: auto;"></div>
                                <div data="9" class="plus-tag-add" style="float: left;width: auto;">
                                    <input id="" name="" type="text" class="stext" maxlength="20" />
                                    <button type="button" class="Button RedButton Button18" >添加</button>
                                </div>
					</td>
                </tr>
                <tr>
                    <td align="right">版型：</td>
                    <td>
                                <div data="10" class="plus-tag tagbtn clearfix" style="float: left;width: auto;"></div>
                                <div data="10" class="plus-tag-add" style="float: left;width: auto;">
                                    <input id="" name="" type="text" class="stext" maxlength="20" />
                                    <button type="button" class="Button RedButton Button18" >添加</button>
                                </div>
					</td>
                </tr>
                <tr>
                    <td align="right">商品内容详情：</td>
                    <td>					
                            <div style="width:70%;margin-top:8px;">
                                <div id="texDiv" style="height:400px;max-height:500px;">
                                    {!!isset($actice)?$actice->content:old('content')!!}
                                    @if ($errors->has('title'))
                                        <label class="error">
                                            <span class="error">{{ $errors->first('title') }}</span>
                                        </label>
                                        @elseif(!isset($actice))
                                        <p>请输入内容...</p>
                                    @endif
                                </div>
                            </div>

    <script type="text/javascript" src="{{url('/js/wangEditor/dist/js/wangEditor.min.js')}}"></script>
     <script type="text/javascript">
      $(function () {
         $('#select_id_1').change(function () {
             var srt_id=$(this).val();
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
                         layer.msg(data.msg, {icon: 1});
                        /* setTimeout(window.location.href = reload_url, 1000);*/
                     } else {
                         layer.msg(data.msg || '请求失败');
                     }
                 },
                 error: function () {
                     layer.msg(data.msg || '网络发生错误');
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
                    <td><input type="radio" name="radio" id="boy" value="boy"> 推荐 </td>
                </tr> 
                <tr height="60px">
                    <td align="right"></td>
                    <td><input type="submit" name="dosubmit" class="button" value="提 交"></td>
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
        url : "{{url('upload')}}",
		type : "post",
		data : { return_type : "string" },
		enctype: 'multipart/form-data',
        success : function(ret) {
			console.log(ret)
			if( typeof(ret) == "string" ){	ret = JSON.parse(ret);	}
			if(ret.sta == "1"){
				layer.msg('文件上传成功');
				$('input[name="upfile_1"]').val(ret.md5);
				$("#uppic_1").attr("src",ret.url);				
			}else{
				layer.msg(ret.msg);
			}
        },  
        error : function(ret){  
			layer.msg("网络错误");
			console.log(ret);
        },  
		clearForm : false,
        timeout : 100000
    };
	$("#up_1").click(function(){
		$("#file_1").click();
	});
	$("#uppic_1").click(function(){
		console.log("xx");
		$("#file_1").click();
		console.log("xx2");
	});
	$("#file_1").change(function () {
		$("#form_1").ajaxSubmit(options);
	});

	var options2 = {
        url : "{{url('upload')}}",
		type : "post",
		data : { return_type : "string" },
		enctype: 'multipart/form-data',
        success : function(ret) {
			console.log(ret)
			if( typeof(ret) == "string" ){	ret = JSON.parse(ret);	}
			if(ret.sta == "1"){
				if( $("#uppic_2 img[data=" + ret.md5 + "]").length < 1 ){
					layer.msg('文件上传成功');
					$('input[name="upfile_2"]').val(ret.md5);
					var img = '<img data="' + ret.md5 + '" src="' + ret.url + '" style="width:auto; height: 80px; margin: 5px;">';
					$("#uppic_2").prepend(img);
				}else{
					layer.msg("此图片已经存在");
				}
			}else{
				layer.msg(ret.msg);
			}
        },  
        error : function(ret){  
			layer.msg("网络错误");
			console.log(ret);
        },  
		clearForm : false,
        timeout : 100000
    };
	$("#add_uppic_2").click(function(){
		$("#file_2").click();
	});
	$("#up_2").click(function(){
		$("#file_2").click();
	});
	$("#file_2").change(function () {
		$("#form_2").ajaxSubmit(options2);
	});
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
var searchAjax=function(){};
var G_tocard_maxTips=30;
$(function(){(
    function(){
        
		$(".plus-tag-add").each(function(){
			var $this = $(this);
	//        var a=$(".plus-tag");
			var a=$this.prev(".plus-tag");
			
			$(".plus-tag").on("click","a em",function(){
				
				var a = $(this).parents(".plus-tag");
				var c=$(this).parents("a"),b=c.attr("title"),d=c.attr("value");
				delTips(b,d,a)
			});
			
			hasTips=function(b,aaa){
				
				var d=$("a",aaa),c=false;
				d.each(function(){
					if($(this).attr("title")==b){
						c=true;
						return false
					}
				});
				
				
				return c
			};

			isMaxTips=function(aaa){
				return $("a",aaa).length>=G_tocard_maxTips;
			};

			setTips=function(c,d,aaa){
				if(hasTips(c,aaa)){
					return false
				}if(isMaxTips(aaa)){
					alert("最多添加"+G_tocard_maxTips+"个标签！");
					return false
				}
				var b=d?'value="'+d+'"':"";
				
				aaa.append($("<a "+b+' title="'+c+'" href="javascript:void(0);" ><span>'+c+"</span><em></em></a>"));
				searchAjax(c,d,true);
				return true
			};

			delTips=function(b,c,aaa){
				
				if(!hasTips(b,aaa)){
					return false
				}
				$("a",aaa).each(function(){
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
			
			
			var $b = $this.find('button'),$i = $this.find('input');
			$i.keyup(function(e){
				if(e.keyCode == 13){
					$b.click();
				}
			});
			$b.click(function(){
				var name = $i.val().toLowerCase();
				if(name != '') setTips(name,-1,a);
				$i.val('');
				$i.select();
			});
		});
	
    }
    
)()});
</script>
<script type="text/javascript">
// 更新选中标签标签
$(function(){
 //   setSelectTips();
//    $('.plus-tag').append($('.plus-tag a'));
});
var searchAjax = function(name, id, isAdd){
//    setSelectTips();
};
// 搜索
(function(){
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

(function(){
    
    // 更新高亮显示
    setSelectTips = function(){
        var arrName = getTips();
        if(arrName.length){
//            $('#myTags').show();
        }else{
//            $('#myTags').hide();
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
