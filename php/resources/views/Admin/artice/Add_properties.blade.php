@extends('Admin.layout.main')

@section('title', '添加规格')
@section('header_related')
    <link rel="stylesheet" href="{{ url('/css/style.css') }}" type="text/css">
    <script type="text/javascript" src="{{ url('/js/jquery.1.4.2-min.js') }}"></script>
    @endsection
    @section('content')


    <div class="Iartice">
          <div class="IAhead"><strong style="padding-right: 10px;">商品属性</strong><a href="{{ route('artice.M_properties') }}">商品属性</a>|<a href="{{ route('artice.Add_properties') }}">添加属性</a>|<a href="{{ route('goods.Add_goods') }}">添加商品</a>|</div>
	 
        <div class="IAMAIN">
              <form method="post" action="{{route('artice.SaveAttributes')}}">
                  {{csrf_field()}}
            <table width="100%" cellspacing="0" cellpadding="0">
                <tr style=" height: auto">
                    <td align="right" valign="top"><font color="red">*</font>所属分类：</td>
                    <td>
                        <select name="sort_id" id="select_id_1" class="asnt">
                            <option value="0">请选择分类</option>
                            @if(isset($sort))
                                @foreach($sort as $key =>$vel)
                                    <option
                                            @if(isset($set_goods) && $set_goods->sort_id == $vel['id'])
                                            selected
                                            @endif
                                            value="{{$vel['id']}}"
                                    >
                                        {{$vel['name']}}

                                    </option>
                                    {{--渲染二级分类--}}
                                    @if(isset($vel['child']) && !empty($vel['child']))
                                        @foreach($vel['child'] as $rst=>$rvb)
                                            <option
                                                    @if(isset($set_goods) && $set_goods->sort_id == $rvb['id'])
                                                    selected
                                                    @endif
                                                    value="{{$rvb['id']}}"
                                            >
                                                {{"|--".$rvb['name']}}

                                            </option>
                                        @endforeach
                                    @endif
                                @endforeach
                            @endif
                            {{--<option value="1">裙子</option>
                            <option value="2">裤子</option>
                            <option value="3">上衣</option>--}}
                        </select>
                    </td>
                </tr>
				<tr>
                    <td align="right"><font color="red">*</font>属性名称：</td>
                    <td><input type="text" name="arr_name" value="" class="Iar_input"></td>
                </tr>
                <tr>
                    <td align="right">排列顺序：</td>
                    <td>
                        <input type="hidden" name="pid" value="0" >
                        <input type="text" name="store_num" value="{{isset($Get_Brand)?$Get_Brand[0]['brand_num']:""}}"  class="Iar_inpun"/>
                    </td>
                </tr>

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
        });
    </script>

@endsection
@section('footer_related')
@endsection

