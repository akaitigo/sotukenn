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
        Schema::create('informationshare', function (Blueprint $table) {
            $table->unsignedInteger('store_id')->default('1');
            $table->foreign('store_id')->references('id')->on('stores');
            $table->string('shareName');
            $table->string('shareContent');
            $table->integer('shareTarget');
            $table->string('registerUser');
            $table->date('registrationDate');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('informationshare');
    }
};
