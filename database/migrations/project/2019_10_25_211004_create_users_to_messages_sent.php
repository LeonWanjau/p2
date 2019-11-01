<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersToMessagesSent extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_to_messages_sent', function (Blueprint $table) {
            $table->integer('message_id')->unsigned();
            $table->integer('user_id')->unsigned();

            $table->primary(['message_id','user_id']);
            $table->foreign('message_id')->references('id')->on('users_messages_sent')
            ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('user_id')->references('id')->on('users')
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
        Schema::dropIfExists('users_to_messages_sent');
    }
}
