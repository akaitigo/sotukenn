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
        Schema::create('optimize', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('store_id')->default('1');
            $table->foreign('store_id')->references('id')->on('stores');
            $table->double('main_attendance')->nullable();
            $table->double('main_leaving')->nullable();
            $table->double('sub1_attendance')->nullable();
            $table->double('sub1_leaving')->nullable();
            $table->double('sub2_attendance')->nullable();
            $table->double('sub2_leaving')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('optimize');
    }
};
