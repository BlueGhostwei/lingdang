<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use  Eloquent;
class Collection extends Eloquent
{
    //收藏，转发表
    /**
     * @var string
     *表名称
     */
    protected  $table="collection";

    /**
     * @var array
     * 验证数据完整性
     */
    protected $fillable=[
        'userdynamics_id',
        'user_id',
        'type'
    ];
    public function rules(){
        return [
            'create'=>[

            ],
        ];
    }
}
