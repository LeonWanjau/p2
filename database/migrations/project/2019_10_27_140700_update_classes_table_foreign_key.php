<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateClassesTableForeignKey extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('students', function (Blueprint $table) {

            $table->integer('mother_id')->unsigned()->nullable();
            $table->integer('father_id')->unsigned()->nullable();

            $table->dropForeign(['class_id']);

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
        Schema::table('students', function (Blueprint $table) {

            $table->dropColumn('mother_id');
            $table->dropColumn('father_id');

            $table->dropForeign(['class_id']);

            $table->foreign('class_id')->references('id')
                ->on('classes');
        });
    }
}
