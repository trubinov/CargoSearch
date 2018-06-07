<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrucksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trucks', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->softDeletes();
            $table->string('subscriber_id');
            $table->date('available_date'); // Предполагаемая дата, когда машина освобождается
            $table->string('city_code');
            $table->string('city_name');
            $table->double('city_latitude');
            $table->double('city_longitude');
            $table->string('city_name2')->nullable();
            $table->unsignedInteger('body_type');
            $table->float('weight');
            $table->float('volume');
            $table->string('organization');
            $table->string('organization_inn');
            $table->string('manager');
            $table->string('manager_icq');
            $table->string('phones');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trucks');
    }
}
