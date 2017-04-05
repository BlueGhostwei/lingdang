<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIntegrationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Integration',function(Blueprint $table){
            // 主键 id
            $table->increments('id');
            $table->integer('user_id')->commit('用户id');
            $table->timestamp('sign_time')->commit('签到时间');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('Integration');
    }
}
