<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSlidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
            //        'text'
            //,'btn'
            //,'text_color'
            //,'btn_color'
            //,'background_color'
            //,'indicator_color'
            //,'image_service'
            //,'enable' => 1, 0

        Schema::create('sliders', function (Blueprint $table) {
            $table->id();
            $table->string('text');
            $table->string('btn');
            $table->string('text_color');
            $table->string('btn_color');
            $table->string('background_color');
            $table->string('indicator_color');
            $table->string('image_service');
            $table->integer('enable');
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
        Schema::dropIfExists('sliders');
    }
}
