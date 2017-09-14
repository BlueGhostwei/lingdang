@extends('Admin.layout.main')

@section('title', '商品属性')
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
    <div class="IAhead"><strong style="padding-right: 10px;">商品属性</strong><a href="{{ route('artice.M_properties') }}">商品属性</a>|<a href="{{ route('artice.Add_properties') }}">添加属性</a>|<a href="{{ route('goods.Add_goods') }}">添加商品</a>|</div>
	 
    <div class="IAMAIN_list">
        <div class="Alist">
            <form method="post" action="">
            <table width="100%"  cellspacing="0" cellpadding="0" >
                <tr class="Alist_head">
                    <th style="width: 80px;">ID</th>
                    <th>商品属性</th>
                    <th>属性规格</th>
                    <th>所属分类</th>
					<th>操作</th>
                </tr>
                   @if(isset($AttData))
                       @foreach($AttData as $k =>$v)
                    <tr class="Alist_main">
                        <td class="IMar_list" >1</td>
                        <td>{{$v['arr_name']}}</td>
                        <td>@if(isset($v['child'])&& !empty($v['child'])){{$v['child']}} @else暂无规格 @endif</td>
                        <td>{{$v['name']}}</td>
                        <td><a href="{{ route('artice.Add_specifications')."?type=update&id=".$v['id'] }}">添加规格 </a>|<span data_id=""> 删除</span></td>
                    </tr>
                    @endforeach
                       @endif
                   {{-- <tr class="Alist_main">
                        <td class="IMar_list" />2</td>
                        <td>尺寸</td>
                        <td>裙子</td>
						<td>[S]&nbsp;&nbsp;[M]</td>
                        <td><a href="{{ route('artice.Add_specifications') }}">添加规格 </a>| <a href="{{ route('artice.Add_moxing') }}">修改 </a>|<span data_id=""> 删除</span></td>
                    </tr>--}}
            </table>
            </form>
            <div style="text-align: center"></div>
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
