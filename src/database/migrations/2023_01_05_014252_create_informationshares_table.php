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
        Schema::create('informationshares', function (Blueprint $table) {
            $table->unsignedInteger('store_id')->default('1');
            $table->foreign('store_id')->references('id')->on('stores');
            $table->integer('shareSpan')->nullable(); //表示期間
            $table->string('shareContent')->nullable(); //掲示明
            $table->string('registerUser')->nullable(); //登録者
            $table->string('shareText')->nullable(); //掲示内容
            $table->date('registrationDate')->nullable(); //登録日
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
