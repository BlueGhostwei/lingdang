

/*
*
* tab
* */



define(function(require, exports, module){
    'use strict';

    var $ = jQuery;
    var extend = $.extend

    var _config = {
        display : 'block'
    }

    function TAB($root){
        var that = this, _$item,_$root,_$box
        that._config = extend({},_config)
        _$root = that.$root = $($root);
        _$item = that.$tab_item = _$root.find('.lc-tab-item');
        _$box = that.$tab_box = _$root.find('.lc-tab-box');
        that.index = 0;


        _$root.on('click','.lc-tab-item',function (){
            var $this = $(this);
            act($this.index());
        })


        function act(index,opt){
            var $this = _$item.eq(index)
            that.index = index;
            _$item.removeClass('active');
            $this.addClass('active');
            _$box.hide();
            _$box.eq(index).css('display',that._config.display);
            that.onChange ?  that.onChange($this,index) : '';
        }

        that.act = act;
    }
    TAB.prototype.config = function (opt){
        var that = this;
        extend(that._config,opt)
    }









    module.exports = TAB;
})


