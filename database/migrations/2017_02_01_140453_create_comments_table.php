<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration 
{
    public function up()
    {
        Schema::create('comments', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('user')->unsigned()->default(0)->index();
            $table->integer('replyto')->unsigned()->default(0)->index();
            $table->text('content');
            $table->integer('type')->unsigned()->default(0)->index();
            $table->integer('status')->default(0)->index();
            $table->float('weight')->default(1.0)->unsigned()->index();
            $table->morphs('commentable');
            $table->timestampTz('moderated_at')->nullable();
            $table->integer('moderated_by')->nullable();
            $table->timestampsTz();;
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::drop('comments');
    }
}
