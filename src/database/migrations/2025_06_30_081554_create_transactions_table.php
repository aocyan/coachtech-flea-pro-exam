<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_transaction_id')->nullable();
            $table->unsignedBigInteger('product_transaction_id')->nullable();
            $table->string('comment',255)->nullable()->default('');
            $table->string('image')->nullable()->default('');
            $table->string('seller_comment_count')->nullable()->default('');
            $table->string('transaction_comment_count')->nullable()->default('');
            $table->timestamps();

            $table->foreign('user_transaction_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('product_transaction_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
