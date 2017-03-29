<?php
/**
 * An helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * 权限点
 * 
 * Class AclResource
 *
 * @package App\Models
 * @author fengqi <lyf362345@gmail.com>
 * @copyright Copyright (c) 2015 udpower.cn all rights reserved.
 * @property integer $id
 * @property string $name
 * @property string $action
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AclResource whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AclResource whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AclResource whereAction($value)
 */
	class AclResource {}
}

namespace App\models{
/**
 * 角色
 * 
 * Class AclRole
 *
 * @package App\Models
 * @author fengqi <lyf362345@gmail.com>
 * @copyright Copyright (c) 2015 udpower.cn all rights reserved.
 * @property integer $id
 * @property boolean $role
 * @property string $resource
 * @method static \Illuminate\Database\Query\Builder|\App\models\AclRole whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\models\AclRole whereRole($value)
 * @method static \Illuminate\Database\Query\Builder|\App\models\AclRole whereResource($value)
 */
	class AclRole {}
}

namespace App\models{
/**
 * App\models\AclUser
 *
 */
	class AclUser {}
}

namespace App{
/**
 * App\User
 *
 */
	class User {}
}

