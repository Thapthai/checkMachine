<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchedulePlansTable extends Migration
{

    public function up()
    {
        Schema::connection('mysql2')->create('schedule_plans', function (Blueprint $table) {
            $table->id();
            $table->integer('line_id');
            $table->integer('machine_id');
            $table->integer('frequency_check_id');
            $table->integer('resin_id');
            $table->string('define');

            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::connection('mysql2')->dropIfExists('schedule_plans');
    }
}
