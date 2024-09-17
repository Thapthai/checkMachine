<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApproveDetailsTable extends Migration
{

    public function up()
    {
        Schema::connection('sqlsrv')->create('approve_details', function (Blueprint $table) {
            $table->id();

            $table->integer('approve_id')->nullable();
            $table->integer('machine_id')->nullable();
            $table->integer('resin_record_id')->nullable();
            $table->integer('part_record_id')->nullable();
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::connection('sqlsrv')->dropIfExists('approve_details');
    }
}
