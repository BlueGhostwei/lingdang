@extends('Admin.layout.main')

@section('title', '优惠券列表')

@section('content')

    <link rel="stylesheet" href="/css/coupon.css" type="text/css">
    <div class="main-container">
        <div class="container-fluid">
            @include('Admin.layout.breadcrumb', [
                'title' => '优惠券列表',
                'breadcrumb' => [
                '商品管理' => '',
                    '优惠券列表' => ''
                ]
            ])

            <div class="row">
                <div class="box-widget widget-module">
                    <div class="flexigrid">
                        <div class="mDiv">
                            <div class="ftitle">
                                <h3>优惠券列表</h3>
                                <h5>(共@if(isset($count_num)){{$count_num}}@endif条记录)</h5>
                            </div>
                            <div title="刷新数据" class="pReload"><i class="fa fa-refresh"></i></div>
                        </div>
                        <div class="hDiv">
                            <div class="hDivBox">
                                <table cellspacing="0" cellpadding="0">
                                    <thead>
                                    <tr>
                                        <th class="sign" axis="col0">
                                            <div style="width: 24px;"><i class="ico-check"></i></div>
                                        </th>
                                        <th align="left" abbr="article_title" axis="col3" class="">
                                            <div style="text-align: left; width: 240px;" class="">优惠券名称</div>
                                        </th>
                                        <th align="left" abbr="ac_id" axis="col4" class="">
                                            <div style="text-align: center; width: 60px;" class="">优惠券类型</div>
                                        </th>
                                        <th align="center" abbr="article_show" axis="col5" class="">
                                            <div style="text-align: center; width: 50px;" class="">面额</div>
                                        </th>
                                        <th align="center" abbr="article_time" axis="col6" class="">
                                            <div style="text-align: center; width: 80px;" class="">使用需满金额</div>
                                        </th>
                                        <th align="center" abbr="article_time" axis="col6" class="">
                                            <div style="text-align: center; width: 50px;" class="">发放总量</div>
                                        </th>
                                        <th align="center" abbr="article_time" axis="col6" class="">
                                            <div style="text-align: center; width: 50px;" class="">已发放数</div>
                                        </th>
                                        <th align="center" abbr="article_time" axis="col6" class="">
                                            <div style="text-align: center; width: 50px;" class="">已使用</div>
                                        </th>
                                        <th align="center" abbr="article_time" axis="col6" class="">
                                            <div style="text-align: center; width: 120px;" class="">使用截止日期</div>
                                        </th>
                                        <th align="left" axis="col1" class="handle">
                                            <div style="text-align: center; width: 170px;">操作</div>
                                        </th>
                                        <th style="width:100%" axis="col7">
                                            <div></div>
                                        </th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                        <div class="tDiv">
                            <div class="tDiv2">
                                <a href="{{route('goods.GoodsCoupon')}}">
                                    <div class="fbutton">
                                        <div title="添加优惠券" class="add">
                                            <span><i class="fa fa-plus"></i>添加优惠券</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div style="clear:both"></div>
                        </div>
                        <div class="bDiv" style="height: auto;">
                            <div id="flexigrid" cellpadding="0" cellspacing="0" border="0">
                                <table>
                                    <tbody>
                                    @if(isset($coupon))
                                        @foreach($coupon as $Ky =>$ve)
                                        <tr class="">
                                            <td class="sign">
                                                <div style="width: 24px;"><i class="ico-check"></i></div>
                                            </td>
                                            <td align="left" class="">
                                                <div style="text-align: left; width: 240px;">{{$ve['name']}}</div>
                                            </td>
                                            <td align="left" class="">
                                                <div style="text-align: center; width: 60px;">
                                                    @if($ve['type'] && $ve['type']=='0')
                                                        下单赠送
                                                        @elseif($ve['type'] && $ve['type']=='1')
                                                        指定发放
                                                    @elseif($ve['type'] && $ve['type']=='2')
                                                        免费领取
                                                    @elseif($ve['type'] && $ve['type']=='3')
                                                        线下发放
                                                    @endif
                                                </div>
                                            </td>
                                            <td align="left" class="">
                                                <div style="text-align: center; width: 50px;">{{$ve['money']}}</div>
                                            </td>
                                            <td align="left" class="">
                                                <div style="text-align: center; width: 80px;">{{$ve['condition']}}</div>
                                            </td>
                                            <td align="left" class="">
                                                <div style="text-align: center; width: 50px;">{{$ve['createnum']}}</div>
                                            </td>
                                            <td align="left" class="">
                                                <div style="text-align: center; width: 50px;">0</div>
                                            </td>
                                            <td align="left" class="">
                                                <div style="text-align: center; width: 50px;">0</div>
                                            </td>
                                            <td align="left" class="">
                                                <div style="text-align: center; width: 120px;">{{$ve['use_end_time']}}</div>
                                            </td>
                                            <td align="left" class="handle">
                                                <div style="text-align: left; width: 170px; max-width:170px;">
                                                    <a class="btn blue" href="{{route('goods.coupon_show').'?coupon_id='.$ve['id']}}"><i
                                                                class="fa fa-pencil-square-o"></i>编辑</a>
                                                    <a class="btn red" href="javascript:void(0)"
                                                       data-url="{{route('goods.coupon_dele').'?coupon_id='.$ve['id']}}"
                                                       onclick="delfun(this)"><i class="fa fa-trash-o"></i>删除</a>
                                                </div>
                                            </td>
                                            <td align="" class="" style="width: 100%;">
                                                <div>&nbsp;</div>
                                            </td>
                                        </tr>
                                        @endforeach
                                        @endif

                                   {{-- <tr>
                                        <td class="sign">
                                            <div style="width: 24px;"><i class="ico-check"></i></div>
                                        </td>
                                        <td align="left" class="">
                                            <div style="text-align: left; width: 240px;">指定发放要过期</div>
                                        </td>
                                        <td align="left" class="">
                                            <div style="text-align: center; width: 60px;">指定发放</div>
                                        </td>
                                        <td align="left" class="">
                                            <div style="text-align: center; width: 50px;">10.00</div>
                                        </td>
                                        <td align="left" class="">
                                            <div style="text-align: center; width: 60px;">20020.00</div>
                                        </td>
                                        <td align="left" class="">
                                            <div style="text-align: center; width: 50px;">20</div>
                                        </td>
                                        <td align="left" class="">
                                            <div style="text-align: center; width: 50px;">2</div>
                                        </td>
                                        <td align="left" class="">
                                            <div style="text-align: center; width: 50px;">0</div>
                                        </td>
                                        <td align="left" class="">
                                            <div style="text-align: center; width: 120px;">2017-09-19</div>
                                        </td>
                                        <td align="left" class="handle">
                                            <div style="text-align: left; width: 170px; max-width:170px;">
                                                <a class="btn"
                                                   style="background-color: #999;border-color: #999;color: #fff;box-shadow:none"><i
                                                            class="fa fa-send-o"></i>发放</a>
                                                <a class="btn blue" href="/index.php/Admin/Coupon/coupon_list/id/18"><i
                                                            class="fa fa-search"></i>查看</a>
                                                <a class="btn blue" href="/index.php/Admin/Coupon/coupon_info/id/18"><i
                                                            class="fa fa-pencil-square-o"></i>编辑</a>
                                                <a class="btn red" href="javascript:void(0)"
                                                   data-url="/index.php/Admin/Coupon/del_coupon/id/18"
                                                   onclick="delfun(this)"><i class="fa fa-trash-o"></i>删除</a>
                                            </div>
                                        </td>
                                        <td align="" class="" style="width: 100%;">
                                            <div>&nbsp;</div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="sign">
                                            <div style="width: 24px;"><i class="ico-check"></i></div>
                                        </td>
                                        <td align="left" class="">
                                            <div style="text-align: left; width: 240px;">TPshop代金券10元</div>
                                        </td>
                                        <td align="left" class="">
                                            <div style="text-align: center; width: 60px;">指定发放</div>
                                        </td>
                                        <td align="left" class="">
                                            <div style="text-align: center; width: 50px;">10.00</div>
                                        </td>
                                        <td align="left" class="">
                                            <div style="text-align: center; width: 60px;">100.00</div>
                                        </td>
                                        <td align="left" class="">
                                            <div style="text-align: center; width: 50px;">10</div>
                                        </td>
                                        <td align="left" class="">
                                            <div style="text-align: center; width: 50px;">5</div>
                                        </td>
                                        <td align="left" class="">
                                            <div style="text-align: center; width: 50px;">0</div>
                                        </td>
                                        <td align="left" class="">
                                            <div style="text-align: center; width: 120px;">2028-11-13</div>
                                        </td>
                                        <td align="left" class="handle">
                                            <div style="text-align: left; width: 170px; max-width:170px;">
                                                <a class="btn"
                                                   style="background-color: #999;border-color: #999;color: #fff;box-shadow:none"><i
                                                            class="fa fa-send-o"></i>发放</a>
                                                <a class="btn blue" href="/index.php/Admin/Coupon/coupon_list/id/15"><i
                                                            class="fa fa-search"></i>查看</a>
                                                <a class="btn blue" href="/index.php/Admin/Coupon/coupon_info/id/15"><i
                                                            class="fa fa-pencil-square-o"></i>编辑</a>
                                                <a class="btn red" href="javascript:void(0)"
                                                   data-url="/index.php/Admin/Coupon/del_coupon/id/15"
                                                   onclick="delfun(this)"><i class="fa fa-trash-o"></i>删除</a>
                                            </div>
                                        </td>
                                        <td align="" class="" style="width: 100%;">
                                            <div>&nbsp;</div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="sign">
                                            <div style="width: 24px;"><i class="ico-check"></i></div>
                                        </td>
                                        <td align="left" class="">
                                            <div style="text-align: left; width: 240px;">TPshop代金券10元</div>
                                        </td>
                                        <td align="left" class="">
                                            <div style="text-align: center; width: 60px;">指定发放</div>
                                        </td>
                                        <td align="left" class="">
                                            <div style="text-align: center; width: 50px;">10.00</div>
                                        </td>
                                        <td align="left" class="">
                                            <div style="text-align: center; width: 60px;">100.00</div>
                                        </td>
                                        <td align="left" class="">
                                            <div style="text-align: center; width: 50px;">10</div>
                                        </td>
                                        <td align="left" class="">
                                            <div style="text-align: center; width: 50px;">2</div>
                                        </td>
                                        <td align="left" class="">
                                            <div style="text-align: center; width: 50px;">1</div>
                                        </td>
                                        <td align="left" class="">
                                            <div style="text-align: center; width: 120px;">2028-11-13</div>
                                        </td>
                                        <td align="left" class="handle">
                                            <div style="text-align: left; width: 170px; max-width:170px;">
                                                <a class="btn"
                                                   style="background-color: #999;border-color: #999;color: #fff;box-shadow:none"><i
                                                            class="fa fa-send-o"></i>发放</a>
                                                <a class="btn blue" href="/index.php/Admin/Coupon/coupon_list/id/14"><i
                                                            class="fa fa-search"></i>查看</a>
                                                <a class="btn blue" href="/index.php/Admin/Coupon/coupon_info/id/14"><i
                                                            class="fa fa-pencil-square-o"></i>编辑</a>
                                                <a class="btn red" href="javascript:void(0)"
                                                   data-url="/index.php/Admin/Coupon/del_coupon/id/14"
                                                   onclick="delfun(this)"><i class="fa fa-trash-o"></i>删除</a>
                                            </div>
                                        </td>
                                        <td align="" class="" style="width: 100%;">
                                            <div>&nbsp;</div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="sign">
                                            <div style="width: 24px;"><i class="ico-check"></i></div>
                                        </td>
                                        <td align="left" class="">
                                            <div style="text-align: left; width: 240px;">50元代金券</div>
                                        </td>
                                        <td align="left" class="">
                                            <div style="text-align: center; width: 60px;"></div>
                                        </td>
                                        <td align="left" class="">
                                            <div style="text-align: center; width: 50px;">50.00</div>
                                        </td>
                                        <td align="left" class="">
                                            <div style="text-align: center; width: 60px;">150.00</div>
                                        </td>
                                        <td align="left" class="">
                                            <div style="text-align: center; width: 50px;">100</div>
                                        </td>
                                        <td align="left" class="">
                                            <div style="text-align: center; width: 50px;">11</div>
                                        </td>
                                        <td align="left" class="">
                                            <div style="text-align: center; width: 50px;">0</div>
                                        </td>
                                        <td align="left" class="">
                                            <div style="text-align: center; width: 120px;">2016-09-01</div>
                                        </td>
                                        <td align="left" class="handle">
                                            <div style="text-align: left; width: 170px; max-width:170px;">
                                                <a class="btn"
                                                   style="background-color: #999;border-color: #999;color: #fff;box-shadow:none"><i
                                                            class="fa fa-send-o"></i>发放</a>
                                                <a class="btn blue" href="/index.php/Admin/Coupon/coupon_list/id/13"><i
                                                            class="fa fa-search"></i>查看</a>
                                                <a class="btn blue" href="/index.php/Admin/Coupon/coupon_info/id/13"><i
                                                            class="fa fa-pencil-square-o"></i>编辑</a>
                                                <a class="btn red" href="javascript:void(0)"
                                                   data-url="/index.php/Admin/Coupon/del_coupon/id/13"
                                                   onclick="delfun(this)"><i class="fa fa-trash-o"></i>删除</a>
                                            </div>
                                        </td>
                                        <td align="" class="" style="width: 100%;">
                                            <div>&nbsp;</div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="sign">
                                            <div style="width: 24px;"><i class="ico-check"></i></div>
                                        </td>
                                        <td align="left" class="">
                                            <div style="text-align: left; width: 240px;">5元线下券</div>
                                        </td>
                                        <td align="left" class="">
                                            <div style="text-align: center; width: 60px;"></div>
                                        </td>
                                        <td align="left" class="">
                                            <div style="text-align: center; width: 50px;">7.00</div>
                                        </td>
                                        <td align="left" class="">
                                            <div style="text-align: center; width: 60px;">50.00</div>
                                        </td>
                                        <td align="left" class="">
                                            <div style="text-align: center; width: 50px;">100</div>
                                        </td>
                                        <td align="left" class="">
                                            <div style="text-align: center; width: 50px;">57</div>
                                        </td>
                                        <td align="left" class="">
                                            <div style="text-align: center; width: 50px;">0</div>
                                        </td>
                                        <td align="left" class="">
                                            <div style="text-align: center; width: 120px;">2016-07-21</div>
                                        </td>
                                        <td align="left" class="handle">
                                            <div style="text-align: left; width: 170px; max-width:170px;">
                                                <a class="btn"
                                                   style="background-color: #999;border-color: #999;color: #fff;box-shadow:none"><i
                                                            class="fa fa-send-o"></i>发放</a>
                                                <a class="btn blue" href="/index.php/Admin/Coupon/coupon_list/id/12"><i
                                                            class="fa fa-search"></i>查看</a>
                                                <a class="btn blue" href="/index.php/Admin/Coupon/coupon_info/id/12"><i
                                                            class="fa fa-pencil-square-o"></i>编辑</a>
                                                <a class="btn red" href="javascript:void(0)"
                                                   data-url="/index.php/Admin/Coupon/del_coupon/id/12"
                                                   onclick="delfun(this)"><i class="fa fa-trash-o"></i>删除</a>
                                            </div>
                                        </td>
                                        <td align="" class="" style="width: 100%;">
                                            <div>&nbsp;</div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="sign">
                                            <div style="width: 24px;"><i class="ico-check"></i></div>
                                        </td>
                                        <td align="left" class="">
                                            <div style="text-align: left; width: 240px;">代金券10块</div>
                                        </td>
                                        <td align="left" class="">
                                            <div style="text-align: center; width: 60px;">下单赠送</div>
                                        </td>
                                        <td align="left" class="">
                                            <div style="text-align: center; width: 50px;">10.00</div>
                                        </td>
                                        <td align="left" class="">
                                            <div style="text-align: center; width: 60px;">100.00</div>
                                        </td>
                                        <td align="left" class="">
                                            <div style="text-align: center; width: 50px;">100</div>
                                        </td>
                                        <td align="left" class="">
                                            <div style="text-align: center; width: 50px;">0</div>
                                        </td>
                                        <td align="left" class="">
                                            <div style="text-align: center; width: 50px;">0</div>
                                        </td>
                                        <td align="left" class="">
                                            <div style="text-align: center; width: 120px;">2016-07-31</div>
                                        </td>
                                        <td align="left" class="handle">
                                            <div style="text-align: left; width: 170px; max-width:170px;">
                                                <a class="btn"
                                                   style="background-color: #999;border-color: #999;color: #fff;box-shadow:none"><i
                                                            class="fa fa-send-o"></i>发放</a>
                                                <a class="btn blue" href="/index.php/Admin/Coupon/coupon_list/id/11"><i
                                                            class="fa fa-search"></i>查看</a>
                                                <a class="btn blue" href="/index.php/Admin/Coupon/coupon_info/id/11"><i
                                                            class="fa fa-pencil-square-o"></i>编辑</a>
                                                <a class="btn red" href="javascript:void(0)"
                                                   data-url="/index.php/Admin/Coupon/del_coupon/id/11"
                                                   onclick="delfun(this)"><i class="fa fa-trash-o"></i>删除</a>
                                            </div>
                                        </td>
                                        <td align="" class="" style="width: 100%;">
                                            <div>&nbsp;</div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="sign">
                                            <div style="width: 24px;"><i class="ico-check"></i></div>
                                        </td>
                                        <td align="left" class="">
                                            <div style="text-align: left; width: 240px;">按用户发放优惠券</div>
                                        </td>
                                        <td align="left" class="">
                                            <div style="text-align: center; width: 60px;"></div>
                                        </td>
                                        <td align="left" class="">
                                            <div style="text-align: center; width: 50px;">10.00</div>
                                        </td>
                                        <td align="left" class="">
                                            <div style="text-align: center; width: 60px;">100.00</div>
                                        </td>
                                        <td align="left" class="">
                                            <div style="text-align: center; width: 50px;">0</div>
                                        </td>
                                        <td align="left" class="">
                                            <div style="text-align: center; width: 50px;">0</div>
                                        </td>
                                        <td align="left" class="">
                                            <div style="text-align: center; width: 50px;">0</div>
                                        </td>
                                        <td align="left" class="">
                                            <div style="text-align: center; width: 120px;">2016-07-02</div>
                                        </td>
                                        <td align="left" class="handle">
                                            <div style="text-align: left; width: 170px; max-width:170px;">
                                                <a class="btn"
                                                   style="background-color: #999;border-color: #999;color: #fff;box-shadow:none"><i
                                                            class="fa fa-send-o"></i>发放</a>
                                                <a class="btn blue" href="/index.php/Admin/Coupon/coupon_list/id/10"><i
                                                            class="fa fa-search"></i>查看</a>
                                                <a class="btn blue" href="/index.php/Admin/Coupon/coupon_info/id/10"><i
                                                            class="fa fa-pencil-square-o"></i>编辑</a>
                                                <a class="btn red" href="javascript:void(0)"
                                                   data-url="/index.php/Admin/Coupon/del_coupon/id/10"
                                                   onclick="delfun(this)"><i class="fa fa-trash-o"></i>删除</a>
                                            </div>
                                        </td>
                                        <td align="" class="" style="width: 100%;">
                                            <div>&nbsp;</div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="sign">
                                            <div style="width: 24px;"><i class="ico-check"></i></div>
                                        </td>
                                        <td align="left" class="">
                                            <div style="text-align: left; width: 240px;">订单满100送10元代金券</div>
                                        </td>
                                        <td align="left" class="">
                                            <div style="text-align: center; width: 60px;">指定发放</div>
                                        </td>
                                        <td align="left" class="">
                                            <div style="text-align: center; width: 50px;">10.00</div>
                                        </td>
                                        <td align="left" class="">
                                            <div style="text-align: center; width: 60px;">100.00</div>
                                        </td>
                                        <td align="left" class="">
                                            <div style="text-align: center; width: 50px;">100</div>
                                        </td>
                                        <td align="left" class="">
                                            <div style="text-align: center; width: 50px;">23</div>
                                        </td>
                                        <td align="left" class="">
                                            <div style="text-align: center; width: 50px;">0</div>
                                        </td>
                                        <td align="left" class="">
                                            <div style="text-align: center; width: 120px;">2017-01-17</div>
                                        </td>
                                        <td align="left" class="handle">
                                            <div style="text-align: left; width: 170px; max-width:170px;">
                                                <a class="btn"
                                                   style="background-color: #999;border-color: #999;color: #fff;box-shadow:none"><i
                                                            class="fa fa-send-o"></i>发放</a>
                                                <a class="btn blue" href="/index.php/Admin/Coupon/coupon_list/id/9"><i
                                                            class="fa fa-search"></i>查看</a>
                                                <a class="btn blue" href="/index.php/Admin/Coupon/coupon_info/id/9"><i
                                                            class="fa fa-pencil-square-o"></i>编辑</a>
                                                <a class="btn red" href="javascript:void(0)"
                                                   data-url="/index.php/Admin/Coupon/del_coupon/id/9"
                                                   onclick="delfun(this)"><i class="fa fa-trash-o"></i>删除</a>
                                            </div>
                                        </td>
                                        <td align="" class="" style="width: 100%;">
                                            <div>&nbsp;</div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="sign">
                                            <div style="width: 24px;"><i class="ico-check"></i></div>
                                        </td>
                                        <td align="left" class="">
                                            <div style="text-align: left; width: 240px;">按用户类型发放</div>
                                        </td>
                                        <td align="left" class="">
                                            <div style="text-align: center; width: 60px;"></div>
                                        </td>
                                        <td align="left" class="">
                                            <div style="text-align: center; width: 50px;">30.00</div>
                                        </td>
                                        <td align="left" class="">
                                            <div style="text-align: center; width: 60px;">100.00</div>
                                        </td>
                                        <td align="left" class="">
                                            <div style="text-align: center; width: 50px;">0</div>
                                        </td>
                                        <td align="left" class="">
                                            <div style="text-align: center; width: 50px;">50</div>
                                        </td>
                                        <td align="left" class="">
                                            <div style="text-align: center; width: 50px;">0</div>
                                        </td>
                                        <td align="left" class="">
                                            <div style="text-align: center; width: 120px;">2015-12-11</div>
                                        </td>
                                        <td align="left" class="handle">
                                            <div style="text-align: left; width: 170px; max-width:170px;">
                                                <a class="btn"
                                                   style="background-color: #999;border-color: #999;color: #fff;box-shadow:none"><i
                                                            class="fa fa-send-o"></i>发放</a>
                                                <a class="btn blue" href="/index.php/Admin/Coupon/coupon_list/id/3"><i
                                                            class="fa fa-search"></i>查看</a>
                                                <a class="btn blue" href="/index.php/Admin/Coupon/coupon_info/id/3"><i
                                                            class="fa fa-pencil-square-o"></i>编辑</a>
                                                <a class="btn red" href="javascript:void(0)"
                                                   data-url="/index.php/Admin/Coupon/del_coupon/id/3"
                                                   onclick="delfun(this)"><i class="fa fa-trash-o"></i>删除</a>
                                            </div>
                                        </td>
                                        <td align="" class="" style="width: 100%;">
                                            <div>&nbsp;</div>
                                        </td>
                                    </tr>--}}
                                    </tbody>
                                </table>
                            </div>
                            <div class="iDiv" style="display: none;"></div>
                        </div>

                        <!--分页位置-->
                        <div class='dataTables_paginate paging_simple_numbers'>
                            @if(isset($coupon))
                                {!! $coupon->render() !!}}
                            @endif
                            {{--<ul class='pagination'>
                                <li class="paginate_button active"><a tabindex="0" data-dt-idx="1"
                                                                      aria-controls="example1" href="#">1</a></li>
                                <li class="paginate_button"><a class="num"
                                                               href="/index.php/admin/coupon/index/m/Admin/c/Coupon/a/index/p/2">2</a>
                                </li>
                                <li id="example1_next" class="paginate_button next"><a class="next"
                                                                                       href="/index.php/admin/coupon/index/m/Admin/c/Coupon/a/index/p/2">下一页</a>
                                </li>
                            </ul>--}}
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer_related')
    <script src="/js/bootbox.js"></script>
    <script src="/js/sweetalert.js"></script>

    <script>
        $(document).ready(function () {
            // 表格行点击选中切换
            $('#flexigrid > table>tbody >tr').click(function () {
                $(this).toggleClass('trSelected');
            });

            // 点击刷新数据
            $('.fa-refresh').click(function () {
                location.href = location.href;
            });
        });
        function delfun(obj) {
            layer.confirm('确认删除？', {
                        btn: ['确定', '取消'] //按钮
                    }, function () {
                        // 确定
                        $.ajax({
                            type: 'get',
                            url: $(obj).attr('data-url'),
                            dataType: 'json',
                            success: function (data) {
                                layer.closeAll();
                                if (data.sta == 1) {
                                    $(obj).parent().parent().parent().remove();
                                } else {
                                    layer.alert(data.msg, {icon: 2});  //alert('删除失败');
                                }
                            },
                            error: function () {
                                layer.closeAll();
                                layer.alert('网络请求出错', {icon: 2});
                            }
                        })
                    }, function (index) {
                        layer.close(index);
                    }
            );
        }

    </script>


@endsection
