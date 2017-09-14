<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * 
     * @return void
     */
    public function up()
    {
        Schema::create('attributes',function(Blueprint $table){
            $table->increments('id');
            $table->integer('sort_id');
            $table->string('arr_name',20)->nullable()->commit("属性名称");
            $table->integer('store_num')->nullable()->commit("排序");
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
        Schema::drop('attributes');
    }
}
