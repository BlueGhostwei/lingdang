



/*
 * alert  全局提示框
 * text 自定义提示文本
 * time 时间
 *
 * 版本:v1.0.0
 * */

define(function(require, exports, module){
    'use strict';
    function Alert(sel,opt){
        var _opt = opt || {},
            style = {},
            that = this
        this.$root = $(sel)
        _opt.width ? style.width = _opt.width : false;
        this.$root.css(style);


        function isType(type) {
            return function(obj) {
                return {}.toString.call(obj) == "[object " + type + "]"
            }
        }

        var isFunction = Array.isFunction || isType("Function");
        var isString = Array.isString || isType("String");
        var isNumber = Array.isNumber || isType("Number");
        var isObject = Array.isObject || isType("Object");


        return function (){
            var arg = Array.prototype.slice.call(arguments)
            setTimeout(function(){

                var $alert,_text ,_time,_fn
                $alert = that.$root
                _text =  '更改成功';
                _time =  1500;
                arg.forEach(function (v,k){
                    if (isFunction(v)) {
                        _fn = v
                    }else if(isString(v)) {
                        _text = v
                    }else if(isNumber(v)){
                        _time = v
                    }
                })
                $alert.show();
                $alert.find('.alert-text').text(_text);
                $alert.css({
                    'margin-left':$alert.width() / 2 * -1,
                    'margin-top':$alert.height() / 2 * -1
                }).addClass('active');
                clearTimeout(alert.timeout);
                alert.timeout = setTimeout(function(){
                    _fn ? _fn() : '';
                    $alert.hide().removeClass('active');
                },_time)
            },10)
        }
    }

    Alert.prototype.show = function (){

    }

    module.exports = Alert;

})


