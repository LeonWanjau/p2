<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateYearClassStudentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('year_class_student', function (Blueprint $table) {
            $table->integer('year')->unsigned();
            $table->integer('class_id')->unsigned();
            $table->integer('student_id')->unsigned();

            $table->primary(['year','class_id','student_id']);
            $table->foreign('class_id')->references('id')->on('classes')
            ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('student_id')->references('id')->on('students')
            ->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('year_class_student');
    }
}
