<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/21
 * Time: 10:21
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Eloquent;

class Dgoods extends Eloquent
{
    protected $table = "dgoods";

    /**
     * @var array
     * gid('商品id');
     * uid' '用户的id');
     * 'dsize''商品的尺寸');
     * 'dimg','评价的图片');
     * 'dcolor', '颜色');
     * 'dcount', '评价条数');
     * 'dcontent' '商品评价内容');
     */
    protected $fillable = [
        'gid',
        'uid',
        'dimg',
        'dcount',
        'dcontent',

    ];

}
?>