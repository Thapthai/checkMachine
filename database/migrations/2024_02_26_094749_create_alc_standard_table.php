<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlcStandardTable extends Migration
{
    public function up()
    {
        Schema::connection('sqlsrv')->create('alc_standard', function (Blueprint $table) {
            $table->id();
            $table->integer('department_id');
            $table->integer('line_id');
            $table->string('name')->nullable();
            $table->string('type')->nullable();
            $table->float('quantity')->nullable();
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::connection('sqlsrv')->dropIfExists('alc_standard');
    }
}
