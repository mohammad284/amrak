<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //is_used = 0 => not used , 1=> used
        //enable = 0 => enable, 1=> not enable
        //discount_type = 0=> percent , 1=> amount
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->text('code');
            $table->unsignedBigInteger('service_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->integer('discount');
            $table->integer('discount_type');
            $table->integer('is_used')->nullable();
            $table->integer('enable')->default(1);
//            $table->date('expire_at');
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
        Schema::dropIfExists('coupons');
    }
}
