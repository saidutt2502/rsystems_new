<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaxiSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rs_taxiSettings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('location_id');
            $table->integer('user_id');
            $table->integer('base_kms');
            $table->time('night_time');
            $table->time('midnight_time');
            $table->longText('airport_locations')->nullable();
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rs_taxiSettings');
    }
}
