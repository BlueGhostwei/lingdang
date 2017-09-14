@extends('Admin.layout.main')

@section('title', '订单详情')
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
    <div class="IAhead"><strong style="padding-right: 10px;">订单管理</strong>
		<a href="{{ route('artice.order') }}">订单列表</a>|
		<a href="{{ route('artice.B_dingdan_completelist') }}">已完成</a>|
		<a href="{{ route('artice.B_dingdan_deliverylist') }}">已发货</a>|
		<a href="{{ route('artice.B_dingdan_Nodeliverylist') }}">未发货</a>|
		<a href="{{ route('artice.B_dingdan_backlist') }}">退单</a>|
	</div>
    <div class="IAMAIN" style=" width: 100%; height:auto; margin:0 25px; padding-top:30px;">
            <form method="post" action="">
                <table width="100%" cellspacing="0" cellpadding="0">
                    <tr>
                   	  <td width="29%" valign="top"><div class="dd_read_img"><img src="{{url('../images/touxiang_gg.jpg')}} " ></div></td>
                      <td width="70%">
                        	<div class="dd_read_right">
                            	<div class="read_top">
                                	<table width="100%" cellspacing="0" cellpadding="0">
                                    	<tr>
                                        	<td align="right">商品名称：</td>
                                            <td colspan="3"><input type="text" name="" value="" class="Iar_input"></td>
                                        </tr>
                                        <tr>
                                        	<td align="right">订单号：</td>
                                            <td width="300"><input type="text" name="" value="" class="Iar_list"></td>
                                        	<td align="right">商品价格：</td>
                                            <td><input type="text" name="" value="" class="Iar_list"></td>
                                        </tr>
                                        <tr>
                                        	<td align="right">栏目类型：</td>
                                            <td width="300"><input type="text" name="" value="" class="Iar_list"></td>
                                        	<td align="right">所属栏目：</td>
                                            <td><input type="text" name="" value="" class="Iar_list"></td>
                                        </tr>
                                    </table>
                                <div class="read_top">
                                	<table width="100%" cellspacing="0" cellpadding="0">
                                        <tr>
                                        	<td align="right">购买用户：</td>
                                            <td width="300"><input type="text" name="" value="" class="Iar_list"></td>
                                            <td align="right">当前状态：</td>
                                            <td><input type="text" name="" value="" class="Iar_list"></td>
                                           </tr>
                                        <tr>
                                        	<td align="right">申请日期：</td>
                                            <td><input type="text" name="" value="" class="Iar_list"></td>
                                        	<td align="right">联系方式：</td>
                                            <td><input type="text" name="" value="" class="Iar_list"></td>
                                        </tr>
                                        <tr>
                                        	<td align="right">收货人：</td>
                                            <td width="300"><input type="text" name="" value="" class="Iar_list"></td>
                                        	<td align="right">邮编：</td>
                                            <td><input type="text" name="" value="" class="Iar_list"></td>
                                        </tr>
                                        <tr>
                                        	<td align="right">收货地址：</td>
                                            <td colspan="3"><input type="text" name="" value="" class="Iar_input"></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="read_top">
                                	<table width="100%" cellspacing="0" cellpadding="0">
                                    	<tr>
                                        	<td align="right">退单原因：</td>
                                            <td colspan="3"><input type="text" name="" value="" class="describe"></td>
                                        </tr>
                                        <tr>
                                        	<td align="right">用户上传照片：</td>
                                            <td colspan="3"><a href="{{isset($set_goods)?md52url($set_goods->Thumbnails):url('images/z_add.png')}}" target="_blank" style="width:80px; height:80px; margin:10px; float:left;"><img id="preview" src="{{isset($set_goods)?md52url($set_goods->Thumbnails):url('images/z_add.png')}}" width="80" height="80" style="display: block;" /></a>
                                            </td>
                                        </tr>
                                        <tr>
                                        	<td align="right">服务类型：</td>
                                            <td width="300"><input type="text" name="" value="" class="Iar_list"></td>
                                            <td align="right">审核意见：</td>
                                            <td width="380"><label>
                                              <input type="radio" name="status" value="1">
                                              </label>
                                              审核通过&nbsp;&nbsp;
                                              <label>
                                              <input type="radio" name="status" value="-1">
                                              </label>
                                              待审核&nbsp;&nbsp;
                                              <label>
                                              <input type="radio" name="status" value="-2">
                                              </label>
                                              买家发货
                                              </td>
                                        </tr>
                                        <tr>
                                        	<td align="right">订单状态：</td>
                                            <td>
                                            	<select>
                                            	  <option>已完成</option>
                                            	  <option>已发货</option>
                                            	  <option>未发货</option>
                                           	    </select>
                                            </td>
                                        	<td align="right">处理方式：</td>
                                            <td><input type="submit" name="" class="button" value="退款到用户余额"></td>
                                       	</tr>
                                        <tr style="height:20px;"><td colspan="4"></td></tr>
                                        <tr>
                                            <td align="right">&nbsp;</td>
                                            <td><input type="submit" name="dosubmit" class="button" value="提 交"></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                      </td>
                    </tr>
              </table>
          </form>
        </div>
</div>

@endsection
@section('footer_related')
@endsection
