<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 'service_id' = > to services
        //,'customer_id'=> from users
        //,'review'=> string
        //,'rate' => select rate [1-2-3-4-5]

        Schema::create('service_reviews', function (Blueprint $table) {
            $table->id();
            $table->integer('service_id');
            $table->integer('customer_id');
            $table->string('review');
            $table->integer('rate');
            $table->integer('accept')->default(0);
            $table->string('lang')->nullable();
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
        Schema::dropIfExists('service_reviews');
    }
}
