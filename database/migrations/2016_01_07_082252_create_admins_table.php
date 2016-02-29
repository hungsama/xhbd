<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->increments('admin_id');
            $table->string('admin_name', 100);
            $table->string('admin_alias',100);
            $table->string('password',100);
            $table->string('hash',10);
            $table->string('email',100)->default('');
            $table->string('description', 300)->default('');
            $table->enum('role', ['root', 'admin', 'limited'])->default('limited');
            $table->integer('status')->default(1);
            $table->integer('group_id')->default(0);
            $table->string('created_by', 50)->default('');
            $table->string('updated_by', 50)->default('');
            $table->integer('created_at');
            $table->integer('update_at')->default(0);
            $table->unique(['admin_id', 'group_id']);
            $table->unique(['admin_name']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('admins');
    }
}
