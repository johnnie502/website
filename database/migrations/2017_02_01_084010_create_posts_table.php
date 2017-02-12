<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration 
{
	public function up()
	{
	    Schema::create('posts', function(Blueprint $table) {
                $table->increments('id');
                $table->integer('user')->unsigned()->index();
                $table->integer('post')->unsigned()->index();
                $table->integer('subpost')->unsigned()->nullable();
                $table->string('title')->nullable();
                $table->longText('content');
                $table->integer('type')->unsigned()->default(0)->index();
                $table->integer('status')->unsigned()->default(0)->index();
                $table->integer('favicons')->unsigned()->default(0);
                $table->integer('votes')->unsigned()->default(0);
                $table->datetime('moderated_at')->nullable();
                $table->integer('moderated_by')->nullable();
                $table->timestamps();
                $table->softDeletes();
            });
	}

	public function down()
	{
		Schema::drop('topics');
	}
}
