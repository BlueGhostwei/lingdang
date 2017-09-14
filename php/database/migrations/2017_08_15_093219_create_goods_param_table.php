<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoodsParamTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goods_param',function(Blueprint $table){
            $table->integer('goods_id')->index()->commit('商品id');
            $table->string('key',20)->nullable()->commit('商品参数key');
            $table->string('vel',50)->nullable()->commit('商品参数vey');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('goods_param');
    }
}
