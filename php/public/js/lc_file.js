/**
 * Created by way on 15/5/5.
 *
 * 文件处理
 
 *
 *
 */


define(function(require, exports, module){
    'use strict';


    var $doc = $(document)
    var extend = $.extend;

    var size_csion = {
        'K' : 1,
        'KB' : 1e3,
        'MB' : 1e6,
        'G' : 1e9,
        'T' : 1e12
    }


    var _config ={
        maxNum : 99,
        upload : 1
    }
    
    function file($root){
        var that = this;
        that._config = extend({},_config);
    }

    //获取上传数据
    file.prototype.getUpload = function (file_dom,callback,noData){
        var that = this;
        var _file = file_dom;
        var files = Array.prototype.slice.call(_file.files) ;
        files = that._config.maxNum ? files.slice(0,that._config.maxNum ) :files ;

        var files_len = files.length;
        var load_i = 0

        for (var i = 0; i < files_len; i++){
            ;(function (opt){
                var i = opt.i;
                if (!noData){
                    var fr = new FileReader();
                    fr.onload = _data_handle;
                    fr.readAsDataURL(_file.files[i]);
                }else{
                    _data_handle()
                }
                function _data_handle(e){
                    var cur_file = files[i];
                    var size_rst;
                    if (e){
                        fr = null;
                        cur_file.data = e.target.result;
                    }
                    var size = cur_file.size + '';
                    that.files = files;
                    size_rst = file.size_unit(size);
                    files[i].file_size = size_rst['file_size'];
                    files[i].size_unit = size_rst['size_unit'];
                    files[i].size_alia = size_rst['size_alia'];
                    load_i++;
                    if (load_i >= files.length ){
                        //读取完毕事件
                        that.onGetUploadEnd ? that.onGetUploadEnd(files,_file) : '';
                        callback ? callback(files,_file) : '';
                    }
                }
                

            }({
                i:i
            }));
        }
    }


    //文件大小单位转换
    file.size_unit = function (size,size_unit){
        var rst = {};
        var size = size+'';
        var sizeLen = Math.floor((size.length) / 3);
        var _size_unit;
        var file_size ;
        if (!size_unit){
            if (size.length % 3 == 0){
                sizeLen--
            }
            file_size = size  / Math.pow(1e3,sizeLen);
            switch (sizeLen){
                case(0):_size_unit = 'K' ;break;
                case(1):_size_unit = 'KB' ;break;
                case(2):_size_unit = 'MB' ;break;
                case(3):_size_unit = 'G' ;break;
                case(4):_size_unit = 'T' ;break;
                default : _size_unit = 'TB';
            }
        }else{
            if (size_csion[size_unit]){
                file_size = cur_file.size *1 / size_csion[size_unit];
                _size_unit = size_unit
            }
        }
        file_size = Math.round(file_size*100) /100;
        rst.file_size = file_size;
        rst.size_unit = _size_unit;
        rst.size_alia = file_size + _size_unit;
        return rst;
    }
    window.unit = file.size_unit


    file.prototype.config = function (opt){
        var that = this;
        extend(that._config,opt)
    }


   
    module.exports = file;

})

