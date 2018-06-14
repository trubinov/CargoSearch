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
            $table->uuid('doc_uid')->unique();
            $table->string('subscriber_id');
            $table->date('available_date'); // Предполагаемая дата, когда машина освобождается
            $table->string('city_code');
            $table->string('city_name');
            $table->double('city_latitude');
            $table->double('city_longitude');
            $table->string('city_name2')->nullable();
            $table->string('body_type_name');
            $table->unsignedInteger('body_type');
            $table->float('weight');
            $table->float('volume');
            $table->float('length')->nullable();
            $table->float('width')->nullable();
            $table->float('height')->nullable();
            $table->string('organization');
            $table->string('organization_inn');
            $table->string('organization_contacts');
            $table->string('manager');
            $table->string('manager_icq');
            $table->string('manager_contacts');
            $table->string('manager_work_phone')->nullable();
            $table->string('driver_name');
            $table->string('truck_num');
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
