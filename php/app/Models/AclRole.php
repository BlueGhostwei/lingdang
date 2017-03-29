<?php

namespace App\Models;

use Eloquent;
use App\Models\AclUser;

/**
 * 角色
 *
 * Class AclRole
 * @package App\Models
 *
 * @author  fengqi <lyf362345@gmail.com>
 * @copyright Copyright (c) 2015 udpower.cn all rights reserved.
 */
class AclRole extends Eloquent
{
    /**
     * 角色 99:xx 5:xxxx  4:记者 0: 超级管理员, 2：小编，1：xx, 3：主编，
     * 涉及表有user,acl_role
     */
    /*const ROLE_WECHATMAN = 99;
const ROLE_MERCHANTS = 5;*/
    /*const ROLE_AGENT = 1;*/
    const ROLE_FINANCIAL = 4;
    const ROLE_ADMIN = 1;
    const ROLE_MANAGER = 2;
    const ROLE_LEAGUE = 3;

    /**
     * 表名
     *
     * @var string
     */
    protected $table = 'acl_role';

    /**
     * 不自动维护更新创建时间
     *
     * @var boolean
     */
    public $timestamps = false;

    /**
     * 不能被批量赋值的属性　, 与 $fillable 只能选其一
     *
     * @var array
     */
    protected $fillable = ['name', 'level', 'resource'];

    public function accessCount()
    {
        return $this->where('name', $this->name)->count();
    }

    public function getRole()
    {

        $role_data = AclUser::orderBy('id','desc')->get()->toArray();

        $role = array();
        foreach($role_data as $k => $v){
            $role[] = $v['id'];
        }

        /*$role = [
            self::ROLE_MANAGER,
            self::ROLE_LEAGUE,
            self::ROLE_ADMIN,
            self::ROLE_FINANCIAL];
        arsort($role);
        dd($role);*/

        return $role;
    }

    public function role2text($role)
    {
        $role_data = AclUser::orderBy('id','desc')->select('id','acl_name')->get()->toArray();

        $id_arr = array();
        $user_arr = array();
        foreach($role_data as $k => $v) {

            $id_arr[] = $v['id'];
            $user_arr[] = $v['acl_name'];
        }
        $new_arr = array_combine($id_arr,$user_arr);

        if (!in_array($role, $id_arr)
        ) {
            return '';
        }


        return $new_arr[$role];
    }
}
