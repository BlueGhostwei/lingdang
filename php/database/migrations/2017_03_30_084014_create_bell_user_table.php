<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBellUserTable extends Migration
{
    /**
     * Run the migrations.
     * 'ma_avatar',妈妈的头像
     * 'fa_avatar',爸爸的头像
     * 'baby_id',宝贝id
     * 'integral',用户积分
     *  nickname 昵称
     *  signature 个性签名
     *  gender 性别
     *  location 所在地
     * @return void
     */
    public function up()
    {
        Schema::create('bell_user',function(Blueprint $table){
            $table->increments('id');
            $table->integer('user_id')->index()->commit('用户id');
            $table->string('ma_avatar',225)->nullable()->commit('mather头像');
            $table->string('fa_avatar',225)->nullable()->commit('father头像');
            $table->integer('baby_id')->nullable()->commit('宝贝id');
            $table->string('integral')->default(0)->commit('用户积分');
            $table->string('signature',225)->nullable()->commit('个性签名');
            $table->tinyInteger('gender')->default(0)->commit('性别 0男，1女');
            $table->string('location',225)->nullable()->commit('用户所在地');
            $table->string('fans',225)->default(0)->commit('粉丝量');
            $table->string('attention',225)->default(0)->commit('关注量');
            $table->timestamps();
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
        Schema::drop('bell_user');
    }
}
