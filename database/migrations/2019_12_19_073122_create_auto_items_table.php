<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAutoItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auto_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('plate_no');
            $table->string('brnad');
            $table->string('model');
            $table->string('color');
            $table->string('myear');
            $table->string('capacity');
            $table->string('engine_no');
            $table->string('chassis_no');
            $table->text('remark');
            $table->string('wifi_no');
            $table->string('branch_id');
            $table->string('req_by_user_id');
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
        Schema::dropIfExists('auto_items');
    }
}
