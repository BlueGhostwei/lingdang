<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Eloquent;

class Message_record extends Eloquent
{
    protected $table="message_record";

    /**
     * @var array
     * 提醒的用户id，
     * 动态id
     * 提醒消息属性（点赞1，转发2，评论3，回复4）
     */
    protected $fillable=[
        'user_id',
        'remind_name',
        'record_type',
        'record_status',
        'record_content',
        'puser_id',
        'share_id',
        'reply_id',
        'userdynamics_id'
    ];

    public function rules(){
        return [
          'create'=>[
              'userdynamics_id'=>'required',
          ],
        ];
    }
}
