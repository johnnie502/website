<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration 
{
	public function up()
	{
	    Schema::create('posts', function(Blueprint $table) {
                $table->increments('id');
                $table->integer('user')->unsigned()->default(0)->index();
                $table->integer('post')->unsigned()->default(0)->index();
                $table->integer('topic')->unsigned()->default(0);
                $table->longText('content');
                $table->integer('type')->unsigned()->default(0)->index();
                $table->integer('status')->default(0)->index();
                $table->integer('edit_count')->unsigned()->default(0);
                $table->integer('comment_count')->unsigned()->default(0);
                $table->integer('favicon_count')->unsigned()->default(0);
                $table->integer('upvote_count')->unsigned()->default(0);
                $table->integer('downvote_count')->unsigned()->default(0);
                $table->timestampTz('moderated_at')->nullable();
                $table->integer('moderated_by')->nullable();
                $table->timestampsTz();;
                $table->softDeletes();
            });
	}

	public function down()
	{
		Schema::drop('topics');
	}
}
