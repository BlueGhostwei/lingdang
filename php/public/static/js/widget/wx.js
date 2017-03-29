/*
*
* 微信组件
* @net
* @jweixin-1.0.0
* */

define(function(require, exports, module){
    var extend = lang.extend;

    var def_share =  {
            title : '最鲜干货！全球首款食物测鲜神器曝光！',
            desc : '划时代的科技革命，食品与互联网的跨界合作必定是轰动全球！',
            link: 'http://wx.exuniq.com/xd/html/app.php?act=webAuth',
            imgUrl: 'http://wx.exuniq.com/xd/html/static/img/shareImg.png',
            type: ''
        }
    var share;
    //初始化
    (function (){
        net.send({
            url:'app.php?act=wx_get_js_config',
            cache:0,
            data:{
                cur_href:encodeURIComponent(location.href.split('#')[0])
            },
            stopAllStart : true,
            //stopAllSuccess : true,
            onSuccess:function(data){
                _success(data);
            }
        })

        function _success(xhr) {
            //console.log(data);
            var _data = xhr.data;
            //alert(JSON.stringify(_data));
            var cf = {
                // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
                debug: false,
                // 必填，公众号的唯一标识
                appId: _data.appId,
                // 必填，生成签名的时间戳
                timestamp: _data.timestamp,
                // 必填，生成签名的随机串
                nonceStr: _data.nonceStr,
                // 必填，签名，见附录1
                signature: _data.signature,
                // 必填，需要使用的JS接口列表，所有JS接口列表见附录2
                jsApiList: [
                    'checkJsApi',
                    'onMenuShareTimeline',
                    'onMenuShareAppMessage',
                    'onMenuShareQQ',
                    'onMenuShareWeibo',
                    'onMenuShareQZone',
                    'hideMenuItems',
                    'showMenuItems',
                    'hideAllNonBaseMenuItem',
                    'showAllNonBaseMenuItem',
                    'translateVoice',
                    'startRecord',
                    'stopRecord',
                    'onVoiceRecordEnd',
                    'playVoice',
                    'onVoicePlayEnd',
                    'pauseVoice',
                    'stopVoice',
                    'uploadVoice',
                    'downloadVoice',
                    'chooseImage',
                    'previewImage',
                    'uploadImage',
                    'downloadImage',
                    'getNetworkType',
                    'openLocation',
                    'getLocation',
                    'hideOptionMenu',
                    'showOptionMenu',
                    'closeWindow',
                    'scanQRCode',
                    'chooseWXPay',
                    'openProductSpecificView',
                    'addCard',
                    'chooseCard',
                    'openCard'
                ]
            }
            wx.config(cf);
            wx._token = _data.access_token;
        }
    }())


    wx.error(function(res){
    });



    var is_share = false,
        share_opt;

    wx.setShare = function (opt,ready){
        share = extend({},def_share,{
            link : location.href
        },opt);
        setMenu();

        if(!is_share  && !ready ){
            share_opt = opt;
        }

        if(is_share  && ready && share_opt){
            wx.setShare(share_opt);
        }
    };


    function setMenu(){
        wx.onMenuShareAppMessage(share);
        wx.onMenuShareTimeline(lang.extend({},share,{
            title : share.title
        }));
        wx.onMenuShareQQ(share);
    }

    wx.ready(function (api){
        is_share = true;
        wx.setShare({},'ready');
    })

    wx.error(function (api){
        //location.href = 'http://wx.exuniq.com/xd/html/dist/app.php?act=webAuth'
    })


    module.exports = wx
})


