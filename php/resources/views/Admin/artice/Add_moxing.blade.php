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
          <div class="IAhead"><strong style="padding-right: 10px;">商品属性</strong><a href="{{ route('artice.M_properties') }}">商品属性</a>|<a href="{{ route('artice.Add_properties') }}">添加属性</a>|<a href="{{ route('goods.Add_goods') }}">添加商品</a>|</div>
	 
        <div class="IAMAIN">
            {{--  <form method="post" action="{{route('sort.store')}}">--}}

            <table width="100%" cellspacing="0" cellpadding="0">
                <tr style=" height: auto">
                    <td align="right" valign="top"><font color="red">*</font>所属分类：</td>
                    <td>
                        <select name="cateid" id="select_id_1" class="asnt">
                            <option value="0">请选择分类</option>
                            <option value="1">裙子</option>
                            <option value="2">裤子</option>
                            <option value="3">上衣</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td align="right"><font color="red">*</font>属性名称：</td>
                    <td><input type="text" name="goods_title" value="" class="Iar_input"></td>
                </tr>
				<tr>
                    <td align="right"><font color="red">*</font>规格项：</td>
                    <td><textarea name="" value="" class="specifications"></textarea></td>
                </tr>
                <tr>
                    <td align="right">排列顺序：</td>
                    <td><input type="text" name="store_num" value="{{isset($Get_Brand)?$Get_Brand[0]['brand_num']:""}}"  class="Iar_inpun"/></td>
                </tr>

                <tr height="60px">
                    <td align="right"></td>
                    <td><input type="button" name="dosubmit" class="sumbutton" value="提 交"></td>
                </tr>
            </table>
            {{-- </form>--}}
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
        });
    </script>

@endsection
@section('footer_related')
@endsection

