<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableArticles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 250);
            $table->string('title_alias', 250);
            $table->text('content');
            $table->string('url_video', 250)->default('');
            $table->string('type', 20)->default('');
            $table->string('category_id', 250)->default('"a:0:{}"');
            $table->string('special', 250)->default('"a:1:{i:0;s:8:\"ordinary\";}"');
            $table->string('author', 50)->default('xahoibongda.com');
            $table->string('tag', 250)->default('"a:0:{}"');
            $table->integer('status')->default(1);
            $table->string('create_by', 50)->default('undefined');
            $table->string('update_by', 50)->default('');
            $table->integer('created_at');
            $table->integer('update_at')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('articles');
    }
}
