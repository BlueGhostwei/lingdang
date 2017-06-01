<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessageRecordTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('message_record', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->index()->commit('动态提醒用户id');
            $table->integer('userdynamics_id')->index()->commit('动态id');
            $table->integer('record_type')->commit('提醒消息属性（点赞1，转发2，评论3，回复4');
            $table->integer('puser_id')->index()->commit('评论，回复，转发，所需要的用户id');
            $table->string('record_content',50)->nullable()->commit('提示信息');
            $table->tinyInteger('record_status')->default(0)->commit("默认未处理，0 ，1为处理");
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
        Schema::drop('message_record');
    }
}
