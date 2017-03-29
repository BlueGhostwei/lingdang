@extends('Admin.layout.main')

@section('title', '查看角色权限')

@section('content')
    <div class="main-container">
        <div class="container-fluid">
            @include('Admin.layout.breadcrumb')

            <div class="row">
                <div class="col-md-12">
                    {{ base_path('resources/views/acl/role/show.blade.php') }}
                </div>
            </div>
        </div>
    </div>
@endsection
