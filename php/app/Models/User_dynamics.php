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
	    'pid',
        'user_id',
        'content',
        'img_photo',
		'topic',
        'remind_friend',
        'Authority',
		'comment_num',
        'send_out_num',
        'like_num'
       
    ];

    public function rules(){
        return [
            'create'=>[
                'content'=>'required',
            ],
        ];
    }

}
