<?php

namespace App\Models;
use App\Models\Sort;
use Illuminate\Database\Eloquent\Model;

class Attributes extends Model
{
    protected  $table="attributes";

    protected  $fillable=[
        'pid',
        'sort_id',
        'arr_name',
        'store_num'
    ];
    public function rules(){
        return [
            "create"=>[
                'sort_id'=>"required",
                'arr_name'=>"required"
            ]
        ];
    }

    public function SetSortName()
    {
          return $this->hasOne(Sort::class,'id');
    }
}
