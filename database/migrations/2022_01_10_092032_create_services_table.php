<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //        'name', string name
        //'icon' => image
        //,'provider_id' => provider
        //,'cat_id' => category
        //,'duration' -> from specific hour to another specific
        //,'discount' -> if any coupon code is there
        //,'price_unit' -> usd,mdh...
        //,'price' ->double
        //,'available' => on-> 1 , off -> 0
        //,'lang' => for translation
        //,'trans_id'
        //featured_id-> true,false

        Schema::create('services', function (Blueprint $table) {
            $table->id();
//            'name','icon','provider_id','cat_id','duration','hint','description',
//        'discount','price_unit','price','tax','available','featured_id'
            $table->string('name');
            $table->string('icon')->nullable();
            $table->integer('provider_id');
            $table->integer('cat_id');
            $table->string('duration');
            $table->integer('discount')->nullable();
            $table->string('hint');
            $table->integer('price');
            $table->text('description');
            $table->integer('tax');
            $table->string('price_unit');
            $table->string('lang')->default('en');
            $table->integer('available')->default('1');
            $table->integer('featured_id')->nullable();
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
        Schema::dropIfExists('services');
    }
}
