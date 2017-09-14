@extends('Admin.layout.main')

@section('title', '优惠券')
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
        <div class="IAhead"><strong style="padding-right: 10px;">优惠券</strong></div>
        <div class="IAMAIN">
            <form method="post" action="{{route('sort.store')}}">
			<table width="100%" cellspacing="0" cellpadding="0">
                 <tr>
                    <td align="right"><font color="red">*</font>优惠金额：</td>
                    <td><input type="text" name="" value="" class="Iar_input"></td>
                </tr>
				<tr>
                    <td align="right"><font color="red">*</font>消费总额：</td>
                    <td><input type="text" name="" value="" class="Iar_inpun"/> 元</td>
                </tr>
				<tr>
                    <td align="right"><font color="red">*</font>有效期：</td>
                    <td><input type="text" name="" value="" class="Iar_input"></td>
                </tr>
                <tr height="60px">
                    <td align="right"></td>
                    <td><input type="button" name="dosubmit" class="sumbutton" value="提 交"></td>
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

