<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoodSearchItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('good_search_items', function (Blueprint $table) {
            $table->uuid('id');
            $table->timestamps();
            $table->unsignedInteger('good_id');     // ID груза в поиске
            $table->date('load_date');              // Дата погрузки
            $table->date('load_date_to')->nullable();   // Дата погрузки по
            $table->float('weight');                // Вес
            $table->float('volume');                // Объем
            $table->string('subscriber_id');        // ID абонента
            // Город погрузки
            $table->string('loading_city_code');    // Город погрузки (код)
            $table->string('loading_city_name');    // Город погрузки (представление)
            $table->double('loading_city_latitude');    // Город погрузки (широта)
            $table->double('loading_city_longitude');    // Город погрузки (долгота)
            // Город разгрузки
            $table->string('unloading_city_code');  // Город разгрузки (код)
            $table->string('unloading_city_name');  // Город разгрузки (представление)
            $table->double('unloading_city_latitude');    // Город разгрузки (широта)
            $table->double('unloading_city_longitude');    // Город разгрузки (долгота)
            // Типы погрузки/разгрузки
            $table->unsignedTinyInteger('loading_types')->default(0);   // Типы погрузки (в битовой гребенке)
            $table->unsignedTinyInteger('unloading_types')->default(0); // Типы разгрузки (в битовой гребенке)
            $table->float('price')->nullable();         // Ставка
            $table->float('price_prepay')->nullable();  // Ставка предоплаты
            $table->unsignedTinyInteger('terms_pay')->nullable();   // Условия оплаты
            $table->unsignedTinyInteger('form_pay')->nullable();    // Форма оплаты
            $table->string('bodies_list');   // Типы кузовов представление
            $table->unsignedBigInteger('bodies')->default(0);  // Типы кузовов (битовая гребенка)
            // Внешние ключи
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
        Schema::dropIfExists('good_search_items');
    }
}
