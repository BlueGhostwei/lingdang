<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Eloquent;

class Goods extends Eloquent
{
    protected $table = "goods";

    /**
     * @var array
     * sort_id'('所属分类');
     * brand_id' '所属类型');
     * 'goods_sort''商品类型');
     * goods_title',20 '商品类型');
     * Thumbnails',25 '缩略图');
     * plan',225 '展示图');
     * 'price' '价格');
     * inventory' '库存');
     * Size_reference',100 '尺码参考');
     * measure',100 '尺码');
     * Shoulder_width',100 '肩宽');
     * Long_clothing',100 '衣长');
     * Sleeve_Length',100 '袖长');
     * bust',100 '胸围');
     * Material',100 '材质');
     * Colour',100 '颜色');
     * Sleeve_Type',100 '袖型');
     * style',100 '风格');
     * Version_type',100 '版型');
     * content' '商品详情');
     * recommend' 0默认不推荐，1为推荐');
	 *"para_name1(产品参数)
	 *para_value1(产品参数)
	 *para_name2(产品参考选择)
     */
    protected $fillable = [
        'sort_id',
        'brand_id',
        'goods_sort',
        'goods_title',
        'Thumbnails',
        'plan',
        'Size_reference',
        'inventory',
        'content',
        'recommend',
        'jf_exchange',
        'jf_price',
        'FreeCharge',
        'FreeCharge_num'
    ];
    public function rules(){
        return [
          'create'=>[
              'sort_id'=>'required',
              'brand_id'=>'required',
              'goods_title'=>'required|unique:'.$this->getTable(),
              'Thumbnails'=>'required',
              'plan'=>'required',
              'inventory'=>'required',
              //'price'=>'required',
              'content'=>'required'
          ],
            'update'=>[
                'inventory'=>'required',
                'sort_id'=>'required',
                'brand_id'=>'required',
                'goods_title'=>'required',
                'Thumbnails'=>'required',
                'plan'=>'required',
                //'price'=>'required',
                'content'=>'required'
            ]
        ];
    }



}
