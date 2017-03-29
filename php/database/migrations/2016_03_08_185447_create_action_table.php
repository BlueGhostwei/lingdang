<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('action', function (Blueprint $table)
        {
            $table->increments('id');

            // 模块名
            $table->string('model', 30);

            // 被操作模块下的资源id
            $table->integer('result_id')->default(0);

            // 执行动作的用户id
            $table->integer('user_id')->default(0);

            // 动作, 10个汉字以内
            $table->string('action', 20);

            // 备注, 动作描述或产生的结果等, 可为空, 补充使用, 如删除原因, 新建的话题名称, 50个汉字100字符以内
            $table->string('description', 100);

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
        Schema::drop('action');
    }
}
