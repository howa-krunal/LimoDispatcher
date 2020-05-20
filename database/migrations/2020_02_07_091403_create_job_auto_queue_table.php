<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobAutoQueueTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_auto_queue', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('branch_id')->nullable();
            $table->integer('driver_office_id')->nullable();
            $table->integer('driver_id')->nullable();
            $table->string('driver_name')->nullable();
            $table->dateTime('last_date')->nullable();
            $table->integer('vh_office_id')->nullable();
            $table->integer('vh_id')->nullable();
            $table->string('vh_no')->nullable();
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
        Schema::dropIfExists('job_auto_queue');
    }
}
