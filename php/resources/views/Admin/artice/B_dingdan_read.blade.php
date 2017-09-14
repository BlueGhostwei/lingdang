@extends('Admin.layout.main')

@section('title', '订单详情')
@section('header_related')
   <link rel="stylesheet" href="{{ url('/css/style.css') }}" type="text/css">

@endsection
@section('content')
    <!--<div class="main-container">
        <div class="container-fluid">
            @include('Admin.layout.breadcrumb', [
                'title' => '查看订单',
                '' => [
                    '' => '',
                ]
            ])
        </div>
     </div>-->

<div class="Iartice">
    <div class="IAhead"><strong style="padding-right: 10px;">订单管理</strong>
		<a href="{{ route('artice.order') }}">订单列表</a>|
		<a href="{{ route('artice.B_dingdan_completelist') }}">已完成</a>|
		<a href="{{ route('artice.B_dingdan_deliverylist') }}">已发货</a>|
		<a href="{{ route('artice.B_dingdan_Nodeliverylist') }}">未发货</a>|
		<a href="{{ route('artice.B_dingdan_backlist') }}">退单</a>|
	</div>
    <div class="IAMAIN" style=" width: 100%; height:auto; margin:0 25px;padding-top:30px; ">
            <form method="post" action="">
                <table width="100%" cellspacing="0" cellpadding="0">
                    <tr>
                   	  <td width="29%" valign="top"><div class="dd_read_img"><img src="{{url('../images/touxiang_gg.jpg')}} " ></div></td>
                      <td width="70%">
                        	<div class="dd_read_right">
                                @if($orderInfo && !empty($orderInfo))
                            	<div class="read_top">
                                             @foreach($orderInfo[0]['goods'] as $key =>$vel)
                                            <table width="100%" cellspacing="0" cellpadding="0">
                                                <tr>
                                                    <td align="right">商品名称：</td>
                                                    <td colspan="3"><input type="text" name="" value="{{GetGoodsName($vel['goods_id'])}}" class="Iar_input"></td>
                                                </tr>
                                                <tr>
                                                    <td align="right">订单号：</td>
                                                    <td width="300"><input type="text" name="order_id" value="{{$orderInfo[0]['order_id']}}" class="Iar_list"></td>
                                                    <td align="right">商品价格：</td>
                                                    <td><input type="text" name="" value="{{$vel['price']}}" class="Iar_list"></td>
                                                </tr>
                                                @if($goodsInfo=array_get($vel,'goods_info'))
                                                    <tr>
                                                        <td align="right">商品分类：</td>
                                                        <td width="300"><input type="text" name="" value="{{SortName($goodsInfo['sort_id'])}}" class="Iar_list"></td>
                                                        <td align="right">所属品牌：</td>
                                                        <td><input type="text" name="" value="{{BrandName($goodsInfo['brand_id'])}}" class="Iar_list"></td>
                                                    </tr>
                                                @endif
                                              </table>
                                                 @endforeach

                                </div>
                                <div class="read_top">
                                    @if( $payuser=array_get($orderInfo[0],'payUser') )
                                	<table width="100%" cellspacing="0" cellpadding="0">
                                        <tr>
                                        	<td align="right">购买用户：</td>
                                            <td width="300"><input type="text" name="" value="{{$payuser['nickname']}}" class="Iar_list"></td>
                                        	<td align="right">用户手机：</td>
                                            <td><input type="text" name="" value="{{$payuser['name']}}" class="Iar_list"></td>
                                        </tr>
                                        <tr>
                                        	<td align="right">购买时间：</td>
                                            <td><input type="text" name="" value="{{$orderInfo[0]['created_at']}}" class="Iar_list"></td>
                                            <td align="right">购买方式：</td>
                                            <td width=""><input type="text" name="" value="@if($orderInfo[0]['status']=='0')未付款@endif" class="Iar_list"></td>

                                        </tr>
                                        <tr>
                                            <td align="right">订单金额：</td>
                                            <td><input type="text" name="" value="{{$orderInfo[0]['order_price']}}" class="Iar_list"></td>
                                        	<td align="right">当前状态：</td>
                                            <td><input type="text" name="" value="@if($orderInfo[0]['status']=='0')待支付@endif" class="Iar_list"></td>
                                        </tr>
                                        <tr>
                                        	<td align="right">订单备注：</td>
                                            <td colspan="3"><input type="text" name="" value="{{$orderInfo[0]['remark']?:'无'}}" class="describe"></td>
                                        </tr>
                                    </table>
                                        @endif
                                </div>
                                <div class="read_top">
                                    @if($site=array_get($orderInfo[0],'site'))
                                	<table width="100%" cellspacing="0" cellpadding="0">
                                    	<tr>
                                        	<td align="right">收货人：</td>
                                            <td width="300"><input type="text" name="" value="{{$site['consignee']}}" class="Iar_list"></td>
                                        	<td align="right">联系方式：</td>
                                            <td><input type="text" name="" value="{{$site['phone']}}" class="Iar_list"></td>
                                        </tr>
                                        <tr>
                                        	<td align="right">收货地址：</td>
                                            <td colspan="3"><input type="text" name="" value="{{$site['user_address']}}" class="Iar_input"></td>
                                        </tr>
                                        {{--<tr>
                                        	<td align="right">邮编：</td>
                                            <td colspan="3"><input type="text" name="" value="" class="Iar_list"></td>
                                        	
                                        </tr>--}}
                                        <tr>
                                        	<td align="right">订单状态：</td>
                                            <td colspan="3">
                                            	<select id="select_order_type">
                                                  <option value="0"  @if($orderInfo[0]['status']=='0')selected @endif>未发货</option>
                                            	  <option value="1">已完成</option>
                                            	  <option value="2">已发货</option>
                                           	    </select>
                                            </td>
                                       	</tr>
                                        <tr style="height:20px;"><td colspan="4"></td></tr>
                                        <tr>
                                            <td align="right">&nbsp;</td>
                                            <td><input type="button" name="dosubmit" class="sub-button" value="确 认"></td>
                                        </tr>
                                    </table>
                                      @endif
                                </div>
                                @endif
                            </div>
                      </td>
                    </tr>
              </table>
          </form>
        </div>
</div>

@endsection
@section('footer_related')
    <script type="text/javascript">
        $(function () {
         $(".sub-button").click(function () {
            var order_id= $("input[name='order_id']").val();
            var order_type= $('#select_order_type option:selected') .val();
            var Url="{{route('order.UpdateOrderType')}}";
             $.ajax({
                 type: 'GET',
                 data:{
                     order_id:order_id,
                     order_type:order_type
                 },
                 dataType: 'json',
                 url: Url,
                 success: function(data) {
                 if(data.sta==1){
                     layer.msg(data.msg);
                    //页面跳转
                     window.location.href = "{{url('artice/order')}}";

                 }else{
                     layer.msg(data.msg);
                     window.location.href = "{{url('artice/order')}}";
                 }
                 },
                 error: function(e) {

                 }
             });

         })
        });
    </script>
@endsection
