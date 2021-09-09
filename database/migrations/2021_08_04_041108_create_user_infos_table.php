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
        Schema::enableForeignKeyConstraints();
        Schema::create('user_infos', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->foreignId('user_id')->constrained('users');
            $table->string('photo')->nullable();
            $table->timestamp('last_updated_photo')->nullable();
            $table->foreignId('country_id')->nullable()->constrained();
            $table->foreignId('area_id')->nullable()->constrained();
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
