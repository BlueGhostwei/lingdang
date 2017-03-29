<div class="page-breadcrumb">
    <div class="row">
        <div class="col-md-7">
            <div class="page-breadcrumb-wrap">
                <div class="page-breadcrumb-info">
                    <h2 class="breadcrumb-titles">{{ isset($title) ? $title : '' }} <small>{{ isset($content) ? $content : '' }}</small></h2>
                    <ul class="list-page-breadcrumb">
                        <li><a href="{{ url('/') }}">首页</a></li>
                    @if (isset($breadcrumb) && !empty($breadcrumb))
                        @foreach ($breadcrumb as $k => $v)
                            @if (!empty($v))
                                <li><a href="{{ $v }}">{{ $k }}</a></li>
                            @else
                                <li class="active-page">{{ $k }}</li>
                            @endif
                        @endforeach
                    @endif
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-5">
        </div>
    </div>
</div>
