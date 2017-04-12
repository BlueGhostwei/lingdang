<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSortTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sort',function(Blueprint $table){
            $table->increments('id');
            $table->integer('pid')->nullable()->commit('父级id')->index();
            $table->string('name',10)->nullable()->commit('分类名称')->unique();
            $table->string('id_str')->nullable()->commit('保存分类路径');
            $table->integer('num')->default(0)->commit('排序');
            $table->tinyInteger('type')->default(0)->commit('0为商品分类，1为文章分类');
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
        Schema::drop('sort');
    }
}
