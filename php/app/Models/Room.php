<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Eloquent;

class Room extends Eloquent
{
    protected $table = "room";
    protected $fillable = [
		'user_id',      
	    'cid',
	    'rid',
	    'rname',
	    'rtmpPullUrl',
		'pushUrl',
	    'msg',
	    'ctime',
	    'status',
	    'type',
		'themename',
		'keyword',
		'number',
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