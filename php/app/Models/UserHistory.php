<?php

namespace App\Models;

use Eloquent;
use Input;

/**
 * 用户登录数据模型
 *
 * Class UserHistory
 * @package App\Models
 *
 * @author  fengqi <lyf362345@gmail.com>
 * @copyright Copyright (c) 2015 udpower.cn all rights reserved.
 */
class UserHistory extends Eloquent
{
    /**
     * 表名
     *
     * @var string
     */
    protected $table = 'user_history';

    /**
     * 不能被批量赋值的属性, 与 $fillable 只能选其一
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * 定于与 User 的关联关系
     * 获取历史记录对应的用户, example: $UserHistory->user->name
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
      //dd(Input::all());
        return $this->belongsTo(User::class);
    }

    /**
     * 在入库前, 把 ip 转为整型
     *
     * @param $ip
     *
     * @return int
     */
    public function setIpAttribute($ip)
    {
        //dd($ip);
        return $this->attributes['ip'] = ip2long($ip);
    }

    /**
     * 从库里读取 ip 的时候把整型还原为 ip
     *
     * @param $ip
     *
     * @return string
     */
    public function getIpAttribute($ip)
    {
        return long2ip($ip);
    }

}
