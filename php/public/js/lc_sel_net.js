/**
 * Created by way on 15/5/5.
 *
 * 下拉框 net篇
 *
 * @lang
 *
 */


define(function(require, exports, module){
    'use strict';
    var $ = jQuery;

    var extend = $.extend;
    var net = $.ajax;
    var Step  = require('step');



    var _config ={
        tpl_sel : '<select name="$name$">$option$</select>',
        tpl_def : '<option value="-1">请选择</option>',
        tpl_option : '<option value="$val$">$text$</option>'
    }



    function sel($root,opt){
        var that = this;
        that._config = extend(true,{},_config,opt);
        that.$root = $($root);
        that.$item =  that.$root.find('.lc-SelNet-item');
        that.index = 0;
        that.selectedStep = new Step();
        that.$cur_item = that.$item.eq(that.index);
        that.$root.on('focus','select',function (){
            var $this = $(this);
            var $cur_item = $this.closest('.lc-SelNet-item');
            that.$cur_item = $cur_item;
            that.index = $cur_item.index();
        })

        that.$root.on('change','select',function (e){
            var $this = $(this);
            that.onChange ? that.onChange(e) : '';
            that.change($this);
        })


    }

    //检查已选择
    sel.prototype.initSelected = function (){
        var that = this;
        var selected = that._config.selected;
        var selectedStep = that.selectedStep;
        if (selected && selected.length > 0){
            selected.forEach(function (v,k){
                (function (v,k){
                    selectedStep.add(function (){
                        var $sel = that.$item.eq(k).find('select');
                        $sel.find('option').eq(that._config.selected[k]*1).attr('selected','true');
                        $sel.trigger('change');
                    })
                }(v,k))


                /*var $cur = that.$item.eq(k);
                 $cur.find('select option')[v*1].selected = true;
                 that.change(that.$item.eq(v*1));*/
            })
            selectedStep.onEnd = function (){
                that.selectedStep = null;
            }
        }
        selectedStep.cur(0);
    }


    sel.prototype.change = function ($this){
        var that = this;
        var _config = that._config;
        var _index = that.index;
        var cur_net = _config.net[$this.attr('name')];
        if (!cur_net){
            return;
        }
        var $cur = that.$item.eq(that.index);
        if ($cur.size() <= 0){
            $this.closest('.lc-SelNet-item').after('<div class="lc-SelNet-item"></div>')
        }

        var net_config = extend(true,{},_config.nets,cur_net);
        net_config.dataType = net_config.dataType || 'JSON';

        //处理准备提交的数据
        (function (){
            var _data = net_config.data, i;
            for(i in _data){
                if (typeof _data[i] == 'string'){
                    _data[i] = _data[i].replace('$val$',$this.val())
                }
            }
        }())

        var success_copy = net_config['success'];
        net_config['success'] = function (data){
            var tpl_data = success_copy(data);
            that.index++;
            _index++;
            that.$cur_item = that.$item.eq(_index);
            that.$item.slice(_index).each(function (k,v){
                var $cur = $(v);
                $cur.find('select option').eq(0).nextAll().remove();
            })
            that.update(tpl_data);
            that.onChangeNet ? that.onChangeNet(data) :'';
            //console.log(that.selectedStep)
            if (that.selectedStep){
                that.selectedStep.next();
            }

        }
        net(net_config);
    }

    //更新
    sel.prototype.update = function (data){
        var that = this;
        var tpl_sel = '';
        var tpl_option = '';
        data.forEach(function (v,k) {
            var tpl =  that._config.tpl_option;
            tpl = tpl.replace('$val$', v.val);
            tpl = tpl.replace('$text$', v.text);
            tpl_option +=  tpl;
        })
        var $sel = that.$cur_item.find('select');
        if ($sel.length > 0){
            $sel.append(tpl_option);

        }else{
            tpl_sel =  that._config.tpl_sel.replace('$name$',that._config.name);
            tpl_sel = tpl_sel.replace('$option$',tpl_option);
            that.$cur_item.html(tpl_sel);
        }

    }



    sel.prototype.config = function (opt){
        that._config = extend(opt);
    }
    
    



    module.exports = sel;

})

