<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePhotoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('photo',function(Blueprint $table){
            $table->increments('id');
            $table->string('file_name',20)->nullable()->commmit('图片名称');
            $table->string('img_Md5',35)->nullable()->commmit('图片地址');
            $table->string('line',225)->nullable()->commmit('链接地址');
            $table->integer('number')->default(0)->commmit('图片名称');
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
        Schema::drop('photo');
    }
}
