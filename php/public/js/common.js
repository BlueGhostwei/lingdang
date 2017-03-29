
window.common = {}

var $doc = jQuery(document);

define(function(require, exports, module){
    'use strict';
    var $ = jQuery;

    var upload = require('lc_upload');

    exports.uploadImg = function (that,opt){
        var opt = opt || {};
        var files =  Array.prototype.slice.call(that.files);
        if (opt.max){
            files = files.slice(0,opt.max);
        }
        $(that).prevAll('.imgPreViewVal').children().remove();
        $(that).prevAll('.imgPreViewBox').children().remove();
        files.forEach(function (v,k){
            upload({
                url : '/upload',
                data : {
                    file : v,
                    _token : _token
                },
                success : function (data){
                    $(that).prevAll('.imgPreViewVal').append('<input type="hidden" name="'+opt.inp_name+'" value="'+data.md5+'" />');
                    $(that).prevAll('.imgPreViewBox').css('display','inline-block').append('<div class="imgPreView-item"><div class="glyphicon glyphicon-remove imgPreViewi-close"></div><img src="'+data.url+'" class="imgPreViewi-img" /></div>');

                    that.onUploadEnd ? that.onUploadEnd(data) : ''
                }
            })
        })
    }

    $doc.on('click','.imgPreViewi-close',function (){
        var $this = $(this);
        var $cur = $this.closest('.imgPreView-item');
        var index = $cur.index();
        $cur.closest('.imgPreViewBox ').nextAll('.imgPreViewVal').children().eq(index).remove();
        $cur.remove();

    })


    exports.ImgPrevView = function ($root,opt){

        var opt = opt || {};

        var that = this;
        that.$root = $($root);
        that.$ImgPrevViewInp = that.$root.find('.ImgPrevViewInp');
        that.$ImgPrevViewInp.each(function (k,v){
            var $cur = that.$ImgPrevViewInp.eq(k);
            $cur.data('name',$cur.attr('name'));
            $cur.attr('name','');
        })
        that.$root.find('.ImgPreViewImgs').hide();



        that.$root.on('change','.ImgPrevViewInp',function (){
            var that = this;
            var $this = $(this);

            $this.prevAll('.ImgPreViewVals').children().remove();
            $this.prevAll('.ImgPreViewImgs').children().remove();
            var $curBox = $this.prevAll('.ImgPreViewImgs');
            $curBox.html('');
            var files =  Array.prototype.slice.call(that.files);
            var _max = opt.max || $this.attr('ipv-maxlength')*1;
            if (_max){
                files = that.files = files.slice(0,_max);
            }
            if (files.length>0){
                $this.prevAll('.ImgPreViewImgs').css('display','inline-block');
            }
            files.forEach(function (v,k){
                var inp_name = opt.inp_name || $this.data('name')
                upload({
                    url : '/upload',
                    data : {
                        file : v,
                        _token : _token
                    },
                    success : function (data){
                        var $cur_box =  $this.closest('.ImgPreViewBox');
                        $cur_box.find('.ImgPreViewVals').append('<input type="hidden" name="'+inp_name+'" value="'+data.md5+'" />');
                        $cur_box.find('.ImgPreViewImgs').append('<div class="ImgPreView-item"><div class="glyphicon glyphicon-remove ImgPreViewi-close"></div><img src="'+data.url+'" class="ImgPreViewi-img" /></div>');

                        that.onUploadEnd ? that.onUploadEnd(data) : ''
                    }
                })
            })
        })


        that.$root.on('click','.ImgPreViewi-close',function (){
            var $this = $(this);
            var $cur = $this.closest('.ImgPreView-item');
            var index = $cur.index();
            var $cur_box =  $this.closest('.ImgPreViewBox');
            $cur_box.find('.ImgPreViewVals').children().eq(index).remove();
            $cur.remove();

        })
        
    }

})




