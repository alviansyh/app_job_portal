<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::enableForeignKeyConstraints();
        Schema::create('company_infos', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->foreignId('user_id')->constrained('users');
            $table->string('logo')->nullable();
            $table->string('company', 95)->nullable();
            $table->string('company_slug')->unique();
            $table->string('company_size', 5)->nullable();
            $table->foreignId('country_id')->nullable()->constrained();
            $table->foreignId('area_id')->nullable()->constrained();
            $table->string('address')->nullable();
            $table->string('address_2')->nullable();
            $table->string('city')->nullable();
            $table->string('postal_code', 10)->nullable();
            $table->string('phone')->nullable();
            $table->longText('about_company')->nullable();
            $table->string('website')->nullable();
            $table->string('validation_number')->nullable();
            //status_validation 0:null, 1:pending, 2:approved, 3:blocked;
            $table->tinyInteger('status_validation')->default(0);
            $table->integer('premium_jobs_balance')->default(0)->nullable();
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
        Schema::dropIfExists('company_infos');
    }
}
