@extends('Admin.layout.main')

@section('title', '用户管理')

@section('content')
    <div class="main-container">
        <div class="container-fluid">
            @include('Admin.layout.breadcrumb', [
                'title' => '用户管理',
                'breadcrumb' => [
                '用户中心' => '',
                    '用户管理' => ''
                ]
            ])

            <div class="row">
                <div class="box-widget widget-module">
                    <div class="widget-head clearfix"> <span class="h-icon"><i class="fa fa-list"></i></span>

                        <form class="navbar-form navbar-left" role="search" method="get" action="{{ route('user.index') }}">
                            <div class="form-group">
                                <input name="keyword" value="{{ $keyword }}" class="form-control" type="text" placeholder="搜索">
                            </div>
                            <button type="submit" class="btn btn-default">搜索</button>
                        </form>
                    </div>

                    <div class="widget-container">
                        <div class=" widget-block">
                            <table class="table dt-table dataTable dtr-inline" id="DataTables_Table_1" role="grid" aria-describedby="DataTables_Table_1_info">
                                <thead>

                                <tr><th rowspan="1" colspan="1">
                                        编号
                                    </th><th rowspan="1" colspan="1">
                                        用户名
                                    </th><th rowspan="1" colspan="1">
                                        姓名
                                    </th>
                                    <th rowspan="1" colspan="1">
                                        类型
                                    </th>
                                    <th>
                                        创建时间
                                    </th>
                                    <th>
                                        创建人
                                    </th>
                                    <th rowspan="1" colspan="1">
                                        状态
                                    </th>
                                    <th>
                                        操作
                                    </th>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach($user as $key =>$item)
                                <tr role="row" class="odd">
                                    <td class="">
                                        {{($user->total() - $key) - 10*($user->currentPage()-1) }}
                                    </td>
                                    <td class="">
                                        {{ $item->name }}
                                    </td>
                                    <td>
                                        {{ $item->real_name }}
                                    </td>
                                    <td class="sorting_1">
                                        @if($item->role ==0)
                                            超级管理员
                                            @else
                                            {{ $item->role() }}
                                        @endif($item->role)
                                    </td>
                                    <td>
                                        {{ $item->created_at }}
                                    </td>

                                    <td>@if($item->createdBy){{ $item->createdBy}}@else{{ '-' }}@endif</td>
                                    <td>@if($item->lock == \App\Models\User::LOCK){{ '锁定' }}
                                        @else
                                        {{'可用'}}
                                        @endif
                                    </td>
                                    <td class="tc-center">
                                        <div class="btn-toolbar" role="toolbar">
                                            <div class="btn-group" role="group">
                                                @if($item->role !== 0)
                                                   {{-- <a href="{{route('acl.role.user_edit',$item->id)}}" class="btn btn-default btn-sm" >权限</a>--}}
                                                <a href="{{ route('admin.user.edit', $item->id) }}" class="btn btn-default btn-sm">编辑</a>
                                                @if ($item->lock == \App\Models\User::UNLOCK)
                                                <a href="{{ route('user.lock', $item->id) }}" class="btn btn-default btn-sm m-user-lock">锁定</a>
                                                @else
                                                <a href="{{ route('user.unlock', $item->id) }}" class="btn btn-default btn-sm m-user-unlock">启动</a>
                                                @endif
                                                <a href="{{ route('user.destroy', $item->id) }}" class="btn btn-default btn-sm m-user-delete">删除</a>
                                                @endif
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
    <script src="/js/bootbox.js"></script>
    <script src="/js/sweetalert.js"></script>
    <script type="text/javascript">
        $(window).load(function ($) {
            var $ = jQuery;
            $('.btn-toolbar').on('click', '.m-user-delete', function (e) {
                e.preventDefault();
                var _this = this;
                var token = '{{ csrf_token() }}';
                var url = $(this).attr('href');
                swal({
                    title: "确定删除?",
                    text: "删除后将不能恢复！!",
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
                        type: "delete",
                        url: url,
                        data: "_token=" + token,
                        success: function(json) {
                            if (json.state == 1) {
                                swal({
                                    title: '删除成功',
                                    text: json.message,
                                    type: 'success',
                                }, function() {
                                    window.location.reload();
                                });
                            }
                            else {
                                swal("删除失败!", json.message, "error");
                            }
                        },
                        error: function(error) {
                            console.log(error);
                        }
                    });
                });
            })

            var $ = jQuery;
            $('.btn-toolbar').on('click', '.m-user-lock', function (e) {
                e.preventDefault();
                var _this = this;
                var token = '{{ csrf_token() }}';
                var url = $(this).attr('href');
                swal({
                    title: "确定锁定用户吗?",
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
                        type: "post",
                        url: url,
                        data: "_token=" + token,
                        success: function(json) {
                            if (json.state == 1) {
                                swal({
                                    title: '锁定用户成功',
                                    text: json.message,
                                    type: 'success',
                                }, function() {
                                    window.location.reload();
                                });
                            }
                            else {
                                swal("锁定用户失败!", json.message, "error");
                            }
                        },
                        error: function(error) {
                            console.log(error);
                        }
                    });
                });
            })

            var $ = jQuery;
            $('.btn-toolbar').on('click', '.m-user-unlock', function (e) {
                e.preventDefault();
                var _this = this;
                var token = '{{ csrf_token() }}';
                var url = $(this).attr('href');
                swal({
                    title: "确定解锁用户吗?",
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
                        type: "post",
                        url: url,
                        data: "_token=" + token,
                        success: function(json) {
                            if (json.state == 1) {
                                swal({
                                    title: '解锁用户成功',
                                    text: json.message,
                                    type: 'success',
                                }, function() {
                                    window.location.reload();
                                });
                            }
                            else {
                                swal("解锁锁定用户失败!", json.message, "error");
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
