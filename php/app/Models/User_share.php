<?php

namespace App\Models;

use Eloquent;

class User_share extends Eloquent
{

    protected  $table="user_share";

    protected  $fillable=[
        'userdynamics_id',
        'user_id',
        'pid',
        'share_content',
        'share_pic'
    ];

    public function rules(){
        return [
            'create'=>[
                "user_id"=>'required',
                "share_content"=>'required',
                'userdynamics_id'=>'required'
            ],
        ];
    }

    


}
