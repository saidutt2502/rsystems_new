<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use Illuminate\Support\Facades\Auth;

class CreateDepartmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rs_departments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('hod_id')->default('0');;
            $table->integer('oc_levels')->default('0');
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
        Schema::dropIfExists('rs_departments');
    }
}
