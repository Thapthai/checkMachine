<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScheduleApproveTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {


        Schema::connection('mysql2')->create('approve', function (Blueprint $table) {

            $table->id();
            $table->integer('schedule_record_id')->nullable();
            $table->string('status')->nullable();
            $table->string('detail')->nullable();
            $table->string('user_approve')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {

        Schema::connection('mysql2')->dropIfExists('approve');
    }
}
