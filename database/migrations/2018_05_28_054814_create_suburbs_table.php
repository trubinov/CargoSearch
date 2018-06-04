<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSuburbsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suburbs', function (Blueprint $table) {
            $table->uuid('id');
            $table->unsignedTinyInteger('kind');
            $table->string('code');
            $table->string('name');
            $table->double('latitude');    // Широта
            $table->double('longitude');   // Долгота
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
        Schema::dropIfExists('suburbs');
    }
}
