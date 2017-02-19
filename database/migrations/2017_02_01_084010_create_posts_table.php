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
                $table->integer('subpost')->unsigned()->default(0);
                $table->longText('content');
                $table->integer('type')->unsigned()->default(0)->index();
                $table->integer('status')->default(0)->index();
                $table->integer('replyto')->unsigned()->default(0)->index();
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
