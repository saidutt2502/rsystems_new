<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductionEditPermisionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rs_production_user_list', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('user_id');
                $table->integer('location_id');
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
        Schema::dropIfExists('rs_production_user_list');
    }
}
