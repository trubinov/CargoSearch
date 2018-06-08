<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTruckSearchItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('truck_search_items', function (Blueprint $table) {
            $table->uuid('id');
            $table->timestamps();
            $table->unsignedInteger('truck_id');
            $table->string('subscriber_id');
            $table->date('available_date'); // Предполагаемая дата, когда машина освобождается
            $table->string('city_code');
            $table->string('city_name');
            $table->double('city_latitude');
            $table->double('city_longitude');
            $table->unsignedInteger('body_type');
            $table->float('weight');
            $table->float('volume');
            // Внешние ключи
            $table->foreign('truck_id')->references('id')->on('trucks')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('truck_search_items');
    }
}
