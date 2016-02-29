<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdvertisementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('advertisements', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 250);
            $table->string('name_alias', 250);
            $table->string('note', 250);
            $table->string('url_image', 250);
            $table->string('url_redirect', 250);
            $table->integer('advertiser_id');
            $table->integer('position_id');
            $table->integer('time_start');
            $table->integer('time_end');
            $table->enum('mode', ['limited', 'unlimited']);
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
        Schema::drop('advertisements');
    }
}
