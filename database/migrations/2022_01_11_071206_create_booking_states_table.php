<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingStatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // ' name' => 1-> received ,2-> accepted, 3-> on the way ,
        // 4-> ready, 5 -> in progress , 6-> done , 7 -> failed
        Schema::create('booking_states', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('lang');
            $table->integer('trans_id')->nullable();
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
        Schema::dropIfExists('booking_states');
    }
}
