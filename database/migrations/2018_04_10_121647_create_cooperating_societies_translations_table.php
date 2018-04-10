<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCooperatingSocietiesTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cooperating_societies_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->char('locale',2);
            $table->string('title',255);
            $table->text('description');

            $table->integer('cooperating_society_id')->unsigned();
            $table->foreign('cooperating_society_id','society_id')->references('id')->on('cooperating_societies');

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
        Schema::dropIfExists('cooperating_societies_translations');
    }
}
