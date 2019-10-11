<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('password');
            $table->string('f_name');
            $table->string('l_name');
            $table->string('email');
            $table->integer('phone_number');
            $table->integer('role_id')->unsigned();
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();

            $table->foreign('role_id')->references('id')->on('user_roles')
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
        Schema::dropIfExists('users');
    }
}
