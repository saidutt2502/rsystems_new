<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReportingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rs_reporting', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('department');
            $table->integer('level');
            $table->integer('reporter');
            $table->integer('reportee');
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
        Schema::dropIfExists('rb_reporting');
    }
}
