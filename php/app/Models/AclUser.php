<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Model;

class AclUser extends Eloquent
{
    //acl_user
    protected $table = 'acl_user';

    /**
     * 用户角色
     *
     * @var bool
     */
    //public $timestamps = true;

    /**
     * 不能被批量赋值的属性, $guarded 与 $fillable 只能选其一
     *
     * @var array
     */
    protected $fillable = [
        'acl_name'
    ];






}
