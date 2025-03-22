<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_user_id')->nullable();
            $table->unsignedBigInteger('purchaser_user_id')->nullable();         
            $table->string('name',255);
            $table->string('brand',255)->nullable();
            $table->integer('price');
            $table->string('color',255)->nullable();
            $table->string('image',255);
            $table->string('condition',255);
            $table->string('description',255);
            $table->timestamp('sold_at')->nullable();
            $table->timestamps();

            $table->foreign('product_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('purchaser_user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
