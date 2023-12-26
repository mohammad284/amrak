<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //        'role_id' => provider =>3 , user => 2 , admin => 1,
        //'icon' => image profile
        //,'number' -> constant numb
        //,'address' -> string parameters
        //,'availability_rang' => kilometers from his address => provider
        //,'available' => 1->on , 0 -> off =>provider

        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->integer('mobile');
            $table->string('password');
            $table->string('icon')->nullable();
            $table->string('hint')->nullable();
            $table->string('address')->nullable();
            $table->string('role_id')->default(2);
            $table->timestamp('email_verified_at')->nullable();
            $table->integer('accept')->default(0);
            $table->integer('available')->default(1);
            $table->integer('availability_rang')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
