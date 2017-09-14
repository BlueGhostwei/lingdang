<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_goods_info',function(Blueprint $table){
            $table->string('order_id',20)->commit('订单号');
            $table->integer('goods_id')->commit('商品ID');
            $table->string('specif',20)->commit('商品规格');
            $table->integer('brand_id')->commit('商品品牌');
			$table->integer('geval')->default(0)->commit('商品是否评价');
            $table->integer('goods_num')->default(0)->commit('购买数量');
            $table->string('goods_name')->nullable()->commit('商品名称');
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('order_goods_info');
    }
}
