<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlcUsageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('sqlsrv')->create('alc_usage', function (Blueprint $table) {
            $table->id();
            $table->integer('alc_standard_id');
            $table->string('used_quantity')->nullable();

            $table->string('on_shift')->nullable();
            $table->dateTime('shift_date')->nullable();

            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::connection('sqlsrv')->dropIfExists('alc_usage');
    }
}
