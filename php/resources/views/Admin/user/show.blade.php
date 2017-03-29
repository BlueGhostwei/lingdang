@extends('Admin.layout.main')

@section('title', '显示用户信息')

@section('content')
    <div class="main-container">
        <div class="container-fluid">
            @include('Admin.layout.breadcrumb')
            <div class="row">
                <div class="col-md-12">
                    {{ base_path('resources/views/user/show.blade.php') }}
                    {{ var_dump($user->toArray()) }}
                </div>
            </div>
        </div>
    </div>
@endsection
