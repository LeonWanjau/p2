<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParentsToMessagesSentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parents_to_messages_sent', function (Blueprint $table) {
            
            $table->integer('message_id')->unsigned();
            $table->integer('parent_id')->unsigned();

            $table->primary(['message_id','parent_id']);
            $table->foreign('message_id')->references('id')->on('parents_messages_sent')
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
        Schema::dropIfExists('parents_to_messages_sent');
    }
}
