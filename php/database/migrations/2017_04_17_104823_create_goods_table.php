<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goods',function(Blueprint $table){
            //主键id
            $table->increments('id');
            $table->integer('sort_id')->nullable()->commit('所属分类');
            $table->integer('brand_id')->nullable()->commit('所属类型');
            $table->tinyInteger('goods_sort')->default(0)->commit('商品类型');
            $table->string('goods_title',20)->nullable()->commit('商品标题');
            $table->string('Thumbnails',35)->nullable()->commit('缩略图');
            $table->string('plan',400)->nullable()->commit('展示图');
            $table->float('price')->nullable()->commit('价格');
            $table->integer('inventory')->nullable()->commit('库存');
            $table->string('Size_reference',100)->nullable()->commit('尺码参考');
            $table->string('measure',100)->nullable()->commit('尺码');
            $table->string('Shoulder_width',100)->nullable()->commit('肩宽');
            $table->string('Long_clothing',100)->nullable()->commit('衣长');
            $table->string('Sleeve_Length',100)->nullable()->commit('袖长');
            $table->string('bust',100)->nullable()->commit('胸围');
            $table->string('Material',100)->nullable()->commit('材质');
            $table->string('Colour',100)->nullable()->commit('颜色');
            $table->string('Sleeve_Type',100)->nullable()->commit('袖型');
            $table->string('style',100)->nullable()->commit('风格');
            $table->string('Version_type',100)->nullable()->commit('版型');
            $table->longText('content')->nullable()->commit('商品详情');
            $table->tinyInteger('recommend')->default(0)->commit('0默认不推荐，1为推荐');
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
        Schema::drop('goods');
    }
}
