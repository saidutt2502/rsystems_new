<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRsTmsStockupdateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rs_tms_stockupdate', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('tool_id');
			$table->integer('user_id');
			$table->integer('quantity');
			$table->integer('dept_id');
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
        Schema::dropIfExists('rs_tms_stockupdate');
    }
}
