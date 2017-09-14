@extends('Admin.layout.main')

@section('title', '添加规格')
@section('header_related')
    <link rel="stylesheet" href="{{ url('/css/style.css') }}" type="text/css">
    <script type="text/javascript" src="{{ url('/js/jquery.1.4.2-min.js') }}"></script>
    @endsection
    @section('content')
            <!--<div class="main-container">
        <div class="container-fluid">
          {{--  @include('Admin.layout.breadcrumb', [
                'title' => '添加文章',
                '' => [
                    '' => '',
                ]
            ])--}}
            </div>
         </div>-->

    <div class="Iartice">
          <div class="IAhead"><strong style="padding-right: 10px;">商品管理</strong><a href="{{ route('artice.M_properties') }}">商品属性</a>|<a href="{{ route('artice.Add_properties') }}">添加属性</a>|<a href="{{ route('goods.Add_goods') }}">添加商品</a>|</div>
	 
        <div class="IAMAIN">
            <form method="post" action="@if(isset($_GET['type'])  && $_GET['type']=="update" && $_GET['id']){{route('artice.ProductFormat')."?type=update&id=".$_GET['id']}} @else{{route('artice.ProductFormat')}} @endif">
           {{csrf_field()}}
            <table width="100%" cellspacing="0" cellpadding="0">
                <tr style=" height: auto">
                    <td align="right" valign="top"><font color="red">*</font>所属分类：</td>
                    <td>
                        <select name="sort_id" id="select_id_1" class="asnt">
                            <option value="0">请选择分类</option>
                            @if(isset($Sort_arr) && !empty($Sort_arr))
                                    @foreach($Sort_arr as $ky =>$vk)
                                    <option value="{{$vk['id']}}"  @if(isset($GetSort_id) && $GetSort_id==$vk['id']) selected="selected"  @endif >{{$vk['name']}}</option>
                                    @endforeach
                                @endif
                        </select>
                    </td>
                </tr>
                <tr>
                    <td align="right"><font color="red">*</font>商品属性：</td>
                    <td>
						<select name="attribute_id" id="select_id_2" class="asnt">
							<option value="0">请选择分类</option>
                              @if(isset($attributes_data) && !empty($attributes_data))
                                @foreach($attributes_data as $s =>$t)
                                    <option value="{{$t['id']}}"  @if(isset($id) && $id==$t['id']) selected="selected"  @endif >{{$t['arr_name']}}</option>
                                    @endforeach
                                @endif
                        </select>
					</td>
                </tr>
				<tr>
                    <td align="right"><font color="red">*</font>规格项：</td>
                    <td><textarea name="format" value="" class="specifications">@if(isset($attr_sort) && !empty($attr_sort)){!! $attr_sort!!} @endif</textarea></td>
                </tr>
              {{--  <tr>
                    <td align="right">排列顺序：</td>
                    <td><input type="text" name="store_num" value="{{isset($Get_Brand)?$Get_Brand[0]['brand_num']:""}}"  class="Iar_inpun"/></td>
                </tr>--}}

                <tr height="60px">
                    <td align="right"></td>
                    <td><input type="submit" name="dosubmit" class="sumbutton" value="提 交"></td>
                </tr>
            </table>
           </form>
        </div>
    </div>


    
    <script type="text/javascript">
        $(function () {
            $("#myTags a").each(function (e) {
                var id = $(this).attr("value");
                if (id != '') {
                    $('.default-tag a').each(function () {
                        var $this = $(this);
                        var $get_id = $(this).attr('value');
                        if ($get_id == id) {
                            $this.addClass('selected');
                        }
                    })
                }
            });
            {{--触发opption点击事件--}}
          $("#select_id_1").change(function(){
               var sort_id= $("#select_id_1").find("option:selected").val();
                $.ajax({
                    url:"{{route('artice.Add_specifications')}}",
                    type: 'get',
                    data: {
                        sort_id:sort_id
                    },
                    dataType: "json",
                    success: function (data) {
                     if(data.sta=='1'){
                         $("#select_id_2").find("option").remove();
                         var t= data.data.length;

                         if(t >=1){
                             var html="<option value='0'>请选择分类</option>";
                             $('#select_id_2').append(html);
                             for (var i =0; i <= t-1; i++) {
                                 var html ="<option value="+data.data[i].id+">"+data.data[i].arr_name+"</option>";
                                 $('#select_id_2').append(html);
                             }
                         }else{
                             var html="<option value='0'>请选择分类</option>";
                             $('#select_id_2').append(html);
                         }
                     }else{
                         alert(data.msg);
                     }
                    
                    },
                    error:function (data) {

                    }
                });
            });
             $("#select_id_2").change(function(){
               var att_id= $("#select_id_2").find("option:selected").val();
                 $.ajax({
                     url:"{{route('artice.Add_specifications')}}",
                     type: 'get',
                     data: {
                         att_id:att_id
                     },
                     dataType: "json",
                     success: function (data) {
                         $('.specifications').attr('value',data.data);
                         return true;

                     },
                     error:function (data) {
                        debugger
                     }
                 });



           });




        });
    </script>





@endsection
@section('footer_related')
@endsection

