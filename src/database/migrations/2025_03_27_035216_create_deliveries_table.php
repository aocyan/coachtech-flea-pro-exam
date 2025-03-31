<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliveriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deliveries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_delivery_id');
            $table->string('product_name')->nullable()->default('');
            $table->string('user_name')->nullable()->default('');
            $table->string('postal',8)->nullable()->default('');
            $table->string('address')->nullable()->default('');
            $table->string('building')->nullable()->default('');
            $table->timestamps();

            $table->foreign('product_delivery_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('deliveries');
    }
}
