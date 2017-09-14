<?php

namespace App\Models;
use App\Models\Goods;
use Illuminate\Database\Eloquent\Model;

class Goods_standard extends Model
{
    public  $timestamps =false;

    protected $table="goods_standard";

    protected $fillable=[
        'goods_id',
        'attributes_id',
        'price',
        'stock',
    ];
    public  function rules(){
          return [
              'create'=>[
                  'goods_id'=>'required',
                  'attributes_id'=>'required',
                  'price'=>'required',
                  'stock'=>'required',
              ],
          ];
    }

    public function  SelectGood(){
      return  $this->hasOne(Goods::class,'good_id');
    }



}
