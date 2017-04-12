@extends('Admin.layout.main')

@section('title', '内容管理')
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
    <div class="IAhead"><strong style="padding-right: 10px;">内容管理</strong><a href="{{ route('artice.artice_list') }}">内容列表</a>|<a href="{{ route('artice.index') }}">添加内容</a>|</div>
    <div class="IAMAIN_list">
        <div class="Alist">
            <form method="post" action="{{route('artice.artice_list')}}">
                {{csrf_field()}}
            <table width=""  cellspacing="0" cellpadding="0" style="float: right; margin-right: 30px;">
                <tr>
                    <td><input type="text" name="keyword" value="{{$keyword}}" class="Iar_list" placeholder="搜索编号，标题" /></td>
                    <td><input type="submit" name="dosubmit" class="button" value="搜 索"></td>
                </tr> 
            </table>
            </form>
        </div>

        <div class="Alist">
            <form method="post" action="">
            <table width="100%"  cellspacing="0" cellpadding="0" >
                <tr class="Alist_head">
                    <th>编号</th>
                    <th>内容标题</th>
                    <th>添加时间</th>
                    <th>所属栏目</th>
                    <th>发布人</th>
                    <th>操作</th>
                </tr>
                @if(isset($actice_data))
                    {{csrf_field()}}
                    @foreach($actice_data as $k=>$v)
                        <tr class="Alist_main">
                            <td  style="height: 30px;">{{$v['id']}} </td>
                            <td>{{$v['title']}}</td>
                            <td>{{$v['created_at']}}</td>
                            <td>{{get_srot_name($v['sort_id'])}}</td>
                            <td>{{$v['writer']}}</td>
                            <td><a href="{{route('artice.artice_list_show',$v['id'])}}">查看 </a>|<span class="actice_dele" data_id="{{$v['id']}}"> 删除</span></td>
                        </tr>
                        @endforeach
                    @endif

                {{--<tr class="Alist_main">
                    <td  style="height: 30px;"><input name="" type="checkbox" value="" /></td>
                    <td>这种银行卡5月起不能再用了，你知道吗？</td>
                    <td>2017-03-30</td>
                    <td>最新资讯</td>
                    <td>铃铛宝贝</td>
                    <td><a href="">修改 </a>|<a href=""> 删除</a></td>
                </tr>--}}
            </table>
            </form>
            <div style="text-align: center">
               {!! $actice_data->render() !!}
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function () {
        $('.actice_dele').click(function () {
            var _token = $('input[name="_token"]').val();
            var actice_id =$(this).attr('data_id');
            layer.confirm('确认删除此文章', {
                btn: ['确认','取消'], //按钮
                title:false,
            }, function(){
            $.ajax({
                url: "{{route('artice.artice_list_destroy')}}",
                data: {
                     'actice_id':actice_id,
                    '_token': _token
                },
                type: 'post',
                dataType: "json",
                stopAllStart: true,
                success: function (data) {
                    if (data.sta == '1') {
                        layer.msg(data.msg, {icon: 1});
                        setTimeout(window.location.reload, 1000);
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
