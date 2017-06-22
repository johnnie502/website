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
            $table->string('banner')->nullable();
            $table->string('description')->nullable();
            $table->integer('type')->unsigned()->default(0)->index();
            $table->integer('status')->default(0)->index();
            $table->rememberToken();
            $table->integer('point_count')->unsigned()->default(0);
            $table->integer('notification_count')->unsigned()->default(0);
            $table->ipAddress('regip')->nullable();
            $table->ipAddress('lastip')->nullable();
            $table->integer('topic_count')->unsigned()->default(0);
            $table->integer('reply_count')->unsigned()->default(0);
            $table->integer('wiki_count')->unsigned()->default(0);
            $table->integer('signed')->unsigned()->default(0)->index();
            $table->integer('follwers')->unsigned()->default(0);
            $table->integer('follwing')->unsigned()->default(0);
            $table->integer('vote_count')->unsigned()->default(0);
            $table->timestampsTz();;
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
