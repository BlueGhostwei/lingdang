<?php

namespace App\Models;

use  Eloquent;
use Illuminate\Database\Eloquent\Model;

class Baby extends Eloquent
{
    protected $table = 'baby_table';

    /**
     * @var array
     * gender 性别
     *  'bady_name',宝宝名字
     * 'bady_avatar',宝宝头像
     * body_weight 体重
     * birthday 生日
     * remind 是否提醒生日
     */
    protected $fillable = [
        'nickname',
        'height',
        'gender',
        'name',
        'avatar',
        'weight',
        'birthday',
        'remind',
        'bady_age'
    ];

    public function rules()
    {
        return [
            'create' => [
                'gender' => "required",
                'name' => 'required',
                'avatar' => 'required',
                'weight' => 'required',
                'birthday' => 'required',
            ],
        ];
    }


}
