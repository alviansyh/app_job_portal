<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_infos', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->unsignedBigInteger('user_id');
            $table->string('photo')->nullable();
            $table->timestamp('last_updated_photo')->nullable();
            $table->integer('country_id')->unsigned();
            $table->integer('area_id')->unsigned();
            $table->string('city')->nullable();
            $table->enum('gender', ['male', 'female', 'not_specified']);
            $table->date('date_birthday')->nullable();
            $table->string('address')->nullable();
            $table->string('address_2')->nullable();
            $table->string('postal_code', 10)->nullable();
            $table->string('phone')->nullable();
            $table->string('identity_number', 16)->nullable();
            $table->text('about_me')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('country_id')->references('id')->on('countries');
            $table->foreign('area_id')->references('id')->on('areas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_infos');
    }
}
