<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserattentionTable extends Migration
{
    /**
     * Run the migrations.
     * 关注好友表（好友关系表）
     * @return void
     */
    public function up()
    {
        Schema::create('userattention', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->commit('用户id');
            $table->integer('attention_userid')->commit('被关注的用户id');
            $table->tinyInteger('status')->default(0)->commit('状态');
            //自动维护时间
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
        Schema::drop('userattention');
    }
}
