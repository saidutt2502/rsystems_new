<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRsSafetyRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rs_safety_requests', function (Blueprint $table) {
            $table->increments('id');
            $table->date('pickup_date');
            $table->integer('shoes_id');
            $table->integer('user_id');
            $table->string('emp_id');
            $table->string('status');
            $table->integer('quantity');
            $table->integer('issue_status')->default(5);
            $table->integer('issued_by')->nullable();
            $table->timestamp('issued_date')->nullable();
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
        Schema::dropIfExists('rs_safety_requests');
    }
}
