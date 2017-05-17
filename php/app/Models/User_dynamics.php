<?php

namespace App\Models;

use Eloquent;
class User_dynamics extends Eloquent
{
    /**
     * @var string
     * 好友动态表
     */
    protected  $table='userdynamics';
    /**
     * @var array
     * 验证数据完整性
     * 用户id user_id
     * 动态
     */
    protected  $fillable=[
        'user_id',
        'centent',
        'img_photo',
        'remind_friend',
    ];

    public function rules(){
        return [
            'create'=>[
                'centent'=>'required',
            ],
        ];
    }
}
