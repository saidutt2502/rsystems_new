<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRsGpEntriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rs_gp_entries', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->date('date_');
            $table->integer('shift_id');
            $table->string('purpose');
            $table->string('reason');
            $table->time('from');
            $table->time('to')->nullable();
            $table->float('total')->default('0');
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
        Schema::dropIfExists('rs_gp_entries');
    }
}
