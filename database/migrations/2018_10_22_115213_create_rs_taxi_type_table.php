<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRsTaxiTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rs_taxi_type', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('vendor_id');
            $table->string('type');
            $table->integer('base_cost');
            $table->integer('km_cost');
            $table->integer('night');
            $table->integer('midnight');
            $table->integer('waiting');
            $table->integer('user_id');
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
        Schema::dropIfExists('rs_taxi_type');
    }
}
