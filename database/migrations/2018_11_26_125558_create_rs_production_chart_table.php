<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRsProductionChartTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rs_production_chart', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('day');
            $table->string('month');
            $table->integer('year');
            $table->integer('subdept_id');
            $table->integer('planned')->default('0');
            $table->integer('achived')->default('0');
            $table->integer('difference')->default('0');
            $table->integer('last_edited');
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
        Schema::dropIfExists('rs_production_chart');
    }
}
