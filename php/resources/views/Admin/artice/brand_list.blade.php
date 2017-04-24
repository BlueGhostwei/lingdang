@extends('Admin.layout.main')

@section('title', '品牌管理')
@section('header_related')
   <link rel="stylesheet" href="{{ url('/css/style.css') }}" type="text/css">
   <style type="text/css">
       .layui-layer-btn{
           text-align: center;
       }
       .layui-layer-content{
           text-align: center;
       }
   </style>
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
    <div class="IAhead"><strong style="padding-right: 10px;">品牌管理</strong><a href="{{ route('artice.brand_list') }}">品牌列表</a>|<a href="{{ route('artice.Add_brand') }}">添加品牌</a>|<a href="{{ route('artice.goods_list') }}">商品列表</a>|<a href="{{ route('goods.Add_goods') }}">添加商品</a>|</div>
    <div class="IAMAIN_list">
        <div class="Alist">
            <form method="post" action="">
            <table width="100%"  cellspacing="0" cellpadding="0" >
                <tr class="Alist_head">
                    <th style="width: 80px;">排序</th>
                    <th>品牌名称</th>
                    <th>所属栏目</th>
                    <th>操作</th>
                </tr>
                @if(isset($BrandData))
                    {{csrf_field()}}
                   @foreach($BrandData as $ky =>$vy)
                        <tr class="Alist_main">
                            <td class="IMar_list" />{{$vy->id}}</td>
                            <td>{{$vy->brand_name}}</td>
                                <td >
                                    {{get_srot_name($vy->sort_id)}}
                                </td>
                            <td><a href="{{ route('artice.brand_edit',$vy->id) }}">修改 </a>|<span  data_id="{{$vy->id}}" class="dele_brand"> 删除</span></td>
                        </tr>
                       @endforeach
                    @else
                    <tr class="Alist_main">
                        <td class="IMar_list" />1</td>
                        <td>可米宝贝</td>
                        <td >[宝宝服饰]&nbsp;&nbsp;[婴儿鞋帽袜]</td>
                        <td><a href="{{ route('artice.Add_brand') }}">修改 </a>|<span data_id=""> 删除</span></td>
                    </tr>
                    @endif
            </table>
            </form>
            <div style="text-align: center"> {!! $BrandData->render() !!}</div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function () {
        var _token = $('input[name="_token"]').val();
        var url="{{route('artice.Brand_Dele')}}";
        $('.dele_brand').click(function () {
            var id =$(this).attr('data_id');
            layer.confirm('确认删除此品牌', {
                btn: ['确认','取消'], //按钮
                title:false,
            }, function(){
                $.ajax({
                    url: url,
                    data: {
                        'id': id,
                        '_token': _token
                    },
                    type: 'post',
                    dataType: "json",
                    stopAllStart: true,
                    success: function (data) {
                        if (data.sta == '1') {
                            layer.msg(data.msg, {icon: 1});
                            setTimeout(window.location.reload(), 1000);
                        } else {
                            layer.msg(data.msg || '请求失败');
                        }
                    },
                    error: function () {
                        layer.msg(data.msg || '网络发生错误');
                        return false;
                    }
                });
            }, function(){
                layer.msg('取消成功',{icon: 1});
            });
        });

    });
</script>
@endsection
@section('footer_related')
@endsection
