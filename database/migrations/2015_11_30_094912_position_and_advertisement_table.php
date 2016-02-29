<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PositionAndAdvertisementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('position_and_advertisement', function (Blueprint $table) {
        $table->integer('position_id');
        $table->integer('advertisement_id');
        $table->string('position_name', 200);
        $table->string('position_alias', 200);
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::drop('position_and_advertisement');
    }
}
