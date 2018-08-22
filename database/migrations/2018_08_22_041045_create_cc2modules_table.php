<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCc2modulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rs_cc2modules', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user');
            $table->integer('costcenter');
            $table->integer('module');
            $table->integer('budget');
            $table->integer('actual')->default('0');
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
        Schema::dropIfExists('rs_cc2modules');
    }
}
