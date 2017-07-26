<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateForwardTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forward',function(Blueprint $table){
            $table->increments('id');
            $table->integer('user_id')->nullable()->commit('转发的用户id');
            $table->integer('userdynamics_id')->index()->commit('转发动态id');
            $table->string('forward_content',50)->nullable()->commit('转发动态id');
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
        Schema::drop('forward');
    }
}
