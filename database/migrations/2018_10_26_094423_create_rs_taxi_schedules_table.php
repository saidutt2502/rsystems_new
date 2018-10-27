<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRsTaxiSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rs_taxi_schedules', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('lead_trip_id');
            $table->integer('taxi_id');
            $table->time('scheduled_time');
            $table->date('start_date')->nullable();
            $table->time('start_time')->nullable();
            $table->integer('start_km')->nullable();
            $table->date('end_date')->nullable();
            $table->time('end_time')->nullable();
            $table->integer('end_km')->nullable();
            $table->integer('total_km')->nullable();
            $table->integer('cost')->nullable();
            $table->integer('assigning_user');
            $table->integer('closing_user')->nullable();
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
        Schema::dropIfExists('rs_taxi_schedules');
    }
}
