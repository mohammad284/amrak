<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProviderWorkHoursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//        'day_id', 'provider_id','details','start_at','end_at'

        Schema::create('provider_work_hours', function (Blueprint $table) {
            $table->id();
            $table->integer('day_id');
            $table->integer('provider_id');
            $table->text('details');
            $table->string('start_at');
            $table->string('end_at');
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
        Schema::dropIfExists('provider_work_hours');
    }
}
