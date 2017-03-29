/**
 * Created by way on 15/5/5.
 *
 *
 * url 处理类
 */


define(function(require, exports, module){
    'use strict';


    function url(){

    }

    url.param_url = function (url,param_){

    }



    //页面显示事件
    function url_change_show(){
        //console.log('进入 ===== '+location.hash.split('?')[0])
        seajs.use(['core/page','page/'+location.hash.replace('#/','').split('?')[0]],function (page,exp){
            var sta = page.parseURL(location.href);
            exp.show(sta.state);
        })
    }


    //页面隐藏事件
    function url_change_hide(){
        //console.log('离开 ===== '+location.hash.split('?')[0])
        seajs.use(['core/page','page/'+location.hash.replace('#/','').split('?')[0]],function (page,exp){
            var sta = page.parseURL(location.href);
            exp.hide(sta.state);
        })
    }



    function fn_fetch(fn){
        return fn.toString().match(/\{(.|\n)*/g)[0].slice(1,-1);
    }


    url.go = function (url,ani,act,target){
        if (window.plus && target == undefined){
            var plus = window.plus;
            var wv = plus.webview;
            var ani = ani || 'pop-in';
            var webview = wv.getWebviewById(url);
            var cur_wv = wv.currentWebview();
            var act = act || 'show';
            var _url = location.origin+location.pathname+url;
            /*console.log('url ======'+url)
            console.log('ani ======== '+ani)
            console.log('act ======='+act)*/
            //console.log('要跳转的页面 ===== '+ url);
            /*console.log(url)
            console.log(act)
            console.log(ani)*/

            if (webview){
                if (act == 'show'){
                    webview.evalJS(fn_fetch(url_change_show));
                    wv.show(webview,ani);
                }else{
                    cur_wv.evalJS(fn_fetch(url_change_hide));
                    wv.hide(cur_wv,ani);
                }
            }else{
                webview = wv.open(_url,url,{
                    hardwareAccelerated : true,
                    scrollIndicator : 'none'
                },ani)

                /*webview.addEventListener("loaded", function(e){
                    webview.addEventListener("show", function(e){

                    }, false );

                    webview.addEventListener("hide", function(e){

                    }, false );
                }, false );*/

            }
        }else{
            location['hash'] = url;
        }


    }




    module.exports = url



})

