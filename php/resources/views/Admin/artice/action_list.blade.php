@extends('Admin.layout.main')

@section('title', '内容管理')
@section('header_related')
   <link rel="stylesheet" href="{{ url('/css/style.css') }}" type="text/css">

@endsection
@section('content')
    <!--<div class="main-container">
        <div class="container-fluid">
            @include('Admin.layout.breadcrumb', [
                'title' => '添加文章',
                '' => [
                    '' => '',
                ]
            ])
        </div>
     </div>-->

<div class="Iartice">
    <div class="IAhead"><strong style="padding-right: 10px;">内容管理</strong><a href="{{ route('artice.artice_list') }}">内容列表</a>|<a href="{{ route('artice.index') }}">添加内容</a>|</div>
    <div class="IAMAIN_list">
        <div class="Alist">
            <form method="post" action="">
            <table width=""  cellspacing="0" cellpadding="0" style="float: right; margin-right: 30px;">
                <tr>
                    <td>            
                        <select name="cateid">
                            <option>请选择栏目</option>
                            <option>读取内容分类</option>
                        </select>           
                    </td>
                    <td>            
                        <select name="cateid">
                            <option>时间排序</option>
                        </select>           
                    </td>
                    <td align="right">关键字：</td>
                    <td><input type="text" value="" class="Iar_list" /></td> 
                    <td><input type="submit" name="dosubmit" class="button" value="搜 索"></td>
                </tr> 
            </table>
            </form>
        </div>

        <div class="Alist">
            <form method="post" action="">
            <table width="100%"  cellspacing="0" cellpadding="0" >
                <tr class="Alist_head">
                    <th>选择</th>
                    <th>内容标题</th>
                    <th>添加时间</th>
                    <th>所属栏目</th>
                    <th>发布人</th>
                    <th>操作</th>
                </tr>
                <tr class="Alist_main">
                    <td  style="height: 30px;"><input name="" type="checkbox" value="" /></td>
                    <td>这种银行卡5月起不能再用了，你知道吗？</td>
                    <td>2017-03-30</td>
                    <td>最新资讯</td>
                    <td>铃铛宝贝</td>
                    <td><a href="">修改 </a>|<a href=""> 删除</a></td>
                </tr>
                <tr class="Alist_main">
                    <td  style="height: 30px;"><input name="" type="checkbox" value="" /></td>
                    <td>这种银行卡5月起不能再用了，你知道吗？</td>
                    <td>2017-03-30</td>
                    <td>最新资讯</td>
                    <td>铃铛宝贝</td>
                    <td><a href="">修改 </a>|<a href=""> 删除</a></td>
                </tr>
            </table>
            </form>
        </div>
    </div>
</div>

@endsection
@section('footer_related')
@endsection
