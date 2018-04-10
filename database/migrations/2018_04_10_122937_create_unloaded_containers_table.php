<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUnloadedContainersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unloaded_containers', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('delegate_id')->unsigned();
            $table->foreign('delegate_id')->references('id')->on('users');

            $table->integer('container_id')->unsigned();
            $table->foreign('container_id')->references('id')->on('containers');
            
            $table->date('date_of_unloading');

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
        Schema::dropIfExists('unloaded_containers');
    }
}
