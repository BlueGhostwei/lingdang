<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {
        Schema::create('user', function (Blueprint $table) {
            // 主键, 自增, 用户 id
            $table->increments('id');

            // 用户名, 唯一
            $table->string('name', 100)->unique();

            // 邮箱, 唯一
            $table->string('email', 100)->nullable();

            // 密码, hash 值
            $table->string('password', 60);

            //用户类型
            $table->string('type', 15)->nullable()->commit('用户类型');

            // 邮箱验证状态, 0 或 1
            $table->tinyInteger('email_validate')->unsigned()->default(0);

            // 头像图片的 md5, 35位
            $table->char('avatar', 35)->nullable();

            // 真实姓名
            $table->string('real_name', 30)->nullable();

            // 性别 0女, 1男
            $table->tinyInteger('gender')->default(1);


            // 移动电话, 固话
            $table->string('phone', 20)->nullable();

            // 微信号
            $table->string('wechat', 20)->nullable();

            // QQ
            $table->integer('qq')->nullable();

            // 用户角色
            $table->tinyInteger('role')->default(1)->index();

            // 锁定/启动用户
            $table->tinyInteger('lock')->default(0)->index();

            // 记住用户 token
            $table->rememberToken();

            // 创建的管理员
            $table->integer('created_by')->unsigned();

            $table->string('remarks', 100)->nullable();
            // 自动维护的创建修改时间
            $table->timestamps();
            // 软删除
            $table->softDeletes();


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('user');
    }
}
