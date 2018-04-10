<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlbumsTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('albums_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->char('locale',2);
            $table->string('title',255);
            $table->integer('album_id')->unsigned();
            $table->foreign('album_id')->references('id')->on('albums');

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
        Schema::dropIfExists('albums_translations');
    }
}
