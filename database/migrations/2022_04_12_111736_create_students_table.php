<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->bigIncrements('studentId');
            $table->bigInteger('userId_fk')->unsigned();
            $table->foreign('userId_fk')->references('id')->on('users')->onUpdate('cascade');
            $table->string('reg_num');
            $table->integer('departmentId_fk')->unsigned();
            $table->foreign('departmentId_fk')->references('departmentId')->on('departments')->onUpdate('cascade');
            $table->string('year');
            $table->string('semester');
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
        Schema::dropIfExists('students');
    }
}
