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
        Schema::create('employees', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->integer('weight')->default('1');
            $table->unsignedInteger('store_id')->default('1');
            $table->foreign('store_id')->references('id')->on('stores');
            $table->integer('age');
            $table->integer('submissionrate');                  //提出率
            $table->double('monthminworktime',4,1);             //月の最低労働時間
            $table->double('monthmaxworktime',4,1);             //月の最高労働時間 -1は基準がない　設定がない
            $table->double('weekminworktime',3,1);              //週の最低労働時間
            $table->double('weekmaxworktime',3,1);              //週の最高労働時間
            $table->double('dayminworktime',3,1);               //日の最低労働時間
            $table->double('daymaxworktime',3,1);               //日の最高労働時間
            $table->rememberToken();
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
        Schema::dropIfExists('employees');
    }
};
