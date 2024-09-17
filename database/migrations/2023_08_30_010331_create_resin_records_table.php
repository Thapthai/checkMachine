<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::connection('sqlsrv')->create('resin_records', function (Blueprint $table) {

            $table->id();
            $table->integer('machines_id')->nullable();
            $table->integer('resins_id')->nullable();
            $table->string('sequence')->nullable();
            $table->string('status')->nullable();
            $table->string('clean')->nullable();

            $table->string('by_user')->nullable();
            $table->string('on_shift')->nullable();
            $table->string('check_in')->nullable();

            $table->string('detail')->nullable();
            $table->string('pic1')->nullable();
            $table->string('pic2')->nullable();
            $table->string('pic3')->nullable();
            $table->string('repair_date')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::connection('sqlsrv')->dropIfExists('resin_records');
    }
};