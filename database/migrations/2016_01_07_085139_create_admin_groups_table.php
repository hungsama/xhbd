<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_groups', function (Blueprint $table) {
            $table->increments('group_id');
            $table->string('group_name', 100);
            $table->string('group_alias',100);
            $table->string('description', 300)->default('');
            $table->integer('status')->default(1);
            $table->string('created_by', 20)->default('');
            $table->string('update_by', 20)->default('');
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
        Schema::drop('admin_groups');
    }
}
