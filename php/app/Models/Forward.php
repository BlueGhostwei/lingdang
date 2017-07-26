<?php

namespace App\Models;

use Eloquent;
class Forward extends Eloquent
{
    protected  $table='forward';
    protected  $fillable=[
        'user_id',
        'userdynamics_id',
        'forward_content'
    ];
    public function rules(){
        return [
            'create'=>[
                'user_id'=>'required',
                'userdynamics_id'=>'required',
                'forward_content'=>'required'
            ],
        ];
    }

    public function forward_dynamisc(){

      return $this->belongsTo(\App\Models\User_dynamics::class,'id');

    }

}
