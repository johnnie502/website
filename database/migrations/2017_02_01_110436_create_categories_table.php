<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTable extends Migration 
{
    public function up()
    {
        Schema::create('categroies', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('slug');
            $table->integer('type')->unsigned()->default(0)->index();
            $table->integer('status')->default(0)->index();
            $table->integer('parent')->unsigned()->nullable()->index();
            $table->text('description')->nullable();
            $table->integer('wiki')->unsigned()->default(0);
            $table->timestamps();
            $table->softDeletes();
      });
    }

    public function down()
    {
        Schema::drop('categories');
    }
}
