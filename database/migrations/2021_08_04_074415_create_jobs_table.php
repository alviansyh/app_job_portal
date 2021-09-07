<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->increments('id');
            $table->foreignId('company_id')->constrained('company_infos');
            $table->string('job_title')->nullable();
            $table->string('job_slug')->unique();
            $table->string('position')->nullable();
            $table->foreignId('category_id')->nullable()->constrained();
            $table->integer('salary')->default(0)->nullable(); //Salary from
            $table->integer('salary_upto')->default(0)->nullable(); //Salary to (Up range)
            $table->tinyInteger('is_negotiable')->default(0)->nullable();
            $table->enum('salary_cycle', ['monthly', 'yearly', 'weekly', 'daily', 'hourly'])->nullable();
            $table->string('salary_currency', 10)->nullable();

            $table->integer('vacancy')->nullable();
            $table->enum('gender', ['male', 'female', 'not_specified']);
            $table->enum('job_type', ['full_time', 'part_time', 'contract', 'temporary', 'internship'])->default('full_time')->nullable();
            $table->enum('exp_level', ['middle', 'junior', 'senior'])->nullable();

            $table->text('skills')->nullable();
            $table->longText('description')->nullable();
            $table->longText('qualification')->nullable();
            $table->text('benefits')->nullable();
            $table->text('notes')->nullable();

            $table->foreignId('country_id')->nullable()->constrained();
            $table->foreignId('area_id')->nullable()->constrained();
            $table->string('city_name')->nullable();

            $table->tinyInteger('experience_required_years')->default(0)->nullable(); //In Years
            $table->tinyInteger('min_exp')->default(0)->nullable();
            $table->integer('views')->nullable();
            $table->dateTime('approved_at')->nullable();
            $table->dateTime('deadline')->nullable();
            $table->tinyInteger('status')->default(0)->nullable(); //0,pending,1=approved,2=blocked
            $table->string('job_id', 20)->nullable();
            $table->tinyInteger('is_premium')->nullable();
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
        Schema::dropIfExists('jobs');
    }
}
