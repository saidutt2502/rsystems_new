<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCostcentersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rs_costcenters', function (Blueprint $table) {
            $table->increments('id');
            $table->string('number');
            $table->integer('department');
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
        Schema::dropIfExists('costcenters');
    }
}
