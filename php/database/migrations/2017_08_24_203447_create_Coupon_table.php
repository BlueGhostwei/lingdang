<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCouponTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupon',function(Blueprint $table){
            $table->increments('id');
            $table->string('name',50)->nullable()->commit('商品优惠券名称');
            $table->integer('money')->commit('优惠券面额');
            $table->integer('condition')->commit('消费金额');
            $table->integer('createnum')->commit('发放数量');
            $table->tinyInteger('type')->default(0)->nullable()->commit('发放类型');
            $table->timestamp('send_start_time')->nullable()->commit('发放时间');
            $table->timestamp('send_end_time')->nullable()->commit('发放结束时间');
            $table->timestamp('use_start_time')->nullable()->commit('使用起始时间');
            $table->timestamp('use_end_time')->nullable()->commit('使用结束时间');
            $table->integer('release')->default(0)->commit('已发放');
            $table->integer('used')->default(0)->commit('已使用');
            $table->tinyInteger('status')->nullable()->commit('状态');
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
        Schema::drop('coupon');
    }
}
