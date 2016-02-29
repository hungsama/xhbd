<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->increments('perm_id');
            $table->string('perm_name', 100)->default('');
            $table->string('action',100);
            $table->string('description', 300)->default('');
            $table->integer('status')->default(1);
            $table->string('created_by', 20)->default('');
            $table->string('updated_by', 20)->default('');
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
        Schema::drop('permissions');
    }
}
