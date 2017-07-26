<?php

namespace App\Models;
use Eloquent;
class Comments_share extends Eloquent
{
    /**
     * 评论点赞表
    */
    protected $table="comment_share";

    protected $fillable=[
        'user_id',
        'userdynamics_id',
        'comment_id',
    ];

    public function rules(){
        return [
            'create'=>[
                'userdynamics_id'=>'required',
                'comment_id'=>'required'
            ],
        ];
    }
}
