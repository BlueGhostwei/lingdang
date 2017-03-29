/**
 * Created by way on 15/5/5.
 *
 * 上传组件
 *
 * @lang
 *
 */


define(function(require, exports, module){
    'use strict';


    function upload(opt){
        var _net = new XMLHttpRequest();
        var fd = new FormData();
        var data = opt.data;
        var url = opt.url;
        var _upload = _net.upload;
        var success = opt.success;
        var error = opt.error;
        var progress = opt.progress;
        var load = opt.onload;
        var onEnd = opt.onEnd;
        var onStart = opt.onStart;
        var name = opt.name || 'upload';
        var last_loaded;

        data = data.files ? data.files : data;

        var i;
        for(i in data){
            fd.append('file',data[i]);
        }

        fd.append('_token',_token);
        /*data.forEach(function (v,k){
         fd.append(name+"[]", v);
         })*/

        _net.open("POST", url);

        //上传开始
        _upload.ononStart = function (e){
            last_loaded = e.loaded;
            onStart ? onStart(e): '';
        }


        //上传中
        _upload.onprogress = function (e){
            e.net_speed = e.loaded - last_loaded;
            e.prog = e.loaded / e.total * 100;
            last_loaded = e.loaded;
            progress ? progress(e) : '';
        }

        //上传
        _upload.onEnd = function (e){
            onEnd ? onEnd(e) : '';
        }

        _net.onreadystatechange = function (e){
            if (_net.status === 200 && _net.readyState === 3){
                var resDate = _net.response || _net.responseText;
                resDate = JSON.parse(resDate);
                if (resDate == ''){
                    return;
                }
                success ? success(resDate) : '';
            }
        }



        _net.send(fd);
        //console.log(_net)

    }





    module.exports = upload;

})

