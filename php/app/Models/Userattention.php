<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Model;

class Userattention extends Eloquent
{
    /**
     * @var string
     * 表名称
     */
    protected $table='userattention';
    /**
     * @var array
     *
     */
    protected $fillable=[
        'user_id',
        'attention_userid',
        'status'
    ];

    /**
     * @return array
     *
     */
    public  function  rules(){
        return [
          'create'=>[
              'user_id'=>'required',
              'attention_userid'=>'required',
              'status'=>'required'
          ],
        ];
    }
}
