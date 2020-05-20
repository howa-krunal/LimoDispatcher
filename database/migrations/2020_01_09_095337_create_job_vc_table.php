<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobVcTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_vc', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('job_disps_id');
            $table->string('vc_id');
            $table->string('vc_date')->nullable();
            $table->string('vc_time')->nullable();
            $table->string('vc_type')->nullable();
            $table->integer('pk_id')->nullable();
            $table->string('pk_name')->nullable();
            $table->string('pk_group')->nullable();
            $table->string('pk_discount')->nullable();
            $table->double('total_amt',15,2)->nullable();
            $table->string('hotel_airport_flight_no')->nullable();
            $table->string('hotel_airport_terminal_no')->nullable();
            $table->string('hotel_airport_time')->nullable();
            $table->double('hotel_airport_price',15,2)->nullable();
            $table->string('hotel_airport_discount')->nullable();
            $table->double('hotel_airport_amt',15,2)->nullable();
            $table->string('airport_hotel_flight_no')->nullable();
            $table->string('airport_hotel_terminal_no')->nullable();
            $table->string('airport_hotel_time')->nullable();
            $table->double('airport_hotel_price',15,2)->nullable();
            $table->string('airport_hotel_discount')->nullable();
            $table->double('airport_hotel_amt',15,2)->nullable();
            $table->string('per_hour_flight_no')->nullable();
            $table->string('per_hour_terminal_no')->nullable();
            $table->string('per_hour_time')->nullable();
            $table->double('per_hour_price',15,2)->nullable();
            $table->string('per_hour_discount')->nullable();
            $table->double('per_hour_amt',15,2)->nullable();
            $table->string('other_description_1')->nullable();
            $table->double('other_price_1',15,2)->nullable();
            $table->string('other_discount_1')->nullable();
            $table->double('other_amt_1',15,2)->nullable();
            $table->string('other_description_2')->nullable();
            $table->double('other_price_2',15,2)->nullable();
            $table->string('other_discount_2')->nullable();
            $table->double('other_amt_2',15,2)->nullable();
            $table->string('other_description_3')->nullable();
            $table->double('other_price_3',15,2)->nullable();
            $table->string('other_discount_3')->nullable();
            $table->double('other_amt_3',15,2)->nullable();
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
        Schema::dropIfExists('job_vc');
    }
}
