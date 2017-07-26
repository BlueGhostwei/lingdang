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
            $table->string('img_photo',500)->nullable()->commit('图片');
            $table->string('remind_friend',150)->nullable()->commit('提醒好友');
            $table->integer('Authority')->default(0)->commit('动态权限，0为公开，1为朋友可见，2仅自己可见');
            $table->string('content',500)->nullable()->commit('内容');
            $table->string('topic',50)->nullable()->commit('话题');
            $table->integer('read_amount')->default(0)->commit('阅读数');
            $table->integer('comment_num')->default(0)->commit('评论数');
            $table->integer('send_out_num')->default(0)->commit('转发数');
            $table->integer('like_num')->default(0)->commit('点赞数');
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
