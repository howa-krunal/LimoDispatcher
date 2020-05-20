<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToJobDisps extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('job_disps', function (Blueprint $table) {
            // Referance No , Req. Vc. No., Req. Price ,Booking No
            $table->string('referance_no')->nullable();
            $table->string('req_vc_no')->nullable();
            $table->string('req_price')->nullable();
            $table->string('booking_no')->nullable()->after('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('job_disps', function (Blueprint $table) {
            //
        });
    }
}
