<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessageRecordTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     *@用户，事件执行人（user_id）,被通知用户（remind_name），涉及的动态id(userdynamics_id)，点赞与评论点赞
     * 评论动态与回复评论时，所用到字段（puser_id,评论，回复转发需要的用户字段）share_id评论id(获取评论内容),
     * 回复评论时还需获取所回复的评论的内容，及用户信息
     * 消息状态record_status（0未读，1已读）
     */
    public function up()
    {
        Schema::create('message_record', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->index()->commit('事件用户id');
            $table->string('remind_name',20)->nullable()->commit('消息提醒用户昵称，@用户');
            $table->integer('userdynamics_id')->index()->commit('动态id');
            $table->integer('record_type')->commit('提醒消息属性（0发表动态，评论点赞,点赞1，转发2，评论3，回复4，,关注6');
            $table->integer('puser_id')->nullable()->index()->commit('评论，回复，转发，所需要的用户id');
            $table->integer('share_id')->nullable()->commit('评论id');
            $table->integer('reply_id')->nullable()->commit('所回复的评论的id');
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
