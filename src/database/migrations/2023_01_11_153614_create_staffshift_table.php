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
        Schema::create('staffshift', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('emppartid');
            $table->unsignedInteger('store_id')->default('1');
            $table->foreign('store_id')->references('id')->on('stores');
            $table->boolean('judge');
            $table->integer('month');
            $table->string('day1')->nullable();
            $table->string('day2')->nullable();
            $table->string('day3')->nullable();
            $table->string('day4')->nullable();
            $table->string('day5')->nullable();
            $table->string('day6')->nullable();
            $table->string('day7')->nullable();
            $table->string('day8')->nullable();
            $table->string('day9')->nullable();
            $table->string('day10')->nullable();
            $table->string('day11')->nullable();
            $table->string('day12')->nullable();
            $table->string('day13')->nullable();
            $table->string('day14')->nullable();
            $table->string('day15')->nullable();
            $table->string('day16')->nullable();
            $table->string('day17')->nullable();
            $table->string('day18')->nullable();
            $table->string('day19')->nullable();
            $table->string('day20')->nullable();
            $table->string('day21')->nullable();
            $table->string('day22')->nullable();
            $table->string('day23')->nullable();
            $table->string('day24')->nullable();
            $table->string('day25')->nullable();
            $table->string('day26')->nullable();
            $table->string('day27')->nullable();
            $table->string('day28')->nullable();
            $table->string('day29')->nullable();
            $table->string('day30')->nullable();
            $table->string('day31')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('staffshift');
    }
};
