<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShoppingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('shopping', function (Blueprint $table) {
            $table->increments('sid');
            $table->integer('user_id');
            $table->integer('gid');
			$table->integer('scount');
            $table->string('code',20);
			$table->integer('brand_id');
			$table->string('specif', 60);
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
        Schema::drop('shopping');
    }
}
