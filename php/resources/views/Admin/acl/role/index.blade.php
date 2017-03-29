@extends('Admin.layout.main')

@section('title', '角色列表')

@section('content')
    <div class="main-container">
        <div class="container-fluid">
            @include('Admin.layout.breadcrumb', [
                'title' => '角色列表',
                'breadcrumb' => [
                    '权限配置'=>'',
                    '角色列表' => ''
                ]
            ])
            <style>
                .widget-head {
                    margin-bottom: 15px;
                }
                .box-widget .widget-head{
                    background: #fff;
                }
                .widget_next_block{
                    border-top: solid 1px #eee;
                    border-left: solid 1px #eee;
                    border-right: solid 1px #eee;
                    border-bottom: solid 1px #eee;
                    margin-top: 19px;
                    background: #fff;
                    float: left;
                    width: 35%;
                    border-radius: 5px;
                    margin-left: 10px;
                }
                .widget_next_block li{
                    margin-bottom: 10px;
                }
                .widget_next_block ul{
                    margin:auto 5%;
                }
                div.widget-block{
                    float: left;
                    width: 60%;
                }
            </style>

            <div class="row">
                <div class="box-widget widget-module">
                    <div class="widget-container">
                        <div class=" widget-block">
                            <table class="table dt-table table-hover table-bordered">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>角色名</th>
                                    <th>拥有的权限(单位: 个)</th>
                                    <th>操作</th>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach($role as $item)
                                    <tr>
                                        <td>{{ $item -> id }}</td>
                                        <td>{{ $item -> acl_name }}</td>
                                        <td>{{ roleAccessCount($item->id) }}</td>
                                        <td>
                                            <div class="btn-toolbar" role="toolbar">
                                                <div class="btn-group" role="group">
                                                    @if($item ->id == 0)
                                                        <a disabled="disabled" href="{{ route('acl.role.edit', $item->id) }}" class="btn btn-default btn-sm {{mla('AclRoleController@edit', 'AclRoleController@update')}}">修改权限</a>
                                                    @else
                                                        <a href="{{ route('acl.role.edit', $item->id) }}" class="btn btn-default btn-sm {{mla('AclRoleController@edit', 'AclRoleController@update')}}">修改权限</a>
                                                    @endif

                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                            <div class="dt-pagination">
                            </div>

                        </div>
                        <div class=" widget_next_block {{mla('AclUserController@user_role')}}">
                            <form role="form" method="post" id="Form-Add-Class" action="{{ url( 'user_role') }}"
                                  method="post">
                                {{ csrf_field() }}

                                <ul class="input-sizing-list">
                                    <div class="widget-head clearfix">
                                        <span class="h-icon"><i class="fa fa-bars"></i></span>
                                        <h4>创建新角色</h4>
                                    </div>
                                    <li>
                                        <input name="acl_name"
                                               required="" class="form-control"
                                               placeholder="请输角色名"/>
                                    <li>
                                        <button class="btn btn-default" id="Form-Add-Class">
                                            创建新角色
                                        </button>
                                    </li>
                                </ul>
                            </form>
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
        /*jQuery(document).ready(function ($) {
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
        });*/
    </script>

@endsection
