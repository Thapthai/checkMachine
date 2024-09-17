<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('sqlsrv')->create('users', function (Blueprint $table) {
            $table->id();
            $table->integer('is_admin')->nullable();
            $table->string('username')->unique();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('line_id')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->integer('department_id');
            $table->rememberToken();
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
        Schema::connection('sqlsrv')->dropIfExists('users');
    }
}
