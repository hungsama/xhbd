<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTagAndArticle extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tag_and_article', function (Blueprint $table) {
            $table->integer('tag_id');
            $table->integer('article_id');
            $table->string('tag_name', 100);
            $table->string('tag_alias', 100);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tag_and_article');
    }
}
