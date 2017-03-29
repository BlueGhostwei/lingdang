<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAclResourceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('acl_resource', function (Blueprint $table) {
            // 主键
            $table->increments('id');

            // 功能名称
            $table->string('name', 50);

            // 功能下的 action, 多个时序列化存储, 格式: namespace::controller@action
            $table->string('action', 100);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('acl_resource');
    }
}
