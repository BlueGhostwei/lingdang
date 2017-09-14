@extends('Admin.layout.main')
@section('title', '优惠券列表')
@section('content')
	<link rel="stylesheet" href="/css/coupon.css" type="text/css">
    <div class="main-container">
        <div class="container-fluid">
            @include('Admin.layout.breadcrumb', [
                'title' =>isset($couponData)?'优惠券编辑': '优惠券添加',
                'breadcrumb' => [
                '商品管理' => '',
                    '优惠券' => ''
                ]
            ])

            <div class="row">
                <div class="box-widget widget-module">
<div class="page">
    <div class="fixed-bar">
        <div class="item-title"><a class="back" href="javascript:history.back();" title="返回列表"><i class="fa fa-arrow-circle-o-left"></i></a>
            <div class="subject">
                <h3>优惠券管理 - @if(isset($couponData))编辑优惠券 @else添加优惠券 @endif</h3>
                <h5>网站系统优惠券管理</h5>
            </div>
        </div>
    </div>
    <form class="form-horizontal" id="handleposition" method="post">
        <input type="hidden" name="id" value=""/>
        <div class="ncap-form-default">
            <dl class="row">
                <dt class="tit">
                    <label><em>*</em>优惠券名称</label>
                </dt>
                <dd class="opt">
                    {{csrf_field()}}
                    <input type="text" id="name" name="name" value="@if(isset($couponData)){{$couponData?$couponData->name:""}}@endif" class="input-txt">
                    <span class="err" id="err_name"></span>
                    <p class="notic">请填写优惠券名称</p>
                </dd>
            </dl>
            <dl class="row">
                <dt class="tit">
                    <label><em>*</em>优惠券面额</label>
                </dt>
                <dd class="opt">
                    <input type="text" id="money" name="money"  onpaste="this.value=this.value.replace(/[^\d.]/g,'')" onkeyup="this.value=this.value.replace(/[^\d.]/g,'')" value="@if(isset($couponData)){{$couponData?$couponData->money:""}}@endif" class="input-txt">
                    <span class="err" id="err_money"></span>
                    <p class="notic">优惠券可抵扣金额</p>
                </dd>
            </dl>
            <dl class="row">
                <dt class="tit">
                    <label><em>*</em>消费金额</label>
                </dt>
                <dd class="opt">
                    <input type="text" id="condition" name="condition"  onpaste="this.value=this.value.replace(/[^\d.]/g,'')" onkeyup="this.value=this.value.replace(/[^\d.]/g,'')" class="input-txt" value="@if(isset($couponData)){{$couponData?$couponData->condition:""}}@endif">
                    <span class="err" id="err_condition"></span>
                    <p class="notic">订单需满足的最低消费金额(必需为整数)才能使用</p>
                </dd>
            </dl>
            <dl class="row">
                <dt class="tit">
                    <label><em>*</em>发放数量</label>
                </dt>
                <dd class="opt">
                    <input type="text" id="createnum" name="createnum" value="@if(isset($couponData)){{$couponData?$couponData->createnum:""}}@endif" onpaste="this.value=this.value.replace(/[^\d]/g,'')" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" class="input-txt">
                    <span class="err" id="err_createnum"></span>
                    <p class="notic">发放数量限制(默认为0则无限制)</p>
                </dd>
            </dl>
            <dl class="row">
                <dt class="tit">
                    <label><em>*</em>发放类型</label>
                </dt>
                <dd class="opt ctype">
                    <input name="type" type="radio" value="0"
                    @if(isset($couponData) && $couponData->type=='0')
                       checked
                    @endif
                    ><label>下单赠送</label>
                    <input name="type" type="radio" value="1"
                           @if(isset($couponData) && $couponData->type=='1')
                           checked
                            @endif
                    ><label>指定发放</label>
                    <input name="type" type="radio" value="2"
                           @if(isset($couponData) && $couponData->type=='2')
                           checked
                            @endif
                    ><label>免费领取</label>
                    <input name="type" type="radio" value="3"
                           @if(isset($couponData) && $couponData->type=='3')
                           checked
                            @endif
                    ><label>线下发放</label>
                </dd>
            </dl>
            <dl class="row timed">
                <dt class="tit">
                    <label><em>*</em>发放起始日期</label>
                </dt>
                <dd class="opt">
                    <input type="text" id="send_start_time" name="send_start_time" value="@if(isset($couponData)){{$couponData?$couponData->send_start_time:""}}@endif"  class="input-txt">
                    <span class="err" id="err_send_start_time"></span>
                    <p class="notic">发放起始日期</p>
                </dd>
            </dl>
            <dl class="row timed">
                <dt class="tit">
                    <label><em>*</em>发放结束日期</label>
                </dt>
                <dd class="opt">
                    <input type="text" id="send_end_time" name="send_end_time" value="@if(isset($couponData)){{$couponData?$couponData->send_end_time:""}}@endif" class="input-txt" >
                    <p class="notic">发放结束日期</p>
                </dd>
            </dl>
            <dl class="row">
                <dt class="tit">
                    <label><em>*</em>使用起始日期</label>
                </dt>
                <dd class="opt">
                    <input type="text" id="use_start_time" name="use_start_time" value="@if(isset($couponData)){{$couponData?$couponData->use_start_time:""}}@endif" class="input-txt">
                    <span class="err" id="err_use_start_time"></span>
                    <p class="notic">使用起始日期</p>
                </dd>
            </dl>
            <dl class="row">
                <dt class="tit">
                    <label><em>*</em>使用结束日期</label>
                </dt>
                <dd class="opt">
                    <input type="text" id="use_end_time" name="use_end_time" value="@if(isset($couponData)){{$couponData?$couponData->use_end_time:""}}@endif" class="input-txt">
                    <p class="notic">使用结束日期</p>
                </dd>
            </dl>
            <dl class="row">
                <dt class="tit">
                    <label>状态</label>
                </dt>
                <dd class="opt">
                    <input name="status" type="radio" value="1" @if(isset($couponData) && $couponData->status=="1")checked @endif  ><label>有效</label>
                    <input name="status" type="radio" value="0"  @if(isset($couponData) && $couponData->status=="0")checked@elseif(!isset($couponData))checked @endif  ><label>无效</label>
                </dd>
            </dl>
            <div class="bot"><a onclick="verifyForm();" class="ncap-btn-big ncap-btn-green">确认提交</a></div>
        </div>
    </form>
</div>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer_related')
    <script src="/js/bootbox.js"></script>
    <script src="/js/sweetalert.js"></script>
	<script src="/js/layer/laydate/laydate.js"></script>
	<script type="text/javascript">
		$('.ctype ').find('input[type="radio"]').click(function(){
			if($(this).val() == 0 || $(this).val() == 4){
				$('.timed').hide();
			}else{
				$('.timed').show();
			}
		})

		$(document).ready(function(){
			$('.ctype ').find('input[type="radio"]:checked').trigger('click');
			//墨绿主题
			laydate.render({
			  elem: '#send_start_time'
			  ,type: 'datetime'
			  ,theme: 'molv'
			});
			laydate.render({
			  elem: '#send_end_time'
			  ,type: 'datetime'
			  ,theme: 'molv'
			});
			laydate.render({
			  elem: '#use_start_time'
			  ,type: 'datetime'
			  ,theme: 'molv'
			});
			laydate.render({
			  elem: '#use_end_time'
			  ,type: 'datetime'
			  ,theme: 'molv'
			});
		})

		function verifyForm(){
			$('span.err').show();
			$.ajax({
				type: "POST",
				url: @if(isset($couponData)) '{{route('goods.GoodsCouponUpdate')}}', @else '{{route('goods.GoodsCouponSave')}}',@endif
				data: $('#handleposition').serialize(),
				dataType: "json",
				error: function () {
					layer.alert("服务器繁忙, 请联系管理员!");
				},
				success: function (data) {
					if (data.sta == 1) {
						layer.msg(data.msg, {icon: 1});
                        location.href = "{{url('goods/GoodsCouponList')}}";
					} else {
						layer.msg(data.msg, {icon: 2});
						$.each(data.result, function (index, item) {
							$('#err_' + index).text(item).show();
						});
					}
				}
			});
		}

	</script>
@endsection
