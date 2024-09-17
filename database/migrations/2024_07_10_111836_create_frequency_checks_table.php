<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFrequencyChecksTable extends Migration
{

    public function up()
    {
        Schema::connection('mysql2')->create('frequency_checks', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::connection('mysql2')->dropIfExists('frequency_checks');
    }
}
