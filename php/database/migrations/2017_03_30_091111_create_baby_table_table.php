<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBabyTableTable extends Migration
{
    /**
     * Run the migrations.
     * $Gender=Input::get('gender');
     * $body_hight=Input::get('bod_lisnt');
     * $birthday=Input::get('birthday');
     * $weight=Input::get('body_weight');
     * @return void
     */
    public function up()
    {
        Schema::create('baby_table', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->nullable()->unique()->commit('母(父)id');
            $table->tinyInteger('gender')->default(0)->commit('性别，默认为0男');
            $table->char('baby_name',10)->nullable()->commit('宝贝名字');
            $table->string('baby_avatar',35)->nullable()->commit('宝贝的头像');
            $table->string('baby_weight',10)->commit('宝贝体重');
            $table->string('birthday',25)->nullable()->commit('宝贝生日');
            $table->string('baby_age',20)->nullable()->commit('宝贝岁数');
            $table->tinyInteger('remind')->default(0)->commit('是否提醒宝贝生日，0为提醒，1为不提醒');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('baby_table');
    }
}
