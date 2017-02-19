<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilesTable extends Migration 
{
    public function up()
    {
        Schema::create('files', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('user')->unsigned()->index();
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('path');
            $table->float('size');
            $table->integer('type')->unsigned()->default(0)->index();
            $table->integer('ststus')->default(0)->index();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::drop('files');
    }
}
