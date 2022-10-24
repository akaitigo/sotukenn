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
        Schema::create('parttimers', function (Blueprint $table) {
            $table->incremrnts('parttimer_id');
            $table->int('employee_id');
            $table->foreign('employee_id')->references('employee_id')->on('emploies');
            $table->string('parttimer_name');
            $table->string('parttimer_pass');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('parttimers');
    }
};
