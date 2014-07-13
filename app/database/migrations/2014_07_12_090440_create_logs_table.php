<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogsTable extends Migration
{
    /**
	 * Run the migrations.
	 *
	 * @return void
	 */
    public function up()
    {
        Schema::create('logs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->nullable()->index();
            $table->string('url');
            $table->string('route');
            $table->text('params');
            $table->text('method');
            $table->integer('httpCode');
            $table->string('ip', 45);
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
    public function down()
    {
        Schema::drop('logs');
    }

}
