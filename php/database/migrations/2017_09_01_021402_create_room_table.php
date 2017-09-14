<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoomTable extends Migration
{
    /**
     * Run the migrations.
     *           $table->string('pushUrl',200);//推流地址
     *  $table->string('httpPullUrl',200);//http拉流地址
    *         $table->string('hlsPullUrl',200);//hls拉流地址
     * @return void
     */
    public function up()
    {
        //
        Schema::create('room', function (Blueprint $table) {
            $table->increments('id');//id
            $table->string('cid',40);//频道ID
            $table->string('rid',20);//房间的id
            $table->string('rname',40);//房间的名称
            $table->string('rtmpPullUrl',200);//rtmp拉流地址
            $table->string('msg',40);//错误信息
            $table->string('ctime',40);//创建频道的时间戳
            $table->integer('status');//频道状态（0：空闲； 1：直播； 2：禁用； 3：直播录制）
            $table->integer('type');//频道类型 ( 0 : rtmp, 1 : hls, 2 : http)

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
        Schema::drop('room');
    }
}
