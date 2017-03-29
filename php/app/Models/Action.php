<?php

namespace App\Models;

use Eloquent;

/**
 * 动作 数据模型
 *
 * Class  Action
 * @package App\Models
 *
 * @author  fengqi <lyf362345@gmail.com>
 * @copyright Copyright (c) 2015 udpower.cn all rights reserved.
 */
class Action extends Eloquent
{
    /**
     * 表名
     *
     * @var string
     */
    protected $table = 'action';

    /**
     * 自动维护更新和创建时间
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * 不能被批量赋值的属性, $guarded 与 $fillable 只能选其一
     *
     * @var array
     */
    protected $fillable = [
        'model',
        'result_id',
        'user_id',
        'action',
        'description'
    ];

    const REGISTER = '注册';
    const LOGIN = '登录';
    const LOGOUT = '退出登录';
    const CREATE = '创建';
    const UPDATE = '编辑';
    const DESTROY = '删除';
    const RESTORE = '恢复';
    const USAGE = '使用';
    const READ = '阅读';
    const MARK = '标记';
    const SENT = '发送';
    const JOIN = '加入';
    const DETACH = '移出';
    const FROM = '从';
    const TO = '到';
    const EXAMINE = '审核';
    const FAVORITE = '收藏';
    const LIKE = '喜欢';
    const HOTS = '热门';
    const SWITCHING = '切换';
    const ADMIN = '管理员';
    const REPLY = '回复';
    const BATCH = '批量操作';
    const PAYMENT = '付款';
    const ORDER = '下单';

    /**
     * 数据验证规则
     *
     * @return array
     */
    public function rules()
    {
        return [
            'create' => [],
        ];
    }

    /**
     * 返回英文 model 对应的模块名
     *
     * @return string
     */
    public function model()
    {
        // todo
        return 'todo';
    }

    /**
     * 定义与 用户 的关联关系
     * example: $action->user->name
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

}
