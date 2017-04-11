@extends('Admin.layout.main')

@section('title', '幻灯管理-添加幻灯片')
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
                'title' => '添加幻灯片',
                '' => [
                    '' => '',
                ]
            ])
            </div>
         </div>-->

    <div class="Iartice">
        <div class="IAhead"><strong style="padding-right: 10px;">幻灯管理</strong><a
                    href="{{ route('photo.slide') }}">幻灯管理</a>|<a href="{{ route('artice.Add_slide') }}">添加幻灯片</a>|
        </div>
        <div class="IAMAIN_list">
            <div class="Alist">
                <form method="post" action="">
                    <table width="100%" cellspacing="0" cellpadding="0">
                        <tr class="Alist_head">
                            <th style="width: 120px;">编号</th>
                            <th>幻灯图片</th>
                            <th>链接地址</th>
                            <th style="width: 250px;">管理操作</th>
                        </tr>
                        @if(isset($photo) && !empty($photo))
                            {{csrf_field()}}
                            @foreach($photo as $ky =>$vy)
                                <tr class="Alist_main">
                                    <td class="IMar_list"/>
                                    {{$vy['id']}}</td>
                                    <td><img src="{{md52url($vy['img_Md5'])}}"
                                             style="width:auto; height: 50px; margin: 5px 0;"></td>
                                    <td>{{$vy['line']}}</td>
                                    <td><a href="{{route('photo.show',$vy['id'])}}">修改 </a>|<span
                                                photo_id="{{$vy['id']}}" class="Dete_Pho"> 删除</span></td>
                                </tr>
                            @endforeach
                        @else
                            <tr class="Alist_main">
                                <td class="IMar_list"/>
                                1</td>
                                <td><img src="" title="这是一张图片" style="width:auto; height: 50px; margin: 5px 0;"></td>
                                <td></td>
                                <td><a href="">修改 </a>|<a href=""> 删除</a></td>
                            </tr>
                        @endif
                    </table>
                </form>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(function () {
                $('.Dete_Pho').click(function () {
                    var photo_id = $(this).attr('photo_id');
                    layer.confirm('确认删除此轮播图', {
                        btn: ['确认', '取消'], //按钮
                        title: false,
                    }, function () {
                        var URL = "{{route('photo.destroy')}}";
                        var _token = $('input[name="_token"]').val();
                        $.ajax({
                            url: URL,
                            data: {
                                'id': photo_id,
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
                    }, function () {
                        layer.msg('取消成功', {icon: 1});
                    });
            });

        });

    </script>
@endsection
@section('footer_related')
@endsection
