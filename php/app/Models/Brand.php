<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Model;

class Brand extends Eloquent
{

    /**
     * @var string
     * 表名称
     */
    protected  $table='brand';
    /**
     * @var bool
     * 关闭自动维护时间
     */
    public $timestamps = false;
    /**
     * @var array
     * 数据完整性
     */
    protected  $fillable=[
        'user_id',
        'sort_id',
        'brand_name',
        'brand_num'
    ];

    /**
     * @return array
     * 数据验证规则
     */
    public  function  rules(){
        return [
            'create'=>[
                'sort_id'=>"required",
                'brand_name'=>"required|min:2|unique:".$this->getTable(),
            ]
        ];
    }

}
