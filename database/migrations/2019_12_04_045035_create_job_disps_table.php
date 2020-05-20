<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobDispsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_disps', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('req_by_user_id');
            $table->integer('branch_id');
            $table->date('job_date');
            $table->time('job_time');
            $table->string('vh_brand');
            $table->string('vh_type');
            $table->dateTime('booking_date');
            $table->string('group_name');
            $table->string('service_type');
            $table->string('other_desc');
            $table->string('guest_name');
            $table->string('flight_detail');
            $table->string('room_no');
            $table->string('company');
            $table->string('req_by_emp_name');
            $table->string('job_status');
            $table->text('job_remark');
            $table->string('vc_status');
            $table->date('vc_date');
            $table->integer('vh_id');
            $table->string('vh_no');
            $table->integer('driver_id');
            $table->string('driver_name');
            $table->decimal('driver_comm_rate',8,2);
            $table->double('vh_mile_out',15,2);
            $table->double('vh_mile_in',15,2);
            $table->dateTime('vh_out_time');
            $table->dateTime('vh_in_time');
            $table->double('trip_amount',15,2);
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
        Schema::dropIfExists('job_disps');
    }
}
