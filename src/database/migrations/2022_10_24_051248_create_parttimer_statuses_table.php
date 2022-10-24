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
        Schema::create('parttimer_statuses', function (Blueprint $table) {
            $table->increments('parttimer_status_id');
            $table->unsignedBigInteger('parttimer_id');
            $table->foreign('parttimer_id')->references('parttimer_id')->on('parttimers');
            $table->unsignedBigInteger('status_id');
            $table->foreign('status_id')->references('status_id')->on('statuses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('parttimer_statuses');
    }
};
