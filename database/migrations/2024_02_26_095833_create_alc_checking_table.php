<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlcCheckingTable extends Migration
{

    public function up()
    {
        Schema::connection('sqlsrv')->create('alc_checking', function (Blueprint $table) {
            $table->id();
            $table->integer('alc_usage_id');
            $table->float('quantity_alc_usage');
            $table->float('quantity_alc_broked');
            $table->string('on_shift')->nullable();
            $table->dateTime('shift_date')->nullable();
            $table->string('status')->nullable();
            $table->string('detail')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::connection('sqlsrv')->dropIfExists('alc_checking');
    }
}
