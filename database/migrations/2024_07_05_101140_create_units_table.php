<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUnitsTable extends Migration
{

    public function up()
    {
        Schema::connection('sqlsrv')->create('units', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('desc')->nullable();
            $table->string('status');
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::connection('sqlsrv')->dropIfExists('units');
    }
}
