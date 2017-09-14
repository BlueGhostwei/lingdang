<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUpdateGoodsTable extends Migration
{
    /**
     * Run the migrations.
     *  'jf_exchange',
    'jf_price',
    'FreeCharge',
    'FreeCharge_num'
     * @return void
     */
    public function up()
    {
        Schema::table('goods',function($table){
             $table->integer('jf_price')->nullable()->commit('积分兑换基数');
             $table->tinyInteger('jf_exchange')->default(0)->commit('是否加入积分兑换,0为否，1为是');
             $table->integer('FreeCharge_num')->default(0)->commit('免单个数');
             $table->tinyInteger('FreeCharge')->default(0)->commit('是否加入免单活动,0为否，1为是');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sort',function(Blueprint $table){
            $table->dropColumn('jf_price');
            $table->dropColumn('jf_exchange');
            $table->dropColumn('FreeCharge_num');
            $table->dropColumn('FreeCharge');
        });
    }
}
