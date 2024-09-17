<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::connection('sqlsrv')->create('checklist_plans', function (Blueprint $table) {
            $table->id();
            $table->integer('checklists_id')->nullable();
            $table->integer('parts_id')->nullable();
            $table->string('detail')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::connection('sqlsrv')->dropIfExists('checklist_plans');
    }
};
