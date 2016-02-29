<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableFilesstore extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('filesstore', function (Blueprint $table) {
            $table->string('url', 200);
            $table->string('ext', 200);
            $table->integer('status')->default(1);
            $table->string('created_by', 50)->default('undefined');
            $table->integer('created_at');
            $table->unique(['url', 'ext']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('filesstore');
    }
}
