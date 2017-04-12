<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActiceTable extends Migration
{
    /**
     * Run the migrations.
     * user_id
     * sort_id
     * writer
     * title
     * content
     * @return void
     */
    public function up()
    {
        Schema::create('actice',function(Blueprint $table){
            $table->increments('id');
            $table->integer('user_id')->commit('操作人');
            $table->integer('sort_id')->commit('分类id');
            $table->char('writer',20)->commit('作者');
            $table->string('title',50)->commit('标题');
            $table->longText('content')->commit('内容');
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
        Schema::drop('actice');
    }
}
