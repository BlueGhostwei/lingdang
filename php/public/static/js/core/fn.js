/**
 * Created by way on 15/4/23.
 *
 * 常用方法类
 *
 */



define(function(require, exports, module){
    'use strict';

    //函数切换
    function toggle(a,b){
        var that = this;
        this.init = true;
        this.a = a;
        this.b = b;

        return function (){
            if (that.init){
                that.a()
            }else{
                that.b();
            }
        }
    }
    exports.toggle = toggle;
})


