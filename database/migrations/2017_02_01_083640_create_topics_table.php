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
                $table->integer('status')->unsigned()->default(0)->index();
                $table->integer('views')->unsigned()->default(0);
                $table->integer('replies')->unsigned()->default(0);
                $table->integer('lastreply')->unsigned()->default(0)->nullable();
                $table->datetime('replytime')->nullable();
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
