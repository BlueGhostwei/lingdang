@extends('Admin.layout.main')

@section('title', '添加商品分类')
@section('header_related')
    <link rel="stylesheet" href="{{ url('/css/style.css') }}" type="text/css">

    @endsection
    @section('content')
            <!--<div class="main-container">
        <div class="container-fluid">
            @include('Admin.layout.breadcrumb', [
                'title' => '添加商品分类',
                '' => [
                    '' => '',
                ]
            ])
            </div>
         </div>-->

    <div class="Iartice">
        <div class="IAhead"><strong style="padding-right: 10px;">添加商品分类</strong></div>
        <div class="IAMAIN">
            <form method="post"
                  @if(isset($edit_sort))
                  action="{{route('sort.update',$edit_sort->id)}}"
                    @else
                  action="{{route('sort.store')}}"
                    @endif
            >
                {{csrf_field()}}
                <table width="100%" cellspacing="0" cellpadding="0">
                    <tr style=" height: auto">
                        <td align="right" valign="top"><font color="red">*</font>上级栏目：</td>
                        <td>
                            <select name="cateid" id="good_sort" onchange="gradeChange()">
                                <option data_id="0">作为一级分类</option>
                                @if(isset($sort))
                                    @foreach($sort as $key =>$vel)
                                        <option
                                                @if(isset($id) && $id == $vel['id'])
                                                        selected
                                                        @endif
                                                data_id="{{$vel['id']}}"

                                        >{{$vel['name']}}</option>
                                    @endforeach
                                @endif

                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td align="right"><font color="red">*</font>分类名称：</td>
                        <td>
                            <input type="hidden" name="sort_id" value="">
                            <input type="hidden" name="edit_id" value="{{isset($edit_sort) ? $edit_sort->id : ""}}">
                            <input type="text" name="name" value="{{isset($edit_sort) ? $edit_sort->name :old('name')}}" {{--class="Iar_input"--}}>
                            @if ($errors->has('name'))
                                <label class="error">
                                    <span class="error">{{ $errors->first('name') }}</span>
                                </label>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td align="right">排列顺序：</td>
                        <td><input type="text" name="num" value="{{ isset($edit_sort)? $edit_sort->num :old('num')}}" class="Iar_inpun"/></td>
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
    <script type="text/javascript">
        $(document).ready(function () {
            var sort = $('#good_sort option:selected').attr('data_id');
            $("input[name='sort_id']").val(sort);
        });
        function gradeChange() {
            var sort = $('#good_sort option:selected').attr('data_id');
            $("input[name='sort_id']").val(sort);
        }
    </script>
@endsection
