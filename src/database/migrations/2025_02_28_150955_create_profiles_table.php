<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('profile_user_id');
            $table->string('image')->nullable()->default('');
            $table->string('postal',8)->nullable()->default('');
            $table->string('address')->nullable()->default('');
            $table->string('building')->nullable()->default('');
            $table->string('evaluation')->nullable()->default('');
            $table->string('evaluation_count')->nullable()->default('');
            $table->string('before_evaluation_count')->nullable()->default('');
            $table->timestamps();

            $table->foreign('profile_user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('profiles');
    }
}
