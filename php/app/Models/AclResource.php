<?php

namespace App\Models;

use Eloquent;

/**
 * 权限点
 *
 * Class AclResource
 * @package App\Models
 *
@author  fengqi <lyf362345@gmail.com>
 * @copyright Copyright (c) 2015 udpower.cn all rights reserved.
 */
class AclResource extends Eloquent
{
    /**
     * 表名
     *
     * @var string
     */
    protected $table = 'acl_resource';

    /**
     * 不自动维护更新创建时间
     *
     * @var boolean

    public $timestamps = false;

    /**
     * 不能被批量赋值的属性, 与 $fillable 只能选其一
     *
     * @var array
     */
    protected $fillable = ['name', 'action'];

    public $AclResource = [
        '用户中心' => [
            '用户注册' => ['UserController@getRegister', 'UserController@postRegister'],
            '用户登录' => ['UserController@getLogin', 'UserController@postLogin'],
            '用户退出' => 'UserController@getLogout',
            '我的资料' => ['UserController@my'],
            '查看用户列表' => 'UserController@index',
            '创建用户' => ['UserController@create', 'UserController@store','UserController@show'],
            '修改用户' => ['UserController@edit', 'UserController@update'],
            '删除用户' => 'UserController@destroy',
            '锁定用户' => 'UserController@lock',
            '查看已删除用户列表' => 'UserController@trash',
            '恢复已删除用户' => 'UserController@restore',
        ],
        '权限配置' => [
            '查看权限列表' => 'AclResourceController@index',
            '查看角色列表' => 'AclRoleController@index',
            '创建用户角色'=>'AclUserController@user_role',
            '修改角色权限' => ['AclRoleController@edit', 'AclRoleController@update'],
        ],
        '系统编辑' => [
            '查看系统日志' => 'SystemController@logs',
            '查看操作记录' => 'SystemController@action',
            '查看登录记录' => 'SystemController@loginHistory',
        ]


    ];

    public function getResource()
    {
        return $this->AclResource;
    }
}
