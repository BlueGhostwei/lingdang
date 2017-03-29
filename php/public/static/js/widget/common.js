define(function(require, exports, module) {
    "use strict";

    //alert(navigator.userAgent)



    var Alert = require('widget/alert'),
        $doc = $(document);


    //自动高度
    if (document.body.scrollWidth > 1004){
        $('#ibody').css('min-height',document.body.scrollHeight)
    }

    $doc.on('submit','.j-form',function (e){
        e.preventDefault();
    })


    var goBack = {};

    //模拟A标签
    $doc.on('click','.j-href',function(){
        var $this = $(this)
        location['hash'] = $this.attr('data-href')
    })




    //回退按钮
    $doc.on('click','.j-back',function (e){
        setTimeout(function(){
            history.back();
        },10)
        goBack.timeout = setTimeout(function(){
            location.hash = '#/'+encodeURIComponent(C.def_page)
        },300)
    })

    //解决没有浏览记录时回到首页的问题
    window.addEventListener("hashchange", function (){
        clearTimeout(goBack.timeout);
    }, false);


    //点击效果
    $doc.on('click','.j-act',function (){
        var $this = $(this);
        $this.addClass('j-active');
        setTimeout(function(){
            $this.removeClass('j-active')
        },80)
    })




    //alert
    var _ALERT = new Alert('#common-alert')
    exports.alert = function (){
        var arg = Array.prototype.slice.call(arguments);
        !arg[0] ? arg[0] = C.def_page : '';
        _ALERT.apply(this,arg)
    };

    //全局遮罩
    var $mask = $('.globle-mask');
    exports.maskShow = function (opt){
        $mask.show();
    }
    exports.maskHide = function (opt){
        $mask.hide();
    }

    //全局loading
    var $loading = $('.iw-load-size')
    exports.loadShow = function (){
        $loading.css('display','-webkit-box');
    }
    exports.loadHide = function (){
        $loading.hide();
    }

    //全局提示
    var $showMsg = $("#globle-prompt-msg");

    exports.showMsg = function(string){
        $showMsg.html(string || "暂无内容");
        $showMsg.css("display","block");
    }

    exports.hideMsg = function(){
        $showMsg.css("display","none");
    }


    //
    exports.clearHTML = function ($root){
        setTimeout(function(){
            $root.html('')
        },20)
    }


    var upload = require('widget/lc_upload');

    exports.uploadImg = function (that,opt){
        var opt = opt || {};
        var files =  Array.prototype.slice.call(that.files);
        if (opt.max){
            files = files.slice(0,opt.max);
        }

        files.forEach(function (v,k){
            upload({
                url : '/upload',
                data : {
                    file : v,
                    _token : _token
                },
                success : function (data){
                    //data.md5
                    //data.url
                    if (data.sta == '0'){
                        common.alert(data.msg)
                        return;
                    }
                    that.onUploadEnd ? that.onUploadEnd(data) : ''
                }
            })
        })
    }


});



