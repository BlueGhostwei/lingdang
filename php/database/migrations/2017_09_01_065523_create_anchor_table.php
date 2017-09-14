<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnchorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('anchor', function (Blueprint $table) {
            $table->increments('id');//id
            $table->integer('user_id');//主播id
            $table->string('room_id',20);//房间的id
            $table->string('themename',40);//本期主题的名称
            $table->integer('number');//关注人数
            $table->integer('like');//点赞数
            $table->string('keyword',40);//关键字
			$table->integer('whether');//0是直播， 1不是主播
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
        Schema::drop('anchor');
    }
}
