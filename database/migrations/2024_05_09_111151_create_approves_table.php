<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApprovesTable extends Migration
{

    public function up()
    {
        Schema::connection('sqlsrv')->create('approves', function (Blueprint $table) {
            $table->id();
            $table->integer('department_id')->nullable();
            $table->integer('line_id')->nullable();

            $table->string('on_shift')->nullable();
            $table->string('select')->nullable();
            $table->dateTime('shift_date')->nullable();
            $table->integer('user_sender_id')->nullable();
            $table->integer('user_approve_id')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::connection('sqlsrv')->dropIfExists('approves');
    }
}
