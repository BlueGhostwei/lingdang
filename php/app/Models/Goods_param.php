<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Goods_param extends Model
{
    public $timestamps=false;

    protected  $table='goods_param';

    protected  $fillable=[
        'goods_id',
        'key',
        'vel'
    ];


}
