
/**
 * 应用入口类 app.js
 */
define( function(require, exports) {
    "use strict";

    window.$ = require("core/selector.js");
    window.$doc = $(document);
    window.ls = localStorage;
    window.ss = sessionStorage;
    window.lang = require("core/lang.js");
    window.agent = require("core/agent.js");
    window.tpl = require("core/tpl.js");
    window.C = require("widget/config.js");
    window.cookie = require('core/cookie');
    window.wx = require('widget/jweixin-1.0.0.js');



    var NET = require('core/net');
/*
    var data = {
        _token : cookie('_token'),
        ssuser : cookie('SSUSER')
    };
*/

    window.net = new NET({
        //data:data,
        cache:0,
        onAllStart : function (xhr){
            common.loadShow();
        },
        onAllSuccess : function (xhr){
            //console.log('全局成功事件');
            common.loadHide(xhr);
        },
        onAllError : function (xhr){
            //console.log('全局失败事件')
            common.loadHide();
            common.alert('网络错误，请检查网络！')
        }
    });


    window.common = require("widget/common.js");
    //window.wx = require("widget/wx.js");


    //通用进度条页面
    var $common_progress = $('.common-progress')
    var $common_progress_bar = $('.common-progress-bar')

    $('body').append('<img class="test-img" style="display: none;" src="./static/img/common.png" >')
    $('body').append('<img class="test-img" style="display: none;" src="static/img/commonThree.png" >')
    $('body').append('<img class="test-img" style="display: none;" src="./static/img/commonTwo.png" >')
    $('body').append('<img class="test-img" style="display: none;" src="./static/img/storenj.png" >')
    $('body').append('<img class="test-img" style="display: none;" src="./static/img/storexx.png" >')
    $('body').append('<img class="test-img" style="display: none;" src="./static/img/one_to_one.png" >')
    $('body').append('<img class="test-img" style="display: none;" src="./static/img/qrcode.png" >')

    check_img_load();
    $common_progress.show();
    function check_img_load(){
        var completeNum = 0;
        var length = $('.test-img').length;
        $('.test-img').each(function(k,v){
            if (v.complete){
                completeNum++
            }
        })
        $common_progress_bar.css('width',(completeNum / length).toFixed(2) * 100 + '%')
        if (completeNum == length ){
            setTimeout(function(){
                $common_progress.hide();
                init();
            },100)
        }else{
            setTimeout(function(){
                check_img_load();
            },50)
        }
    }



    function init(){
        //$('#ibody').height($(window).height())
        //window._token;
        var page =require('core/page');
        require('core/time');
        var FastClick = require("core/fastclick.js");
        new FastClick(document.body);

        //禁用UC浏览器手势
        if (navigator.control && navigator.control.gesture) {
            navigator.control.gesture(false);
        }


        var $feedback_success = $('.feedback-success')
        var $course_construction = $('.course-construction')
        //切换页面默认顶部
        page.onShow(function (){
            scroll(0,0);
            common.loadHide();
            common.maskHide();
            $feedback_success.hide();
            $course_construction.hide();
        })

        page.start(C.def_page);

        window.addEventListener("orientationchange", function() {
            location.reload();
        }, false);
    }










});