<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProviderReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('provider_reviews', function (Blueprint $table) {
            $table->id();
            $table->integer('customer_id');
            $table->integer('provider_id');
            $table->integer('accept')->default(0);
            $table->string('comment');
            $table->integer('rate');
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
        Schema::dropIfExists('provider_reviews');
    }
}
