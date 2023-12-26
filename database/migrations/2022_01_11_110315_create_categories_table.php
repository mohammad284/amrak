<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('order_id');
            $table->integer('color_id');
            $table->unsignedBigInteger('parent_id')->default(0);
            $table->string('lang')->default('ar');
            $table->string('icon');
            $table->integer('featured');
            $table->string('font_color');
            $table->string('background_color');
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
        Schema::dropIfExists('categories');
    }
}
