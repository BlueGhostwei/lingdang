<?php

namespace App\Models;

use  Eloquent;
use Illuminate\Database\Eloquent\Model;

class Integration extends Eloquent
{
    protected $table = 'Integration';
    /**
     * @var array
     *  'user_id',用户id
     *  'sign_time'签到时间
     */
    protected $fillable = [
        'user_id',
        'sign_time'
    ];

	/**
	*禁止自动更新
	*/
	public $timestamps = false;



}
