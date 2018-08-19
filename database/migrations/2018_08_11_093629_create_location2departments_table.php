<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use Illuminate\Support\Facades\Auth;

class CreateLocation2departmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rs_location2department', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('location');
            $table->integer('department');
            $table->integer('last_edited')->default(session('user_id'));
            $table->date('updated_at')->default(date("Y-m-d"));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rs_location2department');
    }
}
