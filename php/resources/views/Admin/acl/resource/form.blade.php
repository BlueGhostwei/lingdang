@extends('Admin.layout.main')

@section('title', '权限点')

@section('content')
    <div class="main-container">
        <div class="container-fluid">
            @include('Admin.layout.breadcrumb', [
                'title' => !isset($resource) ? '添加权限点' : '修改权限点',
                'content' => isset($resource) ? $resource->name : '',
                'breadcrumb' => [
                    !isset($resource) ? '添加权限点' : '修改权限点' => ''
                ]
            ])

            <div class="row">
                <div class="col-md-12">
                    <div class="box-widget widget-module">
                        <div class="widget-container">
                            <div class=" widget-block">
                            @if (!isset($resource))
                                <form action="{{ route('acl.resource.store') }}" method="post" class="form-horizontal bv-form" novalidate="novalidate">
                            @else
                                <form action="{{ route('acl.resource.update', $resource->id) }}" method="post" class="form-horizontal bv-form" novalidate="novalidate">
                                {{ method_field('put') }}
                            @endif
                                    {{ csrf_field() }}

                                    <div class="form-group">
                                        <label class="col-lg-2 control-label">模块</label>
                                        <div class="col-lg-8">
                                            <input type="text" name="model" value="{{ isset($resource) ? $resource->model : old('model') }}" class="form-control" placeholder="权限名称" required minlength="6">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-lg-2 control-label">权限名称</label>
                                        <div class="col-lg-8">
                                            <input type="text" name="name" value="{{ isset($resource) ? $resource->name : old('name') }}" class="form-control" placeholder="权限名称" required minlength="6">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-lg-2 control-label">资源</label>
                                        <div class="col-lg-8">
                                            <textarea name="action" class="form-control" style="height: 200px;" placeholder="每行一个">{{ isset($resource) ? implode("\n", $resource->action) : old('action') }}</textarea>
                                        </div>
                                    </div>

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
