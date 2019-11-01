<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('teacher_id')->unsigned();
            $table->string('text');
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->string('rec_type')->nullable();
            $table->bigInteger('event_length')->nullable()->default(null);;
            $table->string('event_pid')->nullable();
            $table->integer('parent_id')->unsigned()->nullable();
            $table->timestamps();

            $table->foreign('teacher_id')->references('id')->on('users')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('parent_id')->references('id')->on('parents')
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
        Schema::dropIfExists('events');
    }
}
