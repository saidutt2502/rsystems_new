<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRsTaxiRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rs_taxi_requests', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->date('date_');
            $table->string('location');
            $table->integer('cc_id');
            $table->string('trip_type');
            $table->string('purpose');
            $table->string('place_from');
            $table->string('place_to');
            $table->time('time1');
            $table->time('time2')->nullable();
            $table->string('journey')->nullable();
            $table->string('status');
            $table->integer('location_id');
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
        Schema::dropIfExists('rs_taxi_requests');
    }
}
