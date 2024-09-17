<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up()
    {
        Schema::connection('sqlsrv')->create('resins', function (Blueprint $table) {

            $table->id();
            $table->integer('machines_id');
            $table->string('sequence')->nullable();
            $table->string('detail')->nullable();
            $table->string('material')->nullable();
            $table->string('color')->nullable();

            $table->string('position')->nullable();
            $table->string('pic1')->nullable();
            $table->string('pic2')->nullable();
            $table->string('pic3')->nullable();
            $table->string('total_resin')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::connection('sqlsrv')->dropIfExists('resins');
    }
};
