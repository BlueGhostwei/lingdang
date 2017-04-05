@extends('Admin.layout.main')

@section('title', '添加品牌')
@section('header_related')
    <link rel="stylesheet" href="{{ url('/css/style.css') }}" type="text/css">
    <script type="text/javascript" src="{{ url('/js/jquery.1.4.2-min.js') }}"></script>
    @endsection
    @section('content')
            <!--<div class="main-container">
        <div class="container-fluid">
          {{--  @include('Admin.layout.breadcrumb', [
                'title' => '添加文章',
                '' => [
                    '' => '',
                ]
            ])--}}
            </div>
         </div>-->

    <div class="Iartice">
        <div class="IAhead"><strong style="padding-right: 10px;">添加品牌</strong></div>
        <div class="IAMAIN">
            {{--  <form method="post" action="{{route('sort.store')}}">--}}

            <table width="100%" cellspacing="0" cellpadding="0">
                <tr style=" height: auto">
                    <td align="right" valign="top"><font color="red">*</font>所属栏目：</td>
                    <td>
                        <div class="plus-tag tagbtn clearfix" id="myTags">
                            {{--添加元素展示部分--}}
                        </div>
                        <div class="plus-tag-add"><a href="javascript:void(0);">展开推荐标签</a></div>
                        <div id="mycard-plus" style="display:none;">
                            <div class="default-tag tagbtn">
                                <div class="clearfix Brand_main">
                                    {{--展示部分--}}
                                     <li><a value="-1" title="互联网"
                                            href="javascript:void(0);"><span>互联网</span><em></em></a></li>
                                     <li><a value="-1" title="├─ 移动互联网"
                                            href="javascript:void(0);"><span>├─ 移动互联网</span><em></em></a></li>
                                     <li><a value="-1" title="├─ it"
                                            href="javascript:void(0);"><span>├─ it</span><em></em></a></li>
                                     <li><a value="-1" title="电子商务"
                                            href="javascript:void(0);"><span>电子商务</span><em></em></a></li>
                                     <li><a value="-1" title="广告" href="javascript:void(0);"><span>广告</span><em></em></a>
                                     </li>
                                </div>
                                <div class="clearfix Brand_main">
                                    {{--展示部分--}}
                                    <li><a value="-1" title="互联网2"
                                           href="javascript:void(0);"><span>互联网2</span><em></em></a></li>
                                    <li><a value="-1" title="├─ 移动互联网"
                                           href="javascript:void(0);"><span>├─ 移动互联网</span><em></em></a></li>
                                    <li><a value="-1" title="├─ it"
                                           href="javascript:void(0);"><span>├─ it</span><em></em></a></li>
                                    <li><a value="-1" title="电子商务"
                                           href="javascript:void(0);"><span>电子商务</span><em></em></a></li>
                                    <li><a value="-1" title="广告" href="javascript:void(0);"><span>广告</span><em></em></a>
                                    </li>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td align="right"><font color="red">*</font>品牌名称：</td>
                    <td><input type="text" name="store_name" value="" class="Iar_input"></td>
                </tr>
                <tr>
                    <td align="right">排列顺序：</td>
                    <td><input type="text" name="store_num" value="" class="Iar_inpun"/></td>
                </tr>

                <tr height="60px">
                    <td align="right"></td>
                    <td><input type="button" name="dosubmit" class="sumbutton" value="提 交"></td>
                </tr>
            </table>
            {{-- </form>--}}
        </div>
    </div>


    <script type="text/javascript">
        $(function () {

            $('.sumbutton').click(function () {
                var name = $("input[name='store_num']").val();
                var num = $("input[name='store_name']").val();
                var
                    $("#myTags a").each(function(){
                     $(this).attr("value");
                        debugger
                    });



                debugger
            });


        });
        var FancyForm = function () {
            return {
                inputs: ".FancyForm input, .FancyForm textarea",
                setup: function () {
                    var a = this;
                    this.inputs = $(this.inputs);
                    a.inputs.each(function () {
                        var c = $(this);
                        a.checkVal(c)
                    });
                    a.inputs.live("keyup blur", function () {
                        var c = $(this);
                        a.checkVal(c);
                    });
                }, checkVal: function (a) {
                    a.val().length > 0 ? a.parent("li").addClass("val") : a.parent("li").removeClass("val")
                }
            }
        }();
    </script>

    <script type="text/javascript">
        var searchAjax = function () {
        };
        var G_tocard_maxTips = 30;

        $(function () {
            (function () {

                var a = $(".plus-tag");

                $("a em", a).live("click", function () {
                    var c = $(this).parents("a"), b = c.attr("title"), d = c.attr("value");
                    delTips(b, d)
                });

                hasTips = function (b) {
                    var d = $("a", a), c = false;
                    d.each(function () {
                        if ($(this).attr("title") == b) {
                            c = true;
                            return false
                        }
                    });
                    return c
                };

                isMaxTips = function () {
                    return
                    $("a", a).length >= G_tocard_maxTips
                };

                setTips = function (c, d) {
                    if (hasTips(c)) {
                        return false
                    }
                    if (isMaxTips()) {
                        alert("最多添加" + G_tocard_maxTips + "个标签！");
                        return false
                    }
                    var b = d ? 'value="' + d + '"' : "";
                    a.append($("<a " + b + ' title="' + c + '" href="javascript:void(0);" ><span>' + c + "</span><em></em></a>"));
                    searchAjax(c, d, true);
                    return true
                };

                delTips = function (b, c) {
                    if (!hasTips(b)) {
                        return false
                    }
                    $("a", a).each(function () {
                        var d = $(this);
                        if (d.attr("title") == b) {
                            d.remove();
                            return false
                        }
                    });
                    searchAjax(b, c, false);
                    return true
                };

                getTips = function () {
                    var b = [];
                    $("a", a).each(function () {
                        b.push($(this).attr("title"))
                    });
                    return b
                };

                getTipsId = function () {
                    var b = [];
                    $("a", a).each(function () {
                        b.push($(this).attr("value"))
                    });
                    return b
                };

                getTipsIdAndTag = function () {
                    var b = [];
                    $("a", a).each(function () {
                        b.push($(this).attr("value") + "##" + $(this).attr("title"))
                    });
                    return b
                }
            })()
        });
    </script>

    <script type="text/javascript">
        // 更新选中标签标签
        $(function () {
            setSelectTips();
            $('.plus-tag').append($('.plus-tag a'));
        });
        var searchAjax = function (name, id, isAdd) {
            setSelectTips();
        };

        // 推荐标签
        (function () {
            var str = ['展开添加分类', '收起商品分类']
            $('.plus-tag-add a').click(function () {
                var $this = $(this),
                        $con = $('#mycard-plus');

                if ($this.hasClass('plus')) {
                    $this.removeClass('plus').text(str[0]);
                    $con.hide();
                } else {
                    $this.addClass('plus').text(str[1]);
                    $con.show();
                }
            });
            $('.default-tag a').live('click', function () {
                var $this = $(this),
                        name = $this.attr('title'),
                        id = $this.attr('value');
                setTips(name, id);
            });
            // 更新高亮显示
            setSelectTips = function () {
                var arrName = getTips();
                if (arrName.length) {
                    $('#myTags').show();
                } else {
                    $('#myTags').hide();
                }
                $('.default-tag a').removeClass('selected');
                $.each(arrName, function (index, name) {
                    $('.default-tag a').each(function () {
                        var $this = $(this);
                        if ($this.attr('title') == name) {
                            $this.addClass('selected');
                            return false;
                        }
                    })
                });
            }

        })();
    </script>

@endsection
@section('footer_related')
@endsection

