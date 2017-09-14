<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    /**
     *table表名称
     */
    protected  $table='coupon';

    /**
     * @var array
     *
     */
    protected $fillable=[
         'name',
         'money',
         'condition',
         'createnum',
         'type',
         'send_start_time',
         'send_end_time',
         'use_start_time',
         'use_end_time',
         'release',
         'used',
         'status',
    ];

    public function rules(){
      return [
          'create'=>[
               'name'=>'required|min:3',
               'condition'=>'required',
               'createnum'=>'required',
               'type'=>'required',
               'send_start_time'=>'required',
               'send_end_time'=>'required',
               'use_start_time'=>'required',
               'use_end_time'=>'required',
               'status'=>'required',
          ],
      ];
    }
}
