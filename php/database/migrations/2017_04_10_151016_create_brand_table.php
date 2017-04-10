<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBrandTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('brand', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->nullable()->commit('用户id');
            $table->string('sort_id',50)->nullable()->commit('所属分类id');
            $table->string('brand_name',20)->nullable()->commit('品牌名称');
            $table->integer('brand_num')->nullable()->commit('排序id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('brand');
    }
}
