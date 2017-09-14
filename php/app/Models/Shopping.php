<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Eloquent;
class Shopping extends Eloquent
{
    //
    protected $table = "Shopping";
    protected $fillable = [
        'gid',//商品的id
        'user_id',//用户id
		'specif',//规格
        'scount',//数量
		'brand_id',

    ];




}
