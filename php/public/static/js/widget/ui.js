/**
 * Created by way on 15/4/24.
 *
 * UI基础类
 * @lang
 */




define(function(require, exports, module){
    'use strict';
    //内容居中
    exports.center = function ($obj,opt){
        var css  = lang.extend({
            'position': 'absolute',
            'top' : '50%',
            'left' : '50%',
            'margin-left':$obj.width() / 2 * -1,
            'margin-top':$obj.height() / 2 * -1
        },opt)
        $obj.css(css)
        return $obj
    }



})