<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsShareTable extends Migration
{
    /**
     * Run the migrations.
     * 评论点赞表
     * 所需字段
     * 动态id，当前评论id，用户id,
     * @return void
     */
    public function up()
    {
        Schema::create('comment_share',function(Blueprint $table){
            //主键id
            $table->increments('id');
            $table->integer('user_id')->commit('点赞用户');
            $table->integer('userdynamics_id')->commit('动态id');
            $table->integer('comment_id')->commit('评论id');
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
        Schema::drop('comment_share');
    }
}
