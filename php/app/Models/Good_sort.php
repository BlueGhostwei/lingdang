<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Model;

class Good_sort extends Eloquent
{
    /**
     *处理商品分类。
     * 添加，修改，删除
     */

    protected $table = 'sort';
    protected $fillable = [
        'name',
        'pid'
    ];

}
