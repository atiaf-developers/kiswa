<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivitiesTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activities_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->char('locale',2);
            $table->string('title',255);
            $table->text('description');

            $table->integer('activity_id')->unsigned();
            $table->foreign('activity_id')->references('id')->on('activities');

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
        Schema::dropIfExists('activities_translations');
    }
}
