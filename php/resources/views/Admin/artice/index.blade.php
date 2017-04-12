@extends('Admin.layout.main')

@section('title', '添加内容')
@section('header_related')
    <link rel="stylesheet" href="{{ url('/css/style.css') }}" type="text/css">
    <link rel="stylesheet" type="text/css" href="{{url('js/wangEditor/dist/css/wangEditor.min.css')}}">
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
        <div class="IAhead"><strong style="padding-right: 10px;">添加内容</strong></div>
        <div class="IAMAIN">
            <form method="post" action="">
                {{csrf_field()}}
                <table width="100%" cellspacing="0" cellpadding="0">
                    <tr>
                        <td align="right" width="120"><font color="red">*</font>所属分类：</td>
                        <td>
                            <select  id="actice_id" name="cateid"  onchange="func()">
                                <option value="0">请选择栏目</option>
                                @if(isset($actice_sort))
                                    @foreach($actice_sort as $ky=>$vy)
                                        <option value="{{$vy['id']}}" @if(isset($actice) && $actice->sort_id==$vy['id'])selected @endif> {{$vy['name']}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td align="right"><font color="red">*</font>内容标题：</td>
                        <td>
                            <input type="text" value="{{isset($actice)?$actice->title:old('title')}}"  name="title" class="Iar_input"  placeholder="请输入文章标题……">
                            @if ($errors->has('title'))
                                <label class="error">
                                    <span class="error">{{ $errors->first('title') }}</span>
                                </label>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td align="right">作者：</td>
                        <td>
                            <input type="text" name="writer" value="{{isset($actice)?$actice->writer:old('writer')}}" class="Iar_inpun" placeholder="作者…"/>
                            @if ($errors->has('writer'))
                                <label class="error">
                                    <span class="error">{{ $errors->first('writer') }}</span>
                                </label>
                            @endif
                        </td>
                    </tr>
                    {{-- <td align="right">缩略图：</td>
                         <td>
                             <input type="text" name="" class="Iar_inputt">
                             <input type="button" class="button" value="上传图片"/>
                         </td>--}}
                    <tr>
                        <td align="right"><font color="red">*</font>内容详情：</td>
                        <td>
                            <div style="width:70%">
                                <div id="texDiv" style="height:400px;max-height:500px;">
                                    {!!isset($actice)?$actice->content:old('content')!!}
                                    @if ($errors->has('title'))
                                        <label class="error">
                                            <span class="error">{{ $errors->first('title') }}</span>
                                        </label>
                                        @elseif(!isset($actice))
                                        <p>请输入内容...</p>
                                    @endif
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr height="60px">
                        <td align="right"></td>
                        <td><input type="button" name="dosubmit" class="submit_button" value="提 交"></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
    <script type="text/javascript" src="{{url('/js/wangEditor/dist/js/lib/jquery-1.10.2.min.js')}}"></script>
    <script type="text/javascript" src="{{url('/js/wangEditor/dist/js/wangEditor.min.js')}}"></script>
    <script type="text/javascript">
        var editor = new wangEditor('texDiv');
        // 上传图片
        editor.config.uploadImgUrl = '/upload';

        // 配置自定义参数
        editor.config.uploadParams = {
            _token: '{{csrf_token()}}',
            user: '{{Auth::id()}}'
        };

        // 设置 headers（举例）
        editor.config.uploadHeaders = {
            'Accept': 'text/x-json'
        };
        // 隐藏掉插入网络图片功能。该配置，只有在你正确配置了图片上传功能之后才可用。
        editor.config.hideLinkImg = false;

        editor.create();

    </script>
    <script type="text/javascript">
      $(function () {
          $('.submit_button').click(function () {
              var URL="@if(isset($actice)){{route('artice.artice_list_update')}}@else{{route('support.store_actice')}}@endif";
              var reload_url="{{route('artice.artice_list')}}";
              var sort_id = $('#actice_id option:selected').val();
              if(sort_id == '0' || sort_id ==''){
                  layer.msg('请选择分类');
                  return false
              }
              var _token = $('input[name="_token"]').val();
              var title = $('input[name="title"]').val();
              if(title == ''){
                  layer.msg('标题不能为空');
                  $('input[name="title"]').focus();
                  return false
              }
              var writer = $('input[name="writer"]').val();
              if(writer == ''){
                  layer.msg('作者不能为空');
                  $('input[name="writer"]').focus();
                  return false
              }
              // 获取编辑器区域完整html代码
              var content = editor.$txt.html();
              $.ajax({
                  url: URL,
                  data: {
                      'actice_id':"{{isset($actice)?$actice->id:""}}",
                      'user_id':"{{Auth::id()}}",
                      'sort_id': sort_id,
                      'writer': writer,
                      'title': title,
                      'content':content,
                      '_token': _token
                  },
                  type: 'post',
                  dataType: "json",
                  stopAllStart: true,
                  success: function (data) {
                      if (data.sta == '1') {
                          layer.msg(data.msg, {icon: 1});
                          setTimeout(window.location.href = reload_url, 1000);
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
      });

    </script>
@endsection
@section('footer_related')
@endsection



