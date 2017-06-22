<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTopicsTable extends Migration 
{
	public function up()
	{
	    Schema::create('topics', function(Blueprint $table) {
                $table->increments('id');
                $table->integer('user')->unsigned()->default(0)->index();
                $table->integer('node')->unsigned()->default(0)->index();
                $table->string('title');
                $table->integer('type')->unsigned()->default(0)->index();
                $table->integer('status')->default(0)->index();
                $table->integer('view_count')->unsigned()->default(0);
                $table->integer('reply_count')->unsigned()->default(0);
                $table->integer('lastreply')->unsigned()->default(0)->nullable();
                $table->integer('comment_count')->unsigned()->default(0);
                $table->timestampTz('replied_at')->nullable();
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
