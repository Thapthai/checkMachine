<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlcUsageBottlesTable extends Migration
{

    public function up()
    {
        Schema::connection('sqlsrv')->create('alc_usage_bottles', function (Blueprint $table) {
            $table->id();
            $table->integer('alc_bottle_id');
            $table->integer('alc_usage_id');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::connection('sqlsrv')->dropIfExists('alc_usage_bottles');
    }
}
