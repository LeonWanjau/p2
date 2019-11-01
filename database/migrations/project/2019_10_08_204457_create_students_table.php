<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->string('f_name');
            $table->string('l_name');
            $table->integer('age')->unsigned();
            $table->integer('class_id')->unsigned();
            $table->integer('mother_id')->unsigned()->nullable();
            $table->integer('father_id')->unsigned()->nullable();

            $table->foreign('class_id')->references('id')
                ->on('classes')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('mother_id')->references('id')
                ->on('parents')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('father_id')->references('id')
                ->on('parents')->onDelete('cascade')->onUpdate('cascade');
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
