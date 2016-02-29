<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupPermissonTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_permission', function (Blueprint $table) {
            $table->integer('group_id');
            $table->string('group_name',100);
            $table->string('action_desc',100)->default('');
            $table->string('action_name', 300)->default('');
            $table->string('method', 10)->default('');
            $table->unique(['action_name', 'method']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('group_permission');
    }
}
