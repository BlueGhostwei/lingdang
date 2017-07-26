<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTopicCombinationTable extends Migration
{
    /**
     * Run the migrations.
     * 话题
     * @return void
     */
    public function up()
    {
        Schema::create('topic_combination',function(Blueprint $table){
            $table->increments('id');
            $table->integer('user_id')->nullable()->commit('用户id');
            $table->string('topic_name',50)->nullable()->commit('话题');
            $table->string('topic_photo',100)->commit('动态id');
            $table->integer('read_amount')->default(0)->commit('阅读数');
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
        Schema::drop('topic_combination');
    }
}
