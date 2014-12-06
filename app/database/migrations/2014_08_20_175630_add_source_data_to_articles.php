<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddSourceDataToArticles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->string('image');
            $table->string('imageMiniature');
            $table->string('sourceSite');
            $table->string('sourceFavicon');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->dropColumn('image');
            $table->dropColumn('imageMiniature');
            $table->dropColumn('sourceSite');
            $table->dropColumn('sourceFavicon');
        });
    }

}
