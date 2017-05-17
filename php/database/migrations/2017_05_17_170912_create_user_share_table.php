<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserShareTable extends Migration
{
    /**
     * Run the migrations.
     * 用户评论表
     * @return void
     */
    public function up()
    {
        Schema::create('user_share', function (Blueprint $table) {
            //主键id
            $table->increments('id');
            $table->integer('user_id')->nullable()->commit('用户id');
            $table->integer('pid')->nullable()->commit('评论回复，容器，回复评论回复');
            $table->string('content',225)->nullable()->commit('评论内容');
            $table->string('share_pic',225)->nullable()->commit('评论图片');
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
        Schema::drop('user_share');
    }
}
