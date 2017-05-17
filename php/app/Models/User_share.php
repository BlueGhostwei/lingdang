<?php

namespace App\Models;

use Eloquent;

class User_share extends Eloquent
{

    protected  $table="user_share";

    protected  $fillable=[
        'user_id',
        'pid',
        'content',
        'share_pic'
    ];

    public function rules(){
        return [
            'create'=>[
                "user_id"=>'required',
                "content"=>'required|mix:1',
                "pid"=>'required',
            ],
        ];
    }


}
