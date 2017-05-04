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
