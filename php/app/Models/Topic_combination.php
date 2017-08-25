<?php

namespace App\Models;
use Eloquent;

class Topic_combination extends Eloquent
{
    protected  $table='topic_combination';


    /**
     * @var array
     * topic_name 话题名称
     * read_amount 阅读数
     * userdynamics_id 动态id
     */
    protected $fillable=[
        'topic_name',
        'read_amount'
    ];
}
