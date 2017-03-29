@extends('Admin.layout.main')

@section('title', '修改角色权限')

@section('content')
    <div class="main-container">
        <div class="container-fluid">
            @include('Admin.layout.breadcrumb', [
                'title' => '修改角色权限',
                'content' => role2text($role),
                'breadcrumb' => [
                    '修改角色权限' => ''
                ]
            ])

            <div class="row">
                <div class="col-md-12">
                    <div class="box-widget widget-module">
                        <div class="widget-container">
                            <div class=" widget-block">
                                <form action="{{ route('acl.role.update', $role) }}" method="post"
                                      class="form-horizontal bv-form" novalidate="novalidate">
                                    {{ method_field('put') }}
                                    {{ csrf_field() }}

                                    @foreach($resource as $model => $item)

                                        <div class="col-md-12 sel-item">
                                            <label class="checkbox-inline">
                                                <input class="tc-check-all" type="checkbox"> {{$model}}
                                            </label>

                                            <div class="col-md-12 bor-botm">
                                                @foreach($item as $func => $action)
                                                    <div class="col-md-3">
                                                        <label class="checkbox-inline">
                                                            <input class="tc-check" name="resource[]"
                                                                   value="{{ is_array($action) ? implode(',', $action) : $action }}"
                                                                   type="checkbox" {{ roleResourceChecked($action, $roleResource) }}> {{ $func }}
                                                        </label>
                                                    </div>
                                                @endforeach

                                            </div>
                                        </div>

                                    @endforeach

                                    <div class="form-group">
                                        <label class="col-lg-2 control-label">
                                            &nbsp;
                                        </label>

                                        <div class="col-lg-8">
                                            <div class="form-actions">
                                                <button type="submit" class="btn btn-primary">
                                                    提交
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer_related')
    <script src="/js/icheck.js"></script>
    <script src="/js/select2.js"></script>
    <script>
        $(window).load(function () {
            var $ = jQuery;
            var $doc = $(document);
            $('.tc-check,.tc-check-all').iCheck({
                checkboxClass: 'icheckbox_minimal-aero',
                radioClass: 'iradio_minimal-aero',
                increaseArea: '30%' // optional
            });
            var isTcCheck;
            $('.tc-check-all').on('ifChanged', function (e) {
                var $ = jQuery;
                var et = e.currentTarget;

                if (isTcCheck) {
                    isTcCheck = 0;
                    return;
                }
                if (et.checked) {
                    $obj = $(this).closest('.sel-item').find('.tc-check');

                    $obj.iCheck('check');

                } else {
                    $(this).closest('.sel-item').find('.tc-check').iCheck('uncheck');
                    isTcCheck = 0;
                }

            });
            //当所有子元素的为不选中的状态时，父元素的状态为不选
            $('.tc-check').on('ifChanged', function (e) {
                var $ = jQuery;
                var et = e.currentTarget;
                isTcCheck = 1;
                if (et.checked) {
                    $parent = $(this).closest('.sel-item').find('.tc-check-all');
                    $parent.iCheck('check');
                    isTcCheck = 0;
                }

                $childs = $(this).closest('.sel-item').find('.tc-check:checked');
                if ($childs.length == 0) {
                    $parent = $(this).closest('.sel-item').find('.tc-check-all');
                    $parent.iCheck('uncheck');
                }


            });
        })


    </script>

@endsection