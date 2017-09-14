<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class Order extends Model
{
    protected  $table='order';

    protected  $fillable=[
        'user_id',
        'order_id',
        'order_price',
        'address',
        'status'
    ];

    public function rules(){
        return [
            'create'=>[
                'order_id'=>'required',
            ],
        ];

    }
    
    public function GetOrderInfo(){

        return $this->hasOne(Order_goods_info::class,'order_id');
    }
}
