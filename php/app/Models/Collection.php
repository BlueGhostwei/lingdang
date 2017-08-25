<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use  Eloquent;
class Collection extends Eloquent
{

    
    /**
     * @var string
     *表名称 收藏，转发表
     */
    protected  $table="collection";

    /**
     * @var array
     * 验证数据完整性
     * type 1为转发，2位收藏
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
