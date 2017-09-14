<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Eloquent;

class Anchor extends Eloquent
{
    protected $table = "anchor";
    protected $fillable = [
        'user_id',
        'roomid',
        'themename',
        'number',
        'like',
		'keyword',
		'whether',

    ];
    public function rules(){
        return [
            'create'=>[
               // 'uid'=>'required',
			
            ],
            'update'=>[
               // 'uid'=>'required',

            ]
        ];
    }



}
