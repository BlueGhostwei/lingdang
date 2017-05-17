<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddBellTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bell_user',function($table){
            $table->integer('sign_sta')->default(0)->after('remind')->commit('连续签到统计，时间间隔一天清零');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bell_user',function(Blueprint $table){
           $table->dropColumn('sign_sta');
        });
    }
}
