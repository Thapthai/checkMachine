<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScheduleRecordsTable extends Migration
{
    public function up()
    {
        Schema::connection('mysql2')->create('schedule_records', function (Blueprint $table) {
            $table->id();
            $table->integer('schedule_plan_id')->nullable();
            $table->integer('resin_id')->nullable();
            $table->string('complete')->nullable();
            $table->string('clean')->nullable();
            $table->string('by_user')->nullable();
            $table->string('on_shift')->nullable();
            $table->string('check_in')->nullable();
            $table->date('shift_date')->nullable();
            $table->string('detail')->nullable();
            $table->string('pic1')->nullable();
            $table->string('pic2')->nullable();
            $table->string('pic3')->nullable();
            $table->string('status')->nullable();
            $table->string('repair_date')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::connection('mysql2')->dropIfExists('schedule_records');
    }
}
