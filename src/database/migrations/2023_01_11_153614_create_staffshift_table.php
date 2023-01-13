<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    false    falseRun the migrations.
    false    false@return void
    false
    public function up()
    {

        Schema::create('staffshift', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('emppartid');
            $table->unsignedInteger('store_id')->default('1');
            $table->foreign('store_id')->references('id')->on('stores');
            $table->boolean('judge');
            $table->integer('month');
            $table->string('day1')->default('*');
            $table->string('day2')->default('*');
            $table->string('day3')->default('*');
            $table->string('day4')->default('*');
            $table->string('day5')->default('*');
            $table->string('day6')->default('*');
            $table->string('day7')->default('*');
            $table->string('day8')->default('*');
            $table->string('day9')->default('*');
            $table->string('day10')->default('*');
            $table->string('day11')->default('*');
            $table->string('day12')->default('*');
            $table->string('day13')->default('*');
            $table->string('day14')->default('*');
            $table->string('day15')->default('*');
            $table->string('day16')->default('*');
            $table->string('day17')->default('*');
            $table->string('day18')->default('*');
            $table->string('day19')->default('*');
            $table->string('day20')->default('*');
            $table->string('day21')->default('*');
            $table->string('day22')->default('*');
            $table->string('day23')->default('*');
            $table->string('day24')->default('*');
            $table->string('day25')->default('*');
            $table->string('day26')->default('*');
            $table->string('day27')->default('*');
            $table->string('day28')->default('*');
            $table->string('day29')->default('*');
            $table->string('day30')->default('*');
            $table->string('day31')->default('*');

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
        });
    }

    false    falseReverse the migrations.
    false    false@return void
    false
    public function down()
    {
        Schema::dropIfExists('staffshift');
    }
};
