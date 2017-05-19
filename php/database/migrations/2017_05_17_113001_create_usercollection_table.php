<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsercollectionTable extends Migration
{
    /**
     * Run the migrations.
     * 收藏，转发表
     * @return void
     */
    public function up()
    {
        Schema::create('collection', function (Blueprint $table) {
            $table->increments('id');
            //用户id
            $table->integer('user_id');
            //好友动态id
            $table->integer('userdynamics_id');
            //属性
            $table->tinyInteger('type')->nullable()->commit('属性，1为转发，2位点赞');
            //自动维护更新时间
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('collection');
    }
}
