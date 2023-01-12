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
        Schema::create('needshift', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('store_id')->default('1');
            $table->foreign('store_id')->references('id')->on('stores');
            $table->integer('day');
            $table->string('time1')->nullable();
            $table->string('time2')->nullable();
            $table->string('time3')->nullable();
            $table->string('time4')->nullable();
            $table->string('time5')->nullable();
            $table->string('time6')->nullable();
            $table->string('time7')->nullable();
            $table->string('time8')->nullable();
            $table->string('time9')->nullable();
            $table->string('time10')->nullable();
            $table->string('time11')->nullable();
            $table->string('time12')->nullable();
            $table->string('time13')->nullable();
            $table->string('time14')->nullable();
            $table->string('time15')->nullable();
            $table->string('time16')->nullable();
            $table->string('time17')->nullable();
            $table->string('time18')->nullable();
            $table->string('time19')->nullable();
            $table->string('time20')->nullable();
            $table->string('time21')->nullable();
            $table->string('time22')->nullable();
            $table->string('time23')->nullable();
            $table->string('time24')->nullable();
            $table->string('time25')->nullable();
            $table->string('time26')->nullable();
            $table->string('time27')->nullable();
            $table->string('time28')->nullable();
            $table->string('time29')->nullable();
            $table->string('time30')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('needshift');
    }
};
