<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserRecipeTable extends Migration
{
    /**
     * Run the migrations.
     *$data['user_openid'] = $_POST['user_openid'];
     * $data['require_type'] = $_POST['require_type'];
     * $data['img_path'] = implode(',', $_POST['img_path']);
     * $data['name'] = $_POST['name'];
     * $data['phone'] = $_POST['phone'];
     * $data['Dish_name'] = $_POST['Dish_name'];
     * $data['ask_mom'] = $_POST['ask_mom'];
     * @return void
     */
    public function up()
    {
        Schema::create('userRecipe', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_openid')->index()->unique();
            $table->tinyInteger('require_type');
            $table->string('img_path', 800)->nullable();
            $table->string('name',20)->nullable();
            $table->integer('phone');
            $table->string('Dish_name',50)->nullable();
            $table->string('ask_mom',200)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('userRecipe');
    }
}
