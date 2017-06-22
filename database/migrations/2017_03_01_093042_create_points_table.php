<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePointsTable extends Migration 
{
	public function up()
	{
                  Schema::create('points', function(Blueprint $table) {
                      $table->increments('id');
                      $table->integer('user')->unsigned()->default(0)->index();
                      $table->integer('type')->unsigned()->default(0)->index();
                      $table->integer('point')->default(0)->index();
                      $table->integer('total_points')->unsigned()->default(0)->index();
                      $table->timestamp('got_at');
                  });
	}

	public function down()
	{
		Schema::drop('points');
	}
}
