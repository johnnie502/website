<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSignedTable extends Migration 
{
	public function up()
	{
                  Schema::create('signed', function(Blueprint $table) {
                      $table->increments('id');
                      $table->integer('user')->unsigned()->default(0)->index();
                      $table->integer('points')->unsigned()->default(0)->index();
                      $table->timestamp('signed_at');
                  });
	}

	public function down()
	{
		Schema::drop('comments');
	}
}
