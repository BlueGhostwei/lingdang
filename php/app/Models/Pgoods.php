<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/21
 * Time: 10:21
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Eloquent;

class Pgoods extends Eloquent
{
    protected $table = "pgoods";

    /**
     * @var array
     * para2_kucun('单个库存');
     * para2_jiage' '价格');
     * 'para2_level1''一级分类');
     * 'para2_level2','二级分类');
     * 'para2_level3', '三级分类');
     * 'para2_level4', '四级分类');
     */
    protected $fillable = [
        'para2_kucun',
        'para2_jiage',
        'pid',
        'gid',
        'name'

    ];

    public function rules(){
        return [
            'create'=>[

            ],
            'update'=>[

            ]
        ];
    }


}
?>