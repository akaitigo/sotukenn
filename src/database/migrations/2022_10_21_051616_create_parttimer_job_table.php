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
        Schema::create('parttimer_job', function (Blueprint $table) {
            $table->increments('parttimer_job_id');
            $table->unsignedInteger('parttimer_id');
            $table->foreign('parttimer_id')->references('parttimer_id')->on('parttimers');
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
        Schema::dropIfExists('parttimer_job');
    }
};
