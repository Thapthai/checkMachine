<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlcBottlesTable extends Migration
{
    public function up()
    {
        Schema::connection('sqlsrv')->create('alc_bottles', function (Blueprint $table) {
            $table->id();

            $table->string('bottle_no')->nullable();
            $table->string('name')->nullable();
            $table->string('type')->nullable();
            $table->integer('department_id')->nullable();
            $table->integer('line_id')->nullable();
            $table->float('volume')->nullable();
            $table->string('status');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::connection('sqlsrv')->dropIfExists('alc_bottles');
    }
}
