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
            $table->string('day1')->default('-1');
            $table->string('day2')->default('-1');
            $table->string('day3')->default('-1');
            $table->string('day4')->default('-1');
            $table->string('day5')->default('-1');
            $table->string('day6')->default('-1');
            $table->string('day7')->default('-1');
            $table->string('day8')->default('-1');
            $table->string('day9')->default('-1');
            $table->string('day10')->default('-1');
            $table->string('day11')->default('-1');
            $table->string('day12')->default('-1');
            $table->string('day13')->default('-1');
            $table->string('day14')->default('-1');
            $table->string('day15')->default('-1');
            $table->string('day16')->default('-1');
            $table->string('day17')->default('-1');
            $table->string('day18')->default('-1');
            $table->string('day19')->default('-1');
            $table->string('day20')->default('-1');
            $table->string('day21')->default('-1');
            $table->string('day22')->default('-1');
            $table->string('day23')->default('-1');
            $table->string('day24')->default('-1');
            $table->string('day25')->default('-1');
            $table->string('day26')->default('-1');
            $table->string('day27')->default('-1');
            $table->string('day28')->default('-1');
            $table->string('day29')->default('-1');
            $table->string('day30')->default('-1');
            $table->string('day31')->default('-1');
            $table->boolean('registerCheck0')->default(true);
            $table->boolean('registerCheck1')->default(false);
            $table->boolean('registerCheck2')->default(false);
            $table->boolean('registerCheck3')->default(false);
            $table->boolean('registerCheck4')->default(false);
            $table->boolean('registerCheck5')->default(false);
            $table->boolean('registerCheck6')->default(false);
            $table->boolean('registerCheck7')->default(false);
            $table->boolean('registerCheck8')->default(false);
            $table->boolean('registerCheck9')->default(false);
            $table->boolean('registerCheck10')->default(false);
            $table->boolean('registerCheck11')->default(false);
            $table->boolean('registerCheck12')->default(false);
            $table->boolean('registerCheck13')->default(false);
            $table->boolean('registerCheck14')->default(false);
            $table->boolean('registerCheck15')->default(false);
            $table->boolean('registerCheck16')->default(false);
            $table->boolean('registerCheck17')->default(false);
            $table->boolean('registerCheck18')->default(false);
            $table->boolean('registerCheck19')->default(false);
            $table->boolean('registerCheck20')->default(false);
            $table->boolean('registerCheck21')->default(false);
            $table->boolean('registerCheck22')->default(false);
            $table->boolean('registerCheck23')->default(false);
            $table->boolean('registerCheck24')->default(false);
            $table->boolean('registerCheck25')->default(false);
            $table->boolean('registerCheck26')->default(false);
            $table->boolean('registerCheck27')->default(false);
            $table->boolean('registerCheck28')->default(false);
            $table->boolean('registerCheck29')->default(false);
            $table->boolean('registerCheck30')->default(false);
            $table->boolean('registerCheck31')->default(false);
            $table->boolean('editFlag1')->default(false);
            $table->boolean('editFlag2')->default(false);
            $table->boolean('editFlag3')->default(false);
            $table->boolean('editFlag4')->default(false);
            $table->boolean('editFlag5')->default(false);
            $table->boolean('editFlag6')->default(false);
            $table->boolean('editFlag7')->default(false);
            $table->boolean('editFlag8')->default(false);
            $table->boolean('editFlag9')->default(false);
            $table->boolean('editFlag10')->default(false);
            $table->boolean('editFlag11')->default(false);
            $table->boolean('editFlag12')->default(false);
            $table->boolean('editFlag13')->default(false);
            $table->boolean('editFlag14')->default(false);
            $table->boolean('editFlag15')->default(false);
            $table->boolean('editFlag16')->default(false);
            $table->boolean('editFlag17')->default(false);
            $table->boolean('editFlag18')->default(false);
            $table->boolean('editFlag19')->default(false);
            $table->boolean('editFlag20')->default(false);
            $table->boolean('editFlag21')->default(false);
            $table->boolean('editFlag22')->default(false);
            $table->boolean('editFlag23')->default(false);
            $table->boolean('editFlag24')->default(false);
            $table->boolean('editFlag25')->default(false);
            $table->boolean('editFlag26')->default(false);
            $table->boolean('editFlag27')->default(false);
            $table->boolean('editFlag28')->default(false);
            $table->boolean('editFlag29')->default(false);
            $table->boolean('editFlag30')->default(false);
            $table->boolean('editFlag31')->default(false);
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
