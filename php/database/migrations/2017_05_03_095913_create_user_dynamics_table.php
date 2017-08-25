<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserDynamicsTable extends Migration
{
    /**
     * Run the migrations.
     * 好友动态表
     * @return void
     */
    public function up()
    {
        Schema::create('userdynamics',function(Blueprint $table){
            $table->increments('id');
            $table->integer('user_id')->commit('用户id');
            $table->string('img_photo',225)->nullable()->commit('图片');
            $table->string('remind_friend',150)->nullable()->commit('提醒好友');
            $table->string('content',500)->nullable()->commit('内容');
            $table->integer('comment_num')->nullable()->commit('评论数');
            $table->integer('send_out_num')->nullable()->commit('转发数');
            $table->integer('like_num')->nullable()->commit('点赞数');
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
        Schema::drop('userdynamics');
    }
}
