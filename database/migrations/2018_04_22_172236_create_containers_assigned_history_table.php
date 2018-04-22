<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContainersAssignedHistoryTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('container_assigned_history', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('container_id')->unsigned();
            $table->integer('delegate_id')->unsigned();
            $table->date('start');
            $table->date('end')->nullable();
            $table->foreign('container_id')->references('id')->on('containers');
            $table->foreign('delegate_id')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('containers_assigned_history');
    }

}
