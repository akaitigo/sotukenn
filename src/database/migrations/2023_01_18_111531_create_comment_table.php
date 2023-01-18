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
        Schema::create('comment', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('emppartid');
            $table->unsignedInteger('store_id')->default('1');
            $table->foreign('store_id')->references('id')->on('stores');
            $table->boolean('judge');
            $table->integer('month');
            $table->string('comment1')->nullable();
            $table->string('comment2')->nullable();
            $table->string('comment3')->nullable();
            $table->string('comment4')->nullable();
            $table->string('comment5')->nullable();
            $table->string('comment6')->nullable();
            $table->string('comment7')->nullable();
            $table->string('comment8')->nullable();
            $table->string('comment9')->nullable();
            $table->string('comment10')->nullable();
            $table->string('comment11')->nullable();
            $table->string('comment12')->nullable();
            $table->string('comment13')->nullable();
            $table->string('comment14')->nullable();
            $table->string('comment15')->nullable();
            $table->string('comment16')->nullable();
            $table->string('comment17')->nullable();
            $table->string('comment18')->nullable();
            $table->string('comment19')->nullable();
            $table->string('comment20')->nullable();
            $table->string('comment21')->nullable();
            $table->string('comment22')->nullable();
            $table->string('comment23')->nullable();
            $table->string('comment24')->nullable();
            $table->string('comment25')->nullable();
            $table->string('comment26')->nullable();
            $table->string('comment27')->nullable();
            $table->string('comment28')->nullable();
            $table->string('comment29')->nullable();
            $table->string('comment30')->nullable();
            $table->string('comment31')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comment');
    }
};
