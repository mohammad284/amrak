<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAvailabilityHoursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //            'service_id' => from services in service table
        // ,'day_id' => day to work from days_table in database
        //,'start_at' => hours to start
        //,'end_at' => hours to end
        Schema::create('availability_hours', function (Blueprint $table) {
            $table->id();
            $table->integer('service_id');
            $table->integer('day_id');
            $table->time('start_at');
            $table->time('end_at');
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
        Schema::dropIfExists('availability_hours');
    }
}
