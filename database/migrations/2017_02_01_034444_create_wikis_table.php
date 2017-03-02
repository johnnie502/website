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
            $table->integer('node')->unsigned()->default(0)->index();
            $table->string('title');
            $table->longtext('content');
            $table->integer('type')->unsigned()->default(0)->index();
            $table->integer('status')->default(0)->index();
            $table->integer('version')->default(0)->index();
            $table->integer('redirect')->unsigned()->default(0)->index();
            $table->integer('views')->unsigned()->default(0);
            $table->integer('edits')->unsigned()->default(0)->index();
            $table->integer('lastedit')->unsigned()->default(0);
            $table->integer('favicons')->unsigned()->defaul(0);
            $table->timestamps();
            $table->softDeletes();
        });
	}

	public function down()
	{
		Schema::drop('wikis');
	}
}
