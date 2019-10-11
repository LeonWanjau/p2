<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParentsStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parents_students', function (Blueprint $table) {
            $table->integer('parent_id')->unsigned();
            $table->integer('student_id')->unsigned();

            $table->primary(['parent_id','student_id']);
            $table->foreign('parent_id')->references('id')->on('parents')
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
        Schema::dropIfExists('parents_students');
    }
}
