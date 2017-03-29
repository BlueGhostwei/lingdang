@extends('Admin.layout.main')

@section('title', '权限列表')

@section('content')
    <div class="main-container">
        <div class="container-fluid">
            @include('Admin.layout.breadcrumb', [
                'title' => '权限列表',
                'breadcrumb' => [
                    '权限列表' => ''
                ]
            ])

            <div class="row">
                <div class="box-widget widget-module">
                    <div class="widget-container">
                        <div class=" widget-block">
                            <table class="table dt-table table-hover table-bordered">
                                <thead>
                                <tr>
                                    <th>模块</th>
                                    <th>权限名称</th>
                                    <th>资源</th>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach($resource as $model => $item)
                                    @foreach($item as $func => $action)
                                    <tr>
                                        <td>{{ $model  }}</td>
                                        <td>{{ $func }}</td>
                                        <td>{{ is_array($action) ? implode(', ', $action) : $action }}</td>
                                    </tr>
                                    @endforeach
                                @endforeach
                                </tbody>
                            </table>

                            <div class="dt-pagination">
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
        jQuery(document).ready(function ($) {
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
        });
    </script>

@endsection
