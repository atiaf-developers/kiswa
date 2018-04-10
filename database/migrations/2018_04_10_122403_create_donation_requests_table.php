<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDonationRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('donation_requests', function (Blueprint $table) {
            $table->increments('id');
            $table->text('description');
            $table->text('images');
            $table->dateTime('appropriate_time');
            $table->double('lat',11,9);
            $table->double('lng',11,9);
            $table->integer('status');

            $table->integer('category_id')->unsigned();
            $table->foreign('category_id')->references('id')->on('categories');

            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');

            $table->integer('delegate_id')->unsigned()->nullable();
            $table->foreign('delegate_id')->references('id')->on('users');

            

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
        Schema::dropIfExists('donation_requests');
    }
}
