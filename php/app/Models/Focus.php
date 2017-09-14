<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Eloquent;

class Focus extends Eloquent
{
    protected $table = "focus";
    protected $fillable = [
		'user_id',  
        'other',		
	    'cid',
	    'rid',
	    'rname',
	    'rtmpPullUrl',
		'pushUrl',
		'like',
	  
	   

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