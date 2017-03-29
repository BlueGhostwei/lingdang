@extends('Admin.layout.main')

@section('title', '系统日志')

@section('content')
    <div class="main-container">
        <div class="container-fluid">
            @include('Admin.layout.breadcrumb', [
                'title' => '系统日志',
                'breadcrumb' => [
                    '系统日志' => ''
                ]
            ])

            <div class="row">
                <div class="box-widget widget-module">
                    <div class="widget-head clearfix"> <span class="h-icon"><i class="fa fa-list"></i></span>
                        <ul class="nav navbar-nav">
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                    @if ($path)
                                        {{ $path }}
                                    @else
                                        {{ '系统日志' }}
                                    @endif
                                    <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu">
                                    @if ($allPaths)
                                        <li><a href="{{ route('system.logs') }}">系统日志</a></li>
                                    @endif
                                    @foreach($allPaths as $item)
                                        @if (basename($item) != '.')
                                        <li><a href="{{ route('system.logs', ['path' => basename($item)]) }}">{{ basename($item) }}</a></li>
                                        @endif
                                    @endforeach
                                </ul>
                            </li>
                        </ul>

                        <ul class="nav navbar-nav">
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                    {{ $log }}
                                    <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu">
                                    @foreach($allLogs as $item)
                                        <li><a href="{{ route('system.logs', ['path' => $path, 'log' => basename($item)]) }}">{{ basename($item) }}</a></li>
                                    @endforeach
                                </ul>
                            </li>
                        </ul>
                    </div>

                    <div class="widget-container">
                        <div class=" widget-block">
                            <table class="table dt-table table-hover table-bordered">
                                <tbody>
                                @foreach($logs as $v)
                                    <tr>
                                        <td style="word-wrap: break-word; word-break:break-all;"><span>{{ $v }}</span></td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer_related')
@endsection
