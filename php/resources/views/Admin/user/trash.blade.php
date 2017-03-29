@extends('Admin.layout.main')

@section('title', '用户回收站')

@section('content')
    <div class="main-container">
        <div class="container-fluid">
            @include('Admin.layout.breadcrumb', [
                'title' => '用户回收站',
                'breadcrumb' => [
                '用户中心' => '',
                    '用户回收站' => ''
                ]
            ])

            <div class="row">
                <div class="box-widget widget-module">
                    <div class="widget-head clearfix"> <span class="h-icon"><i class="fa fa-list"></i></span>

                        <form class="navbar-form navbar-left" role="search" method="get" action="{{ route('user.trash') }}">
                            <div class="form-group">
                                <input name="keyword" value="{{ $keyword }}" class="form-control" type="text" placeholder="搜索">
                            </div>
                            <button type="submit" class="btn btn-default">搜索</button>
                        </form>
                    </div>

                    <div class="widget-container">
                        <div class=" widget-block">
                            <table class="table dt-table table-hover table-bordered">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>用户</th>
                                    <th>真实姓名</th>
                                    <th>邮箱</th>
                                    <th>角色</th>
                                    <th>登录时间</th>
                                    <th>操作</th>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach($user as  $ky =>$item)
                                    <tr>
                                        <td>
                                            {{($user->total() - $ky) - 10*($user->currentPage()-1) }}
                                        </td>
                                        <td>
                                            <a href="{{ route('user.show', $item->id) }}" target="_blank">
                                                {{ $item->name }}
                                            </a>
                                        </td>
                                        <td>{{ $item->real_name }}</td>
                                        <td>{{ $item->email }}</td>
                                        <td>{{ $item->role() }}</td>
                                        <td>{{ $item->loginHistory->max('created_at') }}</td>
                                        <td class="tc-center">
                                            <div class="btn-toolbar" role="toolbar">
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('user.restore', $item->id) }}" class="btn btn-default btn-sm m-user-restore">恢复</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                            <div class="dt-pagination">
                                <nav> {!! $user->render() !!} </nav>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer_related')
    <script src="/js/sweetalert.js"></script>
    <script type="text/javascript">
        jQuery(document).ready(function ($) {
            $('.btn-toolbar').on('click', '.m-user-restore', function (e) {
                e.preventDefault();
                var _this = this;
                var token = '{{ csrf_token() }}';
                var url = $(this).attr('href');
                swal({
                    title: "确定恢复用户?",
                    text: "",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "确定",
                    cancelButtonText: "取消",
                    closeOnConfirm: false,
                    closeOnCancel: true
                }, function (isConfirm) {
                    if (!isConfirm) return;

                    $.ajax({
                        type: "get",
                        url: url,
                        data: "_token=" + token,
                        success: function(json) {
                            if (json.state == 1) {
                                swal({
                                    title: '恢复成功',
                                    text: json.message,
                                    type: 'success',
                                    timer: 3000,
                                    //showConfirmButton: false
                                }, function() {
                                    window.location.reload();
                                });
                            }
                            else {
                                swal({
                                    title: "恢复失败",
                                    text: json.message,
                                    timer: 3000,
                                    //showConfirmButton: false,
                                    type: "error"
                                });
                            }
                        },
                        error: function(error) {
                            console.log(error);
                        }
                    });
                });
            })
        });
    </script>
@endsection
