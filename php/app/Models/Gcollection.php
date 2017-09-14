<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Eloquent;
class Gcollection extends Eloquent
{
    //
    protected $table = "gcollection";
    protected $fillable = [
        'goodid',//商品的id
        'usersid',//用户id

    ];
    /**
     * 定义与 商品 的关联关系
     * example: $action->user->name
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function coll()
    {
        return $this->belongsTo('\App\Models\Goods','id','goodid');
    }



}
