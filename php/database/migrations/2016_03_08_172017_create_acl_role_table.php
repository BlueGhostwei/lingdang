<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAclRoleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('acl_role', function (Blueprint $table) {
            // 主键, 自增, id
            $table->increments('id');
            //所属权限
            $table->tinyInteger('role')->nullable();
            //用户ID
            $table->integer('user_id')->nullable();
            //所属角色权限
            $table->integer('p_role_id')->nullable();
            //拥有权限
            $table->string('resource',100);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('acl_role');
    }
}
