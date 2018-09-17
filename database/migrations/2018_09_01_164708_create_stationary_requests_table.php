<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStationaryRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rs_stationaryRequests', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('item_id');
            $table->integer('location_id')->default(session('location'));
            $table->integer('costcenter_id');
            $table->integer('quantity');
            $table->string('remarks')->nullable();
            $table->date('pickup_date');
            $table->string('time_slot');
            $table->integer('status')->default(1);
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
        Schema::dropIfExists('rs_stationaryRequests');
    }
}
