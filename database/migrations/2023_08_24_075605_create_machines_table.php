<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('sqlsrv')->create('machines', function (Blueprint $table) {
            $table->id();
            $table->integer('department_id');
            $table->integer('line_id');
            $table->string('name')->nullable();
            $table->string('detail')->nullable();
            $table->string('status')->nullable();
            $table->string('pic1')->nullable();
            $table->string('pic2')->nullable();
            $table->string('pic3')->nullable();
            $table->string('pic4')->nullable();
            $table->string('pic5')->nullable();
            $table->string('pic6')->nullable();
            $table->string('pic7')->nullable();
            $table->string('pic8')->nullable();
            $table->string('pic9')->nullable();
            $table->string('pic10')->nullable();
            $table->string('sequence');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('sqlsrv')->dropIfExists('machines');
    }
};
