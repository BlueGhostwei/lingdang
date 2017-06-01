<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBellUserTable extends Migration
{
    /**
     * Run the migrations.
     * user_id用户id
     * integral 积分
     * birthday 生日
     * remind 提醒生日
     * signature 个性签名
     * @return void
     */
    public function up()
    {
        Schema::create('bell_user',function(Blueprint $table){
            $table->increments('id');
            $table->integer('user_id')->index()->commit('用户id');
            $table->tinyInteger('remind')->default(0)->commit('是否提醒生日,0为是，1为否，默认为0');
            $table->string('integral')->default(0)->commit('积分');
            $table->string('fans',225)->default(0)->commit('粉丝量');
            $table->string('attention',225)->default(0)->commit('关注量');
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
        Schema::drop('bell_user');
    }
}
