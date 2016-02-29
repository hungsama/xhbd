<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdvertisersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('advertisers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100);
            $table->string('descriptions', 250);
            $table->string('mobile', 100);
            $table->string('email', 50);
            $table->string('adress', 300);
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
        Schema::drop('advertisers');
    }
}
