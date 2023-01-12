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
        Schema::create('nextdivider', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('store_id')->default('1');
            $table->foreign('store_id')->references('id')->on('stores');
            $table->string('main')->nullable();
            $table->string('sub1')->nullable();
            $table->string('sub2')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nextdivider');
    }
};
