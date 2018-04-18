<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotiTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('noti', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('noti_object_id')->unsigned();
            $table->integer('notifier_id')->unsigned()->nullable();
            $table->boolean('read_status')->default(0);
            $table->foreign('noti_object_id')->references('id')->on('noti_object');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('noti');
    }

}
