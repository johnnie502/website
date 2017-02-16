<?php

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
            $table->increments('id')->unsigned();
            $table->string('driver')->nullable();
            $table->integer('oauth')->nullable()->unsigned();
            $table->string('username')->unique()->index();
            $table->string('email')->unique();
            $table->string('password');
            $table->integer('type')->unsigned()->default(0)->index();
            $table->integer('status')->default(0)->index();
            $table->rememberToken();
            $table->integer('points')->unsigned()->default(0);
            $table->integer('notifications')->unsigned()->default(0);
            $table->string('regip')->nullable();
            $table->string('lastip')->nullable();
            $table->integer('topics')->unsigned()->default(0);
            $table->integer('replies')->unsigned()->default(0);
            $table->integer('wiki')->unsigned()->default(0);
            $table->integer('follers')->unsigned()->default(0);
            $table->integer('follwing')->unsigned()->default(0);
            $table->integer('votes')->unsigned()->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
