<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserAddtionalInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_addtional_infos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_info_id')->unsigned();
            $table->string('salary_currency', 10)->nullable();
            $table->integer('salary')->default(0)->nullable();
            $table->foreignId('country_id')->nullable()->constrained();
            $table->foreignId('area_id')->nullable()->constrained();
            $table->string('city_name')->nullable();
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
        Schema::dropIfExists('user_addtional_infos');
    }
}
