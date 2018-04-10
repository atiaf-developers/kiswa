<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContainersTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('containers_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->char('locale',2);
            $table->string('title',255);
            $table->text('address');
            $table->integer('container_id')->unsigned();
            $table->foreign('container_id')->references('id')->on('containers');
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
        Schema::dropIfExists('containers_translations');
    }
}
