<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentTable extends Migration
{
    /**
     * Run the migrations.
     *  评论表
     *  评论id，评论内容，
     * @return void
     */
    public function up()
    {
        Schema::create('comment',function(Blueprint $table){
            $table->increments('id');
            $table->integer('dynamics')->nullable()->commit('评论id');
            $table->string('dynamics_content',250)->nullable()->commit('评论内容');
            $table->string('remind_friend',150)->nullable()->commit('提醒好友');
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
        Schema::drop('comment');
    }
}
