<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlcNormalTable extends Migration
{
    public function up()
    {
        Schema::connection('sqlsrv')->create('alc_normal', function (Blueprint $table) {
            $table->id();
            $table->integer('alc_checking_id')->nullable();
            $table->integer('alc_usage_bottle_id')->nullable();
            $table->string('detail')->nullable();
            $table->string('on_shift')->nullable();
            $table->dateTime('shift_date')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::connection('sqlsrv')->dropIfExists('alc_normal');
    }
}
