@extends('Admin.layout.main')

@section('title', '登录记录')

@section('content')
    <div class="main-container">
        <div class="container-fluid">
            @include('Admin.layout.breadcrumb', [
                'title' => '登录记录',
                'breadcrumb' => [
                    '登录记录' => ''
                ]
            ])

            <div class="row">
                <div class="box-widget widget-module">
                    <div class="widget-head clearfix"> <span class="h-icon"><i class="fa fa-list"></i></span>

                        <form class="navbar-form navbar-left" role="search" method="get" action="{{ route('system.login-history') }}">
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
                                    <th>登录时间</th>
                                    <th>登录 IP</th>
                                    <th>User Agent</th>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach($history as $item)
                                    <tr>
                                        <td>{{ $item->id  }}</td>
                                        <td>
                                            <a href="{{ route('user.show', $item->user_id) }}" target="_blank">
                                                @if($item->user) {{ $item->user->name }}@endif
                                            </a>
                                        </td>
                                        <td>{{ $item->created_at }}</td>
                                        <td>{{ $item->ip }}</td>
                                        <td>{{ $item->user_agent }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                            <div class="dt-pagination">
                                <nav> {!! $history->render() !!} </nav>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
