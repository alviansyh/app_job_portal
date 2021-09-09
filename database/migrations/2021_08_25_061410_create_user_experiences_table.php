<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserExperiencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_experiences', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_info_id')->unsigned();
            $table->string('position')->nullable();
            $table->string('company', 95)->nullable();
            $table->string('salary_currency', 10)->nullable();
            $table->integer('salary')->default(0)->nullable();
            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();
            $table->mediumText('description')->nullable();
            $table->timestamps();

            $table->foreign('user_info_id')->references('id')->on('user_infos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_experiences');
    }
}
