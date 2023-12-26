<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProvidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //        'user_id' => provider is a user with role = 2->provider,
        //'icon' => image profile
        //,'phone' -> constant numb
        //,'address' -> string parameters
        //,'availability_rang' => kilometers from his address
        //,'available' => 1->on , 0 -> off
        //,'lang' => code notifications to translation
        //,'trans_id' => id item to translate it
        Schema::create('providers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->integer('accept')->default(0);
            $table->string('password');
            $table->string('hint');
            $table->integer('mobile');
            $table->string('icon')->nullable();
            $table->string('address');
            $table->integer('available')->default(1);
            $table->integer('availability_rang')->nullable();
            $table->timestamp('deleted_at')->nullable();
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
        Schema::dropIfExists('providers');
    }
}
