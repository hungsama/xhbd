<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoryAndArticle extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_and_article', function (Blueprint $table) {
            $table->integer('category_id');
            $table->integer('article_id');
            $table->string('category_name', 200);
            $table->string('category_alias', 200);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('category_and_article');
    }
}
