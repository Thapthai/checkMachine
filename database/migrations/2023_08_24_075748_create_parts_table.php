<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('sqlsrv')->create('parts', function (Blueprint $table) {
            $table->id();
            $table->integer('machines_id');
            $table->string('name');
            $table->string('detail')->nullable();
            $table->string('type')->nullable();
            $table->string('position')->nullable();
            $table->string('pic1')->nullable();
            $table->string('pic2')->nullable();
            $table->string('pic3')->nullable();
            $table->string('todo')->nullable();
            $table->string('sequence')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::connection('sqlsrv')->dropIfExists('parts');
    }
};
