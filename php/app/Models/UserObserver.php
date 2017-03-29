<?php

namespace App\Models;

class UserObserver
{
    public function creating($model)
    {
        // 用户默认身份,可去除
        if (!isset($model->role)) {
            $model->role = AclRole::ROLE_LEAGUE;
        }
        return $model;
    }

}
