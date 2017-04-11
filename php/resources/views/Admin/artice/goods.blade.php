@extends('Admin.layout.main')

@section('title', '商品分类管理')
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
    <div class="IAhead"><strong style="padding-right: 10px;">商品分类管理</strong><a href="{{ route('artice.goods') }}">分类列表</a>|<a href="{{ route('artice.Add_subtopic',0) }}">添加分类</a>|<a href="{{ route('artice.goods_list') }}">商品列表</a>|<a href="{{ route('artice.brand_list') }}">品牌列表</a>|</div>
    <div class="IAMAIN_list">
        <div class="Alist">
            <form method="post" action="">
                {{csrf_field()}}
            <table width="100%"  cellspacing="0" cellpadding="0" >
                <tr class="Alist_head">
                    <th style="width: 80px;">编号</th>
                    <th style="text-align: left; padding-left: 20px;">栏目名称</th>
                    <th style="width: 250px">操作</th>
                </tr>
                @if(isset($sort))

                    @foreach($sort as $k =>$v)
                        <tr class="Alist_main">
                            <td class="IMar_list" style="font-weight: 700;" />{{$v['id']}}</td>
                            <td style="text-align: left; padding-left: 20px;">{{$v['name']}}</td>
                            <td><a href="{{ route('artice.Add_subtopic',$v['id'])}}">添加子栏目 </a>|<a href="{{route('sort.edit',$v['id'])}}"> 修改 </a>|<span data_id="{{$v['id']}}" class="dele"  > 删除</span></td>
                        </tr>
                        @if(isset($v['child']) && child_sort($v['id'],$v['child']) !='')
                            @foreach(child_sort($v['id'],$v['child']) as $ky =>$vy)
                            <tr class="Alist_main">
                                <td class="IMar_list" />1</td>
                                <td style="text-align: left; padding-left: 20px;">├─{{$vy['name']}}</td>
                                <td><a href="{{route('sort.edit',$vy['id'])}}"> 修改 </a>|<span data_id="{{$vy['id']}}" class="dele"> 删除</span></td>
                            </tr>
                            @endforeach
                            @endif
                        @endforeach
                    @endif

               {{-- <tr class="Alist_main">
                    <td class="IMar_list" />1</td>
                    <td style="text-align: left; padding-left: 20px;">├─ 可米宝贝</td>
                    <td><a href=""> 修改 </a>|<a href=""> 删除</a></td>
                </tr>
                <tr class="Alist_main">
                    <td class="IMar_list" />2</td>
                    <td style="text-align: left; padding-left: 20px;">├─ 可米宝贝</td>
                    <td><a href=""> 修改 </a>|<a href=""> 删除</a></td>
                </tr>
                <tr class="Alist_main">
                    <td class="IMar_list" />3</td>
                    <td style="text-align: left; padding-left: 20px;">├─ 可米宝贝</td>
                    <td><a href=""> 修改 </a>|<a href=""> 删除</a></td>
                </tr>
                <tr class="Alist_main">
                    <td class="IMar_list" style="font-weight: 700;"/>2</td>
                    <td style="text-align: left; padding-left: 20px;">可米宝贝</td>
                    <td><a href="{{ route('artice.Add_subtopic') }}">添加子栏目 </a>|<a href=""> 修改 </a>|<a href=""> 删除</a></td>
                </tr>--}}
            </table>

             <div style="text-align: center">   {!! $sort->render() !!}</div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function () {
        var _token= $('input[name="_token"]').val();
        $('.dele').click(function () {
            var  id =$(this).attr('data_id');//获取分类id值
            layer.confirm('确定删除？', {
                title: false,
                btn: ['确认','取消'] //按钮
            }, function(){
                $.ajax({
                    url:'{{route('sort.destroy')}}',
                    data: {
                        'id':id,
                        '_token':_token
                    },
                    type: 'post',
                    dataType: "json",
                    stopAllStart: true,
                    success: function (data) {
                        if (data.sta == '1') {
                            layer.msg('删除成功', {icon: 1});
                            window.location.reload();
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
                layer.msg('取消成功', {
                    time: 20000, //20s后自动关闭
                    //btn: ['明白了', '知道了']
                });
            });
        })
    });

</script>
@endsection
@section('footer_related')
@endsection
