@extends('Admin.layout.main')

@section('title', '操作记录')

@section('content')
    <div class="main-container">
        <div class="container-fluid">
            @include('Admin.layout.breadcrumb', [
                'title' => '操作记录',
                'breadcrumb' => [
                    '操作记录' => ''
                ]
            ])

            <div class="row">
                <div class="box-widget widget-module">
                    <div class="widget-head clearfix">
                        <span class="h-icon"><i class="fa fa-list"></i></span>

                        <form class="navbar-form navbar-left" role="search" method="get" action="{{ route('system.action') }}">
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
                                    <th>模块</th>
                                    <th>资源</th>
                                    <th>时间</th>
                                    <th>触发者</th>
                                    <th>说明</th>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach($action as $item)
                                    <tr>
                                        <td>{{ $item->id  }}</td>
                                        <th>{{ $item->model }}</th>
                                        <td>{{ $item->result_id }}</td>
                                        <td>{{ $item->created_at }}</td>
                                        <td>{{ $item->user->name }}</td>
                                        <td>
                                            用户
                                            @if ($item->user)
                                                {{ $item->user->name }}
                                            @else
                                                {{ '<s class="red">已注销用户</s>' }}
                                            @endif
                                            在 {{ $item->created_at }} {{ $item->action }} {{ $item->model }}
                                            @if (!empty($item->result_id))
                                                :: {{ $item->result_id }}
                                            @endif
                                            @if (!empty($item->description))
                                                , 标注: {{ $item->description }}
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                            <div class="dt-pagination">
                                <nav> {!! $action->render() !!} </nav>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
