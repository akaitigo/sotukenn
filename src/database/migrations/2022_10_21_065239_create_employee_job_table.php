<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_job', function (Blueprint $table) {
            $table->increments('employee_job_id');
            $table->unsignedInteger('employee_id');
            $table->foreign('employee_id')->references('employee_id')->on('employees');
            $table->unsignedInteger('job_id');
            $table->foreign('job_id')->references('job_id')->on('jobs');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employee_job');
    }
};
