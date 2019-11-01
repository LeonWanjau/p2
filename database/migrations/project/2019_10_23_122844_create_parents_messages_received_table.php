<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParentsMessagesReceivedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parents_messages_received', function (Blueprint $table) {
            $table->increments('id');
            $table->string('msg_id');
            $table->text('message');
            $table->string('intent');
            $table->integer('parent_id')->unsigned();
            $table->dateTime('date_received');
            $table->timestamps();

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
        Schema::dropIfExists('parents_messages_received');
    }
}
