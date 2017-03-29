/**
 * Created by way on 15/4/23.
 *
 * 表单处理类
 * @fontAwesome
 * @zepto
 * v1.0.3  15/07/31
 * 1、把自动筛选抽出来
 * 2、增加表单验证
 * 3、把静态方法改成原型
 */


define(function(require, exports, module){
    'use strict';

    var $ = jQuery;
    function form(){
        var that = this;
        this.cache = {};

        this.cur_inputs = [];

        //默认验证规则
        this.rule = {
            must : function (v){
                if (!v){
                    return 0;
                }else{
                    return 1;
                }
            },
            email : function (v){
                if (v &&  /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test(v)){
                    return 1;
                }else{
                    return 0;
                }
            },
            min : function (v,rang){
                if (v.length  >= rang*1){
                    return 1;
                }else{
                    return 0;
                }
            },
            max : function (v,rang){
                if (v.length  <= rang*1 ){
                    return 1;
                }else{
                    return 0;
                }
            }
        }
        this.rule_tip ={
            must : '该选项为必填',
            email :'请输入正确的email地址'
        }
        this.msg = '';
    }


    form.prototype.sel_input = function ($form){
        var that = this;
        var cur_inputs = that.cur_inputs = [];
        var $form = $($form);
        var id = $form.attr('id');
        if (that.cache[id]){
            that.cur_inputs = that.cache[id]['cur_inputs'];
            return that.cache[id]['$inputs'];
        }
        var $inputs = $form.find('input');
        var $select = $form.find('select');
        var $textarea = $form.find('textarea');
        var inputs = {}

        $inputs.each(function (k,v){
            var $cur = $inputs.eq(k),
                cur_type = $cur.attr('type');
            if (!inputs[cur_type]){
                inputs[cur_type] = [];
            }
            inputs[cur_type].push($cur);
            that.cur_inputs.push($cur);
        })

        if ($select.size() > 0){
            $select.each(function (k,v){
                var $cur = $select.eq(k);
                if (!inputs['select']){
                    inputs['select'] = [];
                }
                inputs['select'].push($cur);
                that.cur_inputs.push($cur);
            })

        }
        if ($textarea.size() > 0){
            $($textarea).each(function (k,v){
                var $cur = $textarea.eq(k);
                if (!inputs['textarea']){
                    inputs['textarea'] = [];
                }
                inputs['textarea'].push($cur) ;
                that.cur_inputs.push($cur);
            })

        }
        if (id){
            that.cache[id] =  {
                $inputs : inputs,
                cur_inputs : cur_inputs
            };
        }
        return inputs;
    }

    var cache = {}

    form.prototype.getFormData = function ($obj){
        var that = this,
            $form,data={},$input,$radio,radio_list = {},$select,$checkbox;
        function getval($obj){
            if ($obj.length > 0){
                $obj.each(function (k,v){
                    var $cur = $obj.eq(k),
                        key = $cur.attr("name")
                    if ($cur.attr('type') == 'file'){
                        data[key] = $cur[0].files[0]
                    }else{
                        data[key] = $cur.val()
                    }
                })
            }
        }
        var inputs = that.sel_input($obj);
        (function (){
            var i;
            var ig = {checkbox:1,radio:1,select:1}
            for(i in inputs){
                var cur = inputs[i];
                if (!ig[i]){
                    $(cur).each(function (k,v){
                        var $cur = cur[k];
                        getval($cur);
                    })
                }
            }
        }());



        //复选框处理
        $checkbox = inputs['checkbox'];
        if ($checkbox){
            var check_arr = [];
            $checkbox.forEach(function (v,k){
                var $cur = $checkbox[k];
                check_arr.push($cur.val)
            })
        }


        //单选框类型处理
        $radio = inputs['radio'];
        if ($radio){
            $radio = $($radio);
            $radio.each(function (k,v){
                var $cur = $radio[k],
                    cur_name = $cur.attr('name');
                if (!radio_list[cur_name]){
                    radio_list[cur_name] =[];
                }
                radio_list[cur_name].push($cur);
            })


            var i,cur,val;
            for(i in radio_list){
                cur = radio_list[i];
                cur.forEach(function (v,k){
                    if (cur[k][0].checked){
                        val = v.value || k;
                        data[i] = val;
                    }
                })
            }
        }

        //下拉框处理
        $select = inputs['select'];
        if ($select){
            $select.forEach(function (v,k){
                var $cur = $($select[k]),
                    val,
                    $option,
                    key = $cur.attr("name");
                $option = $cur.find('option')
                $option.each(function (k,v){
                    var $cur = $option.eq(k);
                    if ($cur[0].selected){
                        //获取下标值
                        //val = k
                        //获取value值
                        val = $option.eq(k).val()
                    }
                })
                data[key] = val;
            })

        }


        return data;
    }



    //ui渲染
    function ui(root){
        var $form,$input;
        $form = $(root)
        $input = $form.find('input');
        ui_radio($form,$input.filter('[type=radio]'));
    }


    //单选框ui
    function ui_radio($root,$radio){
        var labels = {},i;
        $radio.each(function (k,v){
            var $cur = $radio.eq(k),label
            $cur.hide();
            $cur.wrap('<div class="fa fa-circle-o kw-radio">');
            label = $cur.attr('ui_label') || '.kw-radio';
            if (!labels[label]){
                labels[label] = label;
            }
        })
        for(i in labels){
            $root.on('click',labels[i],function (){
                var $this = $(this),
                    $name,
                    name,
                    $radio,
                    $input = $this.find('input');
                name = $input.attr('name');
                $name = $root.find('[name='+name+']');
                $radio = $input.closest('.kw-radio');
                $name.each(function (k,v){
                    var $cur = $name.eq(k);
                    $cur[0].checked = false;
                    $cur.closest('.kw-radio').removeClass('fa-dot-circle-o');
                })
                $input[0].checked = true;
                $radio.addClass('fa-dot-circle-o');
            })

        }
    }




    //表单验证
    form.prototype.check = function ($form){
        var that = this;
        that.msg = '';
        that.rule_tip ={
            must : '该选项为必填',
            email :'请输入正确的email地址'
        }
        var rule = that.rule;
        var inputs = that.sel_input($form);
        var $cur;
        var rst = 1,
            cur_rules,
            cur_val,
            cur_tips,
            _errorInputs = [],
            cur_type
        //console.log( that.cur_inputs)
        for (var i = 0, len = that.cur_inputs.length; i < len; i++){
            $cur = that.cur_inputs[i];
            cur_val = $cur.val();
            cur_type = $cur.attr('type');
            //类型验证
            if (rule[cur_type] && !rule[cur_type](cur_val)){
                that.msg = that.rule_tip[cur_type];
                rst = 0;
                _errorInputs.push($cur);
                break;
            }
            //自定义验证
            cur_tips = $cur.attr('check-tip');
            cur_rules = $cur.attr('check-rule');
            if (cur_tips){
                cur_tips = cur_tips.split(' ');
            }
            var cur_rule_val
            if (cur_rules){
                cur_rules = cur_rules.split(' ');
                for (var i2 = 0, len2 = cur_rules.length; i2 < len2; i2++){
                    cur_rule_val = cur_rules[i2];
                    if (cur_rule_val.indexOf('=') == -1){
                        if (rule[cur_rule_val] && !rule[cur_rule_val](cur_val)){
                            that.msg = that.rule_tip[cur_type] || (cur_tips && ( cur_tips[i2] || cur_tips[cur_tips.length -1]));
                            rst = 0;
                            break
                        }
                    }else{
                        cur_rule_val = cur_rule_val.split('=');
                        if (rule[cur_rule_val[0]] && !rule[cur_rule_val[0]](cur_val,cur_rule_val[1].slice(1,-1))){
                            that.msg =that.rule_tip[cur_rule_val[0]] ||  (cur_tips && ( cur_tips[i2] || cur_tips[cur_tips.length -1]));
                            rst = 0;
                            break
                        }
                    }
                }
            }

            if (!rst){
                _errorInputs.push($cur);
                break;
            }
        }
        return {
            status : rst,
            inputs :_errorInputs
        };
    }



    /* exports.getFormData = getFormData
     exports.ui = ui
     exports.sel_input = sel_input
     exports.check = check*/

    module.exports = form





})
