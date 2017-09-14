<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order_goods_info extends Model
{
    public $timestamps=false;
    protected $table='order_goods_info';
    protected  $fillable=[
        'order_id',
        'goods_id',
        'specif',
        'brand_id',
        'goods_name',
        'goods_num',
    ];
    public function belongsToOder()
    {
        return $this->belongsTo(Order::class,'order_id');
    }
}
