<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoodsStandardTable extends Migration
{ /**
 * Run the migrations.
 *
 * @return void
 */
    public function up()
    {
        Schema::create('goods_standard',function(Blueprint $table){
            $table->increments('id');
            $table->integer('goods_id')->index()->nullable()->commit('商品id');
            $table->string('attributes_id',200)->nullable()->commit('分类id');
            $table->string('price',20)->nullable()->commit('价格');
            $table->integer('stock')->nullable()->commit('库存');
        });
    }
    /**
     * Reverse the migrations.
     *
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('good_standard');
    }
}
