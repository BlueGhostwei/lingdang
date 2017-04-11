@extends('Admin.layout.main')

@section('title', '添加幻灯片')
@section('header_related')
    <link rel="stylesheet" href="{{ url('/css/style.css') }}" type="text/css">

@endsection
@section('content')
    {{-- <div class="main-container">
         <div class="container-fluid">
             @include('Admin.layout.breadcrumb', [
                 'title' => '添加文章',
                 '' => [
                     '' => '',
                 ]
             ])--}}

    <div class="Iartice">
        <div class="IAhead"><strong style="padding-right: 10px;">添加幻灯片</strong></div>
        <div class="IAMAIN">
            <table width="100%" cellspacing="0" cellpadding="0">
                <tr>
                    <td align="right"><font color="red">*</font>幻灯名称：</td>
                    <td><input type="text" name="file_name" value="{{isset($rst)?$rst->file_name:''}}"
                               class="Iar_input"></td>
                </tr>
                <tr>
                    <td align="right"><font color="red">*</font>图片地址：</td>
                    <td>
                        <form method="post" id="upload_img" action="">
                            {{ csrf_field() }}
                            <input id="img" type="file" size="45" name="file" class="input">
                            <input name="img_Md5" type="hidden" value="{{isset($rst)?$rst->img_Md5:''}}">
                        </form>
                        {{--  <input type="file" id="fileupload"  onclick="return ajaxFileUpload();" class="button" value="上传图片"/>--}}
                    </td>
                </tr>
                <tr>
                    <td align="right"></td>

                    <td><img id="pic" src="{{isset($rst)? md52url($rst->img_Md5):url('images/z_add.png')}}"
                             style="width:auto; height: 80px; margin: 5px 0;"></td>

                </tr>
                <tr>
                    <td align="right"><font color="red">*</font>链接地址：</td>
                    <td><input type="text" name="line" value="{{isset($rst)?$rst->line:''}}" class="Iar_input"
                               placeholder="URL链接地址"></td>
                </tr>
                <tr>
                    <td align="right">排列顺序:：</td>
                    <td><input type="text" name="number" value="{{isset($rst)?$rst->number : ''}}" class="Iar_inpun"/>
                    </td>
                </tr>

                <tr height="60px">
                    <td align="right"></td>
                    <td><input type="button" class="dosubmit" value="提 交"></td>
                </tr>
            </table>
        </div>
    </div>
    <script type="text/javascript">
        $(function () {
            $('#img').change(function () {
                var data = new FormData($('#upload_img')[0]);
                $.ajax({
                    url: '{{url('upload')}}',
                    type: 'POST',
                    data: data,
                    dataType: 'JSON',
                    cache: false,
                    processData: false,
                    contentType: false
                }).done(function (ret) {
                    if (ret.sta == 1) {
                        $("#pic").attr("src", ret.url);
                        $('input[name="img_Md5"]').val(ret.md5);
                        return false
                    } else {
                        layer.msg('头像上传失败');
                    }
                });
            });
        });
        $('.dosubmit').click(function () {
            var _token = $('input[name="_token"]').val();
            var url = '@if(isset($rst)){{route('photo.update')}}@else{{route('artice.save_slide')}}@endif';
            var file_name = $('input[name="file_name"]').val();
            var img_Md5 = $('input[name="img_Md5"]').val();
            var line = $('input[name="line"]').val();
            var number = $('input[name="number"]').val();
            $.ajax({
                url: url,
                data: {
                    'photo_id':"{{isset($rst)?$rst->id:''}}",
                    'file_name': file_name,
                    'img_Md5': img_Md5,
                    'line': line,
                    'number': number,
                    '_token': _token
                },
                type: 'post',
                dataType: "json",
                stopAllStart: true,
                success: function (data) {
                    if (data.sta == '1') {
                        layer.msg(data.msg, {icon: 1});
                        setTimeout(window.location.href = '{{route('photo.slide')}}', 1000);
                    } else {
                        layer.msg(data.msg || '请求失败');
                    }
                },
                error: function () {
                    layer.msg(data.msg || '网络发生错误');
                    return false;
                }
            });

        });
        @if(isset($errors))
        @foreach ($errors->all() as $error)
        layer.msg('{{$error}}');
        setTimeout(window.location.href = '{{route('photo.slide')}}', 1000);
        @endforeach
        @endif
    </script>
@endsection
@section('footer_related')
@endsection
