<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShiftsTable extends Migration
{
    public function up()
    {
        Schema::connection('sqlsrv')->create('shifts', function (Blueprint $table) {
            $table->id();
            $table->string('department_id')->nullable();
            $table->string('name')->nullable();
            $table->string('time_start')->nullable();
            $table->string('time_end')->nullable();
            $table->string('desc')->nullable();
            $table->string('status')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::connection('sqlsrv')->dropIfExists('shifts');
    }
}
