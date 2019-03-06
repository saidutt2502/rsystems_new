<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRsTmsToolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rs_tms_tools', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
			$table->integer('dept_id');
			$table->string('tool_code');
			$table->integer('tool_limit');
			$table->integer('added_by');
			$table->integer('available');
            $table->string('tool_location')->nullable();    
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
        Schema::dropIfExists('rs_tms_tools');
    }
}
