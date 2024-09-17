<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRepairsTable extends Migration
{
    public function up()
    {
        Schema::connection('sqlsrv')->create('repairs', function (Blueprint $table) {
            $table->id();
            $table->integer('parts_id')->nullable();
            $table->integer('part_record_id')->nullable();

            $table->integer('resins_id')->nullable();
            $table->integer('resin_record_id')->nullable();

            $table->integer('departments_id')->nullable();
            $table->integer('line_id')->nullable();
            $table->integer('machines_id')->nullable();

            $table->string('status')->nullable();
            $table->string('by_user')->nullable();
            $table->string('on_shift')->nullable();
            $table->string('detail')->nullable();

            $table->string('pic_before')->nullable();
            $table->string('pic_after')->nullable();
            $table->string('pic')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::connection('sqlsrv')->dropIfExists('repairs');
    }
}
