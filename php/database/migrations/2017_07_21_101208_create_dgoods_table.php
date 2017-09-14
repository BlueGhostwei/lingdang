<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
class CreateDgoodsTable extends Migration
{
    public function up()
    {
        Schema::create('dgoods', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('gid');
            $table->integer('uid');
            $table->integer('dsize');
            $table->string('dcolor',30);
            $table->string('dimg',400);
            $table->integer('dcount');
            $table->text('dcontent');
            $table->timestamps();
        });
    }

    /**
     * 撤销迁移
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('dgoods');
    }
}
