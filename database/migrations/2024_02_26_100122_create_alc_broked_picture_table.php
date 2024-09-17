<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlcBrokedPictureTable extends Migration
{

    public function up()
    {
        Schema::connection('sqlsrv')->create('alc_broked_picture', function (Blueprint $table) {
            $table->id();
            $table->integer('alc_broked_id');
            $table->string('path');

            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::connection('sqlsrv')->dropIfExists('alc_broked_picture');
    }
}
