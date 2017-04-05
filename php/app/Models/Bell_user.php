<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Model;

class Bell_user extends Eloquent
{

    /**
     * @var string
     * 宝贝用户表
     *
     */
    protected $table = "bell_user";
    /**
     * @var array
     * 验证数据完整性
     * 'user_mobile',用户号码
     * 'ma_avatar',妈妈的头像
     * 'fa_avatar',爸爸的头像
     * 'baby_id',宝贝id
     * 'integral',用户积分
     *  nickname 昵称
     *  signature 个性签名
     *  gender 性别
     *  location 所在地
     */
    protected $fillable = [
        'user_mobile',
        'ma_avatar',
        'fa_avatar',
        'baby_id',
        'integral',
        'nickname',
        'signature',
        'gender',
        'location'
    ];

    public function rules()
    {
        return [
            'create' => [
                'user_mobile' => "required|min:3|max:100|unique:".$this->getTable(),
                'password' => 'required|min:6|max:12',
            ],
        ];
    }

    
}
