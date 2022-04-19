<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBorrowedbooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('borrowedbooks', function (Blueprint $table) {
            $table->bigIncrements('booksborrowId');
            $table->bigInteger('UserId_fk')->unsigned();
            $table->foreign('UserId_fk')->references('id')->on('users')->onUpdate('cascade');
            $table->bigInteger('booksId_fk')->unsigned();
            $table->foreign('booksId_fk')->references('booksId')->on('books')->onUpdate('cascade');
            $table->bigInteger('studentId_fk')->unsigned();
            $table->foreign('studentId_fk')->references('studentId')->on('students')->onUpdate('cascade');
            $table->date('borrow_date')->nullable();
            $table->date('return_date')->nullable();
            $table->integer('isReturned')->nullable();
            $table->integer('return_request')->nullable();
            $table->integer('reply_return_request')->nullable();
            $table->integer('isRequested');
            $table->date('request_date');
            $table->integer('isAccepted')->nullable();
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
        Schema::dropIfExists('borrowedbooks');
    }
}
