<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWaypointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('waypoints', function (Blueprint $table) {
            $table->uuid('id');
            $table->unsignedTinyInteger('kind');
            $table->string('city_code');
            $table->string('city_name');
            $table->string('address')->nullable();
            $table->unsignedInteger('good_id');
            $table->primary('id');
            $table->foreign('good_id')->references('id')->on('goods')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('waypoints');
    }
}
