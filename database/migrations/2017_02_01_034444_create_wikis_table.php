<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWikisTable extends Migration 
{
	public function up()
	{
		Schema::create('wikis', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('user')->unsigned()->default(0)->index();
            $table->string('title');
            $table->string('description')->nullable();
            $table->longtext('content');
            $table->integer('type')->unsigned()->default(0)->index();
            $table->integer('status')->default(0)->index();
            $table->integer('version')->default(0)->index();
            $table->integer('redirect')->unsigned()->default(0)->index();
            $table->integer('view_count')->unsigned()->default(0);
            $table->integer('edit_count')->unsigned()->default(0)->index();
            $table->integer('comment_count')->unsigned()->default(0);
            $table->integer('lastedit')->unsigned()->default(0);
            $table->integer('favicon_count')->unsigned()->default(0);
            $table->timestampsTz();;
            $table->softDeletes();
        });
	}

	public function down()
	{
		Schema::drop('wikis');
	}
}
