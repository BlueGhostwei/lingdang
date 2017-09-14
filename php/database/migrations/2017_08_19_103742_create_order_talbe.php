<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderTalbe extends Migration
{
    /**
     * Run the migrations.
     *
     *  添加买单活动商品是否为免单活动商品
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order', function (Blueprint $table) {
            $table->increments('id');
            $table->string('order_id',20)->index()->unique()->commit('订单号');
            $table->tinyInteger('paymethod')->nullable()->commit('支付方式');
            $table->integer('user_id')->commit('用户id');
            $table->integer('order_price')->commit('订单价格');
            $table->string('remark',100)->nullable()->commit('备注');
            $table->integer('address')->nullable()->commit('收货地址');
            $table->integer('status')->default(0)->commit('订单状态，0为未支付，1已支付待发货，2已支付已发货,3已发货已收货,4退货');
			$table->integer('eval')->default(0)->commit('是否评价');
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
        Schema::drop('order');
    }
}
