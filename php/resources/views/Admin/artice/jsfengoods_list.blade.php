@extends('Admin.layout.main')

@section('title', '优惠券')
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
        <div class="IAhead"><strong style="padding-right: 10px;">优惠券</strong><a href="{{ route('goods.jsfengoods_list') }}">优惠券列表</a>|<a href="{{ route('goods.youhuijuan') }}">添加优惠券</a>|</div>
        <div class="IAMAIN_list">
			<div class="Alist">
				<form method="post" action="">
				<table width="100%"  cellspacing="0" cellpadding="0" >
					<tr class="Alist_head">
						<th style="width: 80px;">ID</th>
						<th>优惠金额</th>
						<th>消费总额</th>
						<th>有效期</th>
						<th>生成时间</th>
						<th>操作</th>
					</tr>
					<tr class="Alist_main">
						<td class="IMar_list" />1</td>
						<td>￥10.00元</td>
						<td >￥100元</td>
						<td >2017-8-30</td>
						<td >2017-8-7 15:00</td>
					   <td><a href="{{ route('goods.youhuijuan') }}">修改 </a>|<span data_id=""> 删除</span></td>
					</tr>
				</table>
				</form>			   
			</div>
		</div>
    </div>
<script type="text/javascript">
    $(function () {
       $('.delete_goods').click(function () {
           var id =$(this).attr('data_id');
           debugger
       }); 
    });
</script>
@endsection
@section('footer_related')
@endsection
