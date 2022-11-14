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
        Schema::create('parttimer_status', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('parttimer_id');
            $table->foreign('parttimer_id')->references('id')->on('parttimers');
            $table->unsignedInteger('status_id');
            $table->foreign('status_id')->references('id')->on('statuses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('parttimer_statuse');
    }
};
