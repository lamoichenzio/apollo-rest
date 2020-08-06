<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->string('username');
            $table->string('password');
            $table->string('email')->unique();
            $table->string('firstname')->nullable();
            $table->string('lastname')->nullable();
            $table->binary('pic')->nullable();
            $table->unsignedBigInteger('role_id');
            $table->timestamps();
        });

        Schema::create('roles', function(Blueprint $table){
           $table->id();
           $table->string('name');
           $table->string('description');
           $table->timestamps();
        });

        Schema::table('users', function (Blueprint $table){
            $table->foreign('role_id')
                ->references('id')
                ->on('roles')
                ->onDelete('cascade')
                ->onUpdate('cascade');
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
        Schema::dropIfExists('roles');
    }
}
