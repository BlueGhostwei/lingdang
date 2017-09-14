<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSiteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //

        Schema::create('site', function (Blueprint $table) {
            $table->increments('sid');
			$table->integer('user_id')->commit("用户id");
            $table->string('consignee',80)->commit('收货人');
            $table->string('phone')->commit("联系电话");
            $table->string('area',100)->commit("省");
            $table->string('street',40)->commit("市");
			$table->string('district',100)->commit("县");
            $table->string('scene',40)->commit("街道");
            $table->string('scontent',100)->commit("具体地址");
            $table->integer('sdefault')->nullable()->commit("0为默认1为不默认");
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
        //
        Schema::drop('site');
    }
}
