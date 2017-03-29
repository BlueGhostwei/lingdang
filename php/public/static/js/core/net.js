

/* 2016-02-25
 * v1.0.0
 *
 * */

define(function(require, exports, module){
    'use strict';


    var _config = {
        dataType : 'json',
        type : 'get',
        concurrent : 1,
        cache : true,
        saver : 'ls',
        timeout : 3e4,
        hasUri : true,
        autoAbort : true,
        cacheTimeout : 0
    };
    var saverPef = '_lc_';
    var extend = lang.extend;
    var saver = {ls:localStorage,ss:sessionStorage};

    function net(opt){
        var that = this;
        that._config = {};
        that.config(opt);
        this.cache = {};
        this.list = {};
        this.lock = false;
        this.concurrent = that._config['concurrent'];
        this.saver = that.saverChange(that._config['saver']);
    }



    //发送
    net.prototype.send = function (opt){
        return this.transmit(opt);
    }

    //上传
    net.prototype.upload = function (opt){
        return this.transmit(opt,'upload');
    }


    //通信
    net.prototype.transmit = function (opt,type){
        var that = this;
        var xhr = new XMLHttpRequest();
        var _event = type === 'upload' ? xhr.upload : xhr;
        var _opt;
        if ((opt.type && opt.type != 'get' && opt.cache == undefined) || type === 'upload'){
            opt.cache = false;
        }
        if (type === 'upload'){
            opt.type = 'post';
        }
        _opt = that.option(extend(true,{},that._config,opt));
        _opt.xhr = xhr;
        xhr.opt = _opt;

        //是否锁定？
        if (that._lock){
            that.runEvent('Refuse',_opt,xhr);
            return false;
        }
        //并发判断
        if (!that.concurrentFn(_opt)){
            that.runEvent('Refuse',_opt,xhr);
            return false;
        }

        //通信进度
        _event.onprogress = function (e){
            var postion = e.loaded || e.position;
            var total = e.total;
            xhr.pex = total <= 0  ? 100: Math.round(postion / total*100);
            that.runEvent('Progress',_opt,xhr);
        }


        //通信开始时
        that.runEvent('Start',_opt,xhr);


        //通信完成时
        var _cacheData
        var _checkCache = that.checkCache(_opt);
        var _useCache = false;
        _cacheData = that.getCache(_opt);

        if (_checkCache && _cacheData){
            //console.log('使用缓存');
            setTimeout(function(){
                xhr.data = _cacheData;
                that.runEvent('Success',_opt,xhr);
            },_opt.cacheTimeout);
            _useCache = true;
        }

        xhr.onreadystatechange = function (e){
            var _sta = xhr.readyState;
            var _status = xhr.status;
            var res = xhr.responseText || xhr.response;
            var _cache;
            //console.log('readyState',_sta);
            //console.log('status',xhr.status);
            if (_sta === 4){
                if (_status == 200 || _status == 302 ){
                    xhr.data = that.resDate(e,_opt);
                    //是否有更新？??
                    _cache = that.saver[saverPef+_opt.url];
                    //debugger
                    if (_checkCache  && res !== _cache){
                        //cache 不为空
                        if (_cache && _opt.onUpdate){
                            _opt.onUpdate(xhr);
                        }
                        that.saveCache(xhr,_opt);
                    }
                    if (!_useCache){
                        that.runEvent('Success',_opt,xhr);
                    }
                    clearTimeout(_timeout);
                    that.clear(xhr,(_opt.autoAbort));
                }else{
                    _error();
                }

            }
        };

        //通信超时处理
        var _timeout = 0;
        _timeout = setTimeout(function(){
            that.runEvent('Timeout',_opt,xhr);
            that.clear(xhr,(_opt.autoAbort));
        },_opt.timeout)

        //通信失败时
        function _error(){
            that.runEvent('Error',_opt,xhr);
            clearTimeout(_timeout);
            that.clear(xhr,(_opt.autoAbort));
        }


        //通信终止时
        _event.onabort = function (){
            that.runEvent('Abort',_opt,xhr);
            clearTimeout(_timeout);
        }
        if (type === 'upload'){
            //debugger
        }
        xhr.open(_opt.type, _opt.url, true);
        xhr.send(_opt.data);
        return xhr;
    }





    //事件处理
    net.prototype.runEvent = function (name,opt,xhr){
        var allEvent = opt['onAll'+name];
        var isEvent = !opt['stopEvent'];
        var event = opt['on'+name];
        isEvent && !opt['stopAll'+name] && allEvent ? allEvent(xhr) : '';
        isEvent &&  !opt['stop'+name] && event ?  event(xhr) : '';
    }



    //并发处理
    net.prototype.concurrentFn = function (opt){
        var that = this;
        var list= that.list;
        var uri = opt.url;
        var rst = true;
        var concurrent = opt.concurrent;
        var cur = list[uri];
        if (cur){
            if (cur.length < concurrent){
                list[uri].push(opt.xhr);
            }else{
                rst = false;
                //console.log('超出并发数')
            }
        }else{
            list[uri] = [opt.xhr]
        }
        return rst;
    }


    //清理网络队列
    net.prototype.clear = function (xhr,isAbort){
        var that = this;
        var list= that.list;
        var uri;
        var _opt;
        var _cur;
        var i;
        var cur_list;
        if (xhr){
            _opt = xhr.opt;
            if (xhr.opt){
                uri = _opt.url;
                _cur = list[uri];
                if (_cur && _cur.length > 0){
                    if (isAbort){
                        _cur[0].abort();
                    }
                    _cur.splice(0,1);
                }
            }
        }else{
            if (isAbort){
                for(i in list){
                    cur_list = list[i];
                    for(var i1 = 0,len = cur_list.length-1; i1<=len;i1++ ){
                        cur_list[i1].abort();
                    }
                }
            }
            that.list = [];
        }
    }


    //终止请求
    net.prototype.abort = function (xhr){
        this.clear(xhr,true);
    }



    //URL处理
    net.prototype.urlFn = function (opt){
        var param = [],i;
        var url = opt.url;
        var data = opt.data;
        if (!url){
            return '';
        }
        //路由模式01
        url = url.replace(/\{.*\}/g,function (math){
            var key = math.replace(/\{|\}/g,'');
            var rst;
            if (data[key]){
                rst = data[key];
                delete data[key];
            }
            return rst || 0;
        })
        if (opt.hasUri){
            for(i in data){
                param.push(i+'='+data[i]);
            }
            param = param.join('&');
            if (param.length > 0){
                url = (url.indexOf('?') == -1 ? url+'?' : url+'&') + param ;
            }
        }

        return url;

    }

    //返回数据处理
    net.prototype.resDate = function (e,opt){
        var that = this;
        var tg = e.target;
        var _data;
        var dataType = opt.dataType || 'json';
        var res = tg.responseText || tg.response;
        switch (dataType){
            case ('text') : _data = res;
            default : that._try(function(){_data = JSON.parse(res)},function(){_data = res});
        }
        return _data ;
    }


    //参数加工
    net.prototype.option = function (opt){
        var that = this;
        if (opt){
            opt.success  = opt.success || function(){};
            opt.type  = opt.type || 'get';
            opt.url = that.urlFn(opt);
            opt.data  = _dataFn(opt.data);
            return opt;
        }

        //data加工
        function _dataFn(data){
            var _data=null;
            if (data){
                _data = opt.type == 'get' ? getData(data) : postData(data);
            }
            return _data;
        }


        //get模式拼接参数
        function getData(data){
            return null;
        }


        function postData(data){
            var fd = new FormData();
            var i;
            var _cur;
            for (i in data){
                if (data[i] && data[i].constructor === File){
                    _cur = data[i]
                }else{
                    JSON.stringify(_cur = data[i]);
                }
                fd.append(i,_cur);
            }
            return fd;
        }
    }

    //缓存检测
    net.prototype.checkCache = function (opt){
        var that = this;
        var hasCache = opt.cache;
        var hasSaver = that.saver;
        return hasCache && hasSaver ? true : false;
    }

    //保存缓存
    net.prototype.saveCache = function (e,opt){
        var that = this;
        var res = e.responseText || e.response;
        if (that.checkCache(opt)){
            that.saverChange(opt['saver']);
            //容量检测
            that.saver[saverPef+opt.url] = res;
        }
    }

    //获取缓存
    net.prototype.getCache = function (opt){
        var that = this;
        var rst;
        var uri;
        if (that.checkCache(opt)){
            that.saverChange(opt['saver']);
            uri = saverPef+opt.url;
            //debugger
            rst = that.cache[uri] ? that.cache[uri] : (that.saver[uri] ? that._try(function(){return JSON.parse(that.saver[uri])},function(){that.saver[uri]}) : null);
        }
        return rst;
    }


    //更换缓存方式
    net.prototype.saverChange = function (name){
        var that = this;
        that.saver = saver[name] ;
        return that.saver;
    }


    //锁定
    net.prototype.lock = function (){
        this._lock = true;
    }

    //解锁
    net.prototype.unLock = function (){
        this._lock = false;
    }


    //容错
    net.prototype._try = function (done,fault){
        try{
            return done();
        }catch(e){
            fault();
        }
    }


    //配置
    net.prototype.config = function (opt){
        extend(true,this._config,_config,opt);
    }


    module.exports = net;


})

