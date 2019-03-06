<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRsServIssuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rs_serv_issues', function (Blueprint $table) {
            $table->increments('id');
            $table->string('remark')->nullable();
            $table->string('issue');
            $table->string('reporter_id');
            $table->string('department');
            $table->integer('priority')->nullable();
            $table->date('reported_on');
            $table->date('target_date')->nullable();
            $table->date('fixed_on')->nullable();
            $table->integer('status');
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
        Schema::dropIfExists('rs_serv_issues');
    }
}
