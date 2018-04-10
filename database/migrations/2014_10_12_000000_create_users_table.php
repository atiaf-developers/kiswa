<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email')->unique();
            $table->string('mobile')->unique();
            $table->string('username')->unique();
            $table->string('name')->nullable();
            $table->string('image')->nullable();
            $table->string('password');
            $table->integer('type');
            /*
             1 => managers
             2 => bus_supervisors
            */
            $table->string('device_token');
            $table->boolean('device_type');
            $table->boolean('active');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('users');
    }

}
