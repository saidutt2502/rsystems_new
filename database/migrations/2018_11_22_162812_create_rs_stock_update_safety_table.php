<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRsStockUpdateSafetyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rs_stockUpdateSafety', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('shoe_id');
            $table->integer('user_id');
            $table->integer('quantity_updated');
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
        Schema::dropIfExists('rs_stockUpdateSafety');
    }
}
