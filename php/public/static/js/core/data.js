

/*
* 2015/04/12
* 数据管理工具
* v1.0.0
*
*
* */





define(function(require, exports, module){
    'use strict';


    function data(ids){
        ids ? this.ids = path(ids) : '';
        this.cache = {}
        this.list = [];

    }


    //获取数据
    data.prototype.get = function (id){
        var $id = this.cache['_id'+id]
        if ($id){
          return path(ids);
        }
    }


    //添加数据
    data.prototype.add = function (arr,ids){
        var adds = [],_ids,
            cache = this.cache,
            list = this.list
        //debugger
        _ids = ids ? path(ids) : this.ids;
        for (var i = 0, len = arr.length; i < len; i++){
            var v = arr[i],
                val = idsVal(_ids,v)
            if (cache['_id'+val] == undefined){
                var cur_cache = cache['_id'+ val ] = {}
                cur_cache.data  = v;
                list.push(cur_cache);
                cur_cache.i = list.length - 1;
                adds.push(cur_cache);
            }
        }
        return adds;
    }


    //删除数据
    data.prototype.remove = function (id){
        var cache = this.cache,
            list = this.list
        if (id){
            list.splice(cache.i,1)
            delete cache['_id'+id] ;
        }else{
            this.cache = {};
            this.list = [];
        }
    }

    //更新数据
    data.prototype.update = function (id,val){
        var cache = this.cache,
            list = this.list
        if (id){
            var cur = cache['_id'+id]
            list[cur.i] = val;
            cache['_id'+id] = val
        }
    }

    //解析ids值
    function idsVal(ids,v){
        var _ids = ids,
            curVal
        if (isArray(_ids)){
            curVal = v;
            for (var i = 0, len = _ids.length; i < len; i++){
                curVal = curVal[_ids[i]];
            }
        }else{
            curVal = v[_ids];
        }
        return curVal;
    }



    //主键路径
    function path(ids){
        var _ids = ''
        _ids = ids.indexOf('.') == -1 ? ids : ids.split('.')
        return _ids;
    }




    function isType(type) {
        return function(obj) {
            return {}.toString.call(obj) == "[object " + type + "]"
        }
    }

    var isArray = Array.isArray || isType("Array")



    module.exports = data;
})