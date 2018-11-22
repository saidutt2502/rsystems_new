<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRsSafetyShoesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rs_safety_shoes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('brand');
            $table->string('size');
            $table->integer('available')->default('0');
            $table->float('costpu',11,2);
            $table->integer('threshold');
            $table->integer('location_id')->default(session('location'));
            $table->integer('last_edited')->default(session('user_id'));
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
        Schema::dropIfExists('rs_safety_shoes');
    }
}
