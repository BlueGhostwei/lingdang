@extends('Admin.layout.main')

@section('title', '添加文章分类')
@section('header_related')
    <link rel="stylesheet" href="{{ url('/css/style.css') }}" type="text/css">

    @endsection
    @section('content')
            <!--<div class="main-container">
        <div class="container-fluid">
            @include('Admin.layout.breadcrumb', [
                'title' => '添加文章分类',
                '' => [
                    '' => '',
                ]
            ])
            </div>
         </div>-->

    <div class="Iartice">
        <div class="IAhead"><strong style="padding-right: 10px;">添加分类</strong></div>
        <div class="IAMAIN">
            <form method="post"
                  action="@if(isset($Rst_Data)){{route('support.update')}}@else{{route('artice.save_fenlei')}}@endif">
                {{csrf_field()}}
                <table width="100%" cellspacing="0" cellpadding="0">
                    <tr>
                        <td align="right"><font color="red">*</font>栏目类型：</td>
                        <td>内容管理</td>
                    </tr>
                    <tr>
                        <td align="right"><font color="red">*</font>栏目名称：</td>
                        <td>
                            @if(isset($Rst_Data))
                                <input type="hidden" name="id" value="{{$Rst_Data->id}}">
                            @endif
                            <input type="text" name="sort_name"
                                   value="{{isset($Rst_Data)?$Rst_Data->name:old('sort_name')}}" class="Iar_input">
                            @if ($errors->has('sort_name'))
                                <label class="error">
                                    <span class="error">{{ $errors->first('sort_name') }}</span>
                                </label>
                            @endif</td>


                    </tr>
                    <tr>
                        <td align="right">排列顺序：</td>
                        <td><input type="text" name="sort_num"
                                   value="{{ isset($Rst_Data)? $Rst_Data->num:old('sort_num')}}" class="Iar_inpun"/>
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
