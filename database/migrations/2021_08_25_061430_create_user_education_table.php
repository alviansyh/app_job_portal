<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserEducationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_education', function (Blueprint $table) {
            $table->increments('id');
            $table->foreignId('user_info_id')->constrained('user_infos');
            $table->string('institute', 95)->nullable();
            $table->string('title')->nullable();
            $table->string('major')->nullable();
            $table->decimal('score', 5,2)->nullable();
            $table->decimal('max_score', 5,2)->nullable();
            $table->mediumText('activity')->nullable();
            $table->mediumText('description')->nullable();
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
        Schema::dropIfExists('user_education');
    }
}
