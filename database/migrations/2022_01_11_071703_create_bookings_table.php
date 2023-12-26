<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//'service_id' => service
//,'customer_id' => customer
//,'provider_id', => provider
//'address'=>string input
//,'booking_state_id'=> 7state
//,'payment_method_id'=> paypal,cash,stripe
//,'payment_state_id' => 1->paid , 2->failed
//,'tax' => fee on provider %
//,'coupon' => if any code is valid and get the value from coupon table and implement it with the total price
//,'total'  => sum of payment
//        'hint','book_date',
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->integer('service_id');
            $table->integer('customer_id');
            $table->string('address');
            $table->string('provider_id');
            $table->string('hint');
            $table->dateTime('book_date');
            $table->integer('booking_state_id')->nullable();
            $table->integer('payment_state_id')->nullable();
            $table->double('coupon_id')->nullable();
            $table->double('total');
            $table->integer('accept')->default(0);
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
        Schema::dropIfExists('bookings');
    }
}
