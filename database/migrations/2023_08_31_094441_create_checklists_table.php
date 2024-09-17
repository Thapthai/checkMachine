<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up()
    {
        Schema::connection('sqlsrv')->create('checklists', function (Blueprint $table) {
            $table->id();
            $table->string('type')->nullable();
            $table->integer('seq')->nullable();
            $table->string('name')->nullable();
            $table->string('desc')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::connection('sqlsrv')->dropIfExists('resin_records');
    }
};
