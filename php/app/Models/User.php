<?php

namespace App\Models;

use Hash;
use Eloquent;
use App\Models\AclRole;
use App\Models\AclResource;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

/**
 * 用户数据模型
 *
 * Class User
 * @package App\Models
 *
 * @author  fengqi <lyf362345@gmail.com>
 * @copyright Copyright (c) 2015 udpower.cn all rights reserved.
 */
class User extends Eloquent implements AuthenticatableContract, CanResetPasswordContract
{

    use Authenticatable, CanResetPassword,SoftDeletes;

    /**
     * 自定模块名
     */
    const MODEL = 'user';

    /**
     * The database table used by the model.
     *
     * @var string
     */

    protected $table = 'user';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'type',
        'password',
        'email',
        'avatar',
        'role',
        'nickname',
        'gender',
        'phone',
        'wechat',
        'height',
        'birthday',
        'bady_age',
        'location',
        'qq',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * 锁定用户
     */
    const LOCK = 1;

    /**
     * 解锁用户
     */
    const UNLOCK = 0;

    static public function boot()
    {
        User::observe(new UserObserver());
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     * 用户表副表
     */
    public function bell_user(){

        return $this->hasOne(Bell_user::class);

    }

    /**
     * 数据验证规则
     *
     * @return array
     */
    public function rules()
    {
        return [
            'create' => [
                'name' => "required|min:3|max:100|unique:".$this->getTable(),
                'password' => 'required|confirmed:confirm_password',
            ],
            'update' => [
                'name' => "required|min:3|max:100|unique:".$this->getTable().",name,".$this->id,
            ],
            'manager' => [
                'name' => 'required|max:100|unique:'.$this->getTable(),
                'password' => 'required',
               /* 'real_name' => 'required|max:30',
                'phone' => 'required',
                'email' => 'required|email|unique:'.$this->getTable(),*/
            ]
        ];
    }

    /**
     * 自动把明文的密码 进行 hash 处理
     *
     * @param $password
     *
     * @return string
     */
    public function setPasswordAttribute($password)
    {
        if (!$password) {
            unset($this->attributes['password']);
            return true;
        }

        return $this->attributes['password'] = Hash::make($password);
    }

    /**
     * 自动把两个身份证图片的 md5 序列化
     *
     * @param $identity_card_file
     *
     * @return string
     */
    public function setIdentityCardFileAttribute($identity_card_file)
    {
        return $this->attributes['identity_card_file'] = json_encode($identity_card_file);
    }

    /**
     * 读取用户身份证扫描图片时, 自动反序列化
     *
     * @param $identity_card_file
     *
     * @return mixed
     */
    public function getIdentityCardFileAttribute($identity_card_file)
    {
        $file = json_decode($identity_card_file);

        return !is_array($file) ? [] : $file;
    }

    /**
     * 定义用户与 登录记录 的一对多关系
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function loginHistory()
    {
        return $this->hasMany(\App\Models\UserHistory::class);
    }

    /**
     * 用户角色 0：加盟店，1：代理商，2：仓管 4:财务 5:招商 99:微商
     *
     * @return mixed
     */
    public function role()
    {
        return (new AclRole)->role2text($this->role);
    }

    /**
     * 定义于 创建者 的关联关系
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function createdBy()
    {
        return $this->belongsTo(self::class, 'created_by', 'id');
    }

    /**
     * 定义与 他创建的用户 的一对多关系
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function createdAll()
    {
        return $this->hasMany(self::class, 'created_by', 'id');
    }

    /**
     * 返回模块名
     *
     * @return string
     */
    public function getModelName()
    {
        return self::MODEL;
    }

    /**
     * 支付通知, 提供给支付模块使用
     *
     * @param $user_id
     * @param $status
     *
     * @return bool
     */
    static public function paymentNotify($user_id, $status)
    {
        // todo
        return true;
    }

    public function access()
    {
        return $this->hasMany(\App\Models\AclRole::class, 'role', $this->role);
    }

    /**
     * 返回用户的 acl, 经过处理的
     *
     * @return array
     */
    public function getACL()
    {
        $acl = $this->access()->get(['resource'])->keyBy('resource');

        return array_keys($acl->toArray());
    }

    public function shipAddress()
    {
        return $this->hasMany(\App\Models\ShipAddress::class);
    }
}
