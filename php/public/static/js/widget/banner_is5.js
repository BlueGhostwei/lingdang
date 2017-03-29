/**
 * Created by way on 15/4/16.
 *
 * 广告图组件
 * @iscroll
 * @zepto
 * @lang
 * @sys
 *

 *
 */


define(function(require, exports, module){
    'use strict';
    var iScroll = require('../widget/iscroll5')

    function banner(root,opt){
        var that = this;
        setTimeout(function(){
            var def = {
                    scrollX: true,
                    scrollY: true,
                    snap: true,
                    snapSpeed: 400,
                    bounce : true,
                    momentum: false,
                    vScroll : false,
                    //hScroll : false,
                    hScrollbar: false,
                },
                _opt = opt || {},
                $root,
                loop,
                $content,
                event = {},
                autoTime = _opt.autoTime || 3500,
                $content_item,
                $btns,
                $btn,
                btn_tpl = '<div class="banner-btn"></div>',
                btn_html = '',
                currPageX = _opt.curPageX || 0,
                currPageY = _opt.curPageY || 0,
                autoPlay = _opt.autoPlay == undefined ? true : _opt.autoPlay,
                clientWidth,
                _iScroll


            $root = that.$root = typeof root == 'object' ? $(root) : $('#'+root);
            $root.css('overflow','hidden');

            if (opt.hScroll !== false){
                clientWidth = _opt.clientWidth || $root.width()
                $content = $root.find('.banner-content');
                $content_item = $content.find('.banner-content-item');

                that.set_size = function(){
                    $content_item.each(function (k,v){
                        $content_item.eq(k).css('width',clientWidth);
                        btn_html = btn_html + btn_tpl;
                    })
                    $content.css('width',$content_item.size()*clientWidth);
                }
                that.set_size();

                $btns = $root.find('.banner-btns');
                if ($btns.size() <= 0 && _opt.btns){
                    $btns = $(_opt.btns)
                }
                if ($btns.size() >0){
                    $btns.append(btn_html);
                    $btn = $btns.find('.banner-btn');
                }
                if ($root.css('position') == 'static'){
                    $root.css('position','relative')
                }
            }else{
                autoPlay = false;
                def.snapThreshold = 0.01;
                def.snapSpeed = 800;

                var clientHeight = _opt.clientHeight || $root.height()
                $content = $root.find('.banner-content').eq(0);
                $content_item = $content.find('.banner-content-item');

                that.set_size = function(){
                    $content_item.each(function (k,v){
                        $content_item.eq(k).css('height',clientHeight);
                    })
                    $content.css('height',$content_item.size()*$content_item.height());
                }
                that.set_size();

            }


            _iScroll = that.iScroll = new iScroll(root,lang.extend(def,_opt));

            _iScroll.on('beforeScrollEnd',function(e){
                currPageX = _iScroll.currentPage.pageX;
                currPageY = _iScroll.currentPage.pageY;
                _opt.onBeforeScrollEnd ? _opt.onBeforeScrollEnd(currPageX,currPageY) : '';
            })

            _iScroll.on('scrollStart',function(e){
                loop ? loop.stop() : '';
            })

            var pageNum = 0;
            _iScroll.on('scrollEnd',function(e){
                //console.log(_iScroll)
                currPageX = _iScroll.currentPage.pageX
                currPageY = _iScroll.currentPage.pageY
                loop ? loop.start() : '';
                btn(currPageX);
                _opt.scrollEnd ? _opt.scrollEnd(currPageX,currPageY) : '';

                if (pageNum !== currPageY && !opt.hScroll){
                    $root.find('.banner-content-item').eq(currPageY).addClass('active');
                    $root.find('.one-main-item').eq(currPageY).addClass('active');
                    $root.find('.banner-content-item').eq(pageNum).removeClass('active');
                    $root.find('.one-main-item').eq(pageNum).removeClass('active');
                    pageNum = currPageY;
                }
            })
            
            if (!opt.hScroll){
                $root.find('.banner-content-item').eq(currPageY).addClass('active');
                $root.find('.one-main-item').eq(currPageY).addClass('active');
            }

            /*_iScroll.goToPage(currPageX,currPageY,iScroll.utils.ease.quadratic);*/

            _opt.scrollEnd ? _opt.scrollEnd(currPageX) : '';



            if (autoPlay &&  $btn && $btn.size() > 0){
                loop = new lang.loop(function (){
                    currPageX++;
                    if (currPageX> loop.maxPageX){
                        currPageX= 0
                    }
                    _iScroll.goToPage(currPageX);

                },autoTime);
                loop.maxPageX = $content_item.size() - 1;
                loop.start();
            }
            btn(currPageX);



            function btn(index){
                if (!$btn){
                    return;
                }
                if ($btn.size() > 0){
                    $btn.removeClass('active');
                    $btn.eq(index).addClass('active');
                }
            }


        },10)

    }




    module.exports = banner
})

