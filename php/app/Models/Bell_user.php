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
     * user_id 对应用户表id
     * integral 积分
     * remind 提醒生日
     * fans 粉丝量
     * attention 关注量
     * signature 个性签名
     */
    protected $fillable = [
        'user_id',
        'integral',
        'remind',
        'fans',
        'attention',
        'signature',
    ];

    public function rules()
    {
        return [
            'create' => [
                'name' => "required|min:3|max:100|unique:" . $this->getTable(),
                'password' => 'required|min:6|max:12',
            ],
        ];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * 关联用户表
     */
    public function belongsToUser()
    {

        return $this->belongsTo(User::class);

    }


}
