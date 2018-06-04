<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goods', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->softDeletes();
            $table->uuid('good_uid')->unique();  // UUID документа-регистратора
            $table->date('load_date');      // Дата погрузки
            $table->float('weight');        // Вес
            $table->float('volume');        // Объем
            $table->string('subscriber_id');    // ID абонента
            $table->string('body_type')->nullable();    // Тип кузова (наименование)
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
            $table->date('load_date_to')->nullable();   // Дата погрузки по
            $table->string('organization'); // Организация
            $table->string('organization_inn'); // ИНН организации
            $table->string('manager');      // Менеджер
            $table->string('manager_contacts'); // Контакты менеджера
            $table->string('manager_icq')->nullable(); // ICQ менеджера
            $table->string('manager1')->nullable();     // Менеджер 1
            $table->string('manager1_contacts')->nullable(); // Контакты менеджера 1
            $table->string('manager1_icq')->nullable(); // ICQ менеджера 1
            $table->string('description');  // Описание груза
            $table->unsignedSmallInteger('truck_count'); // Количество машин
            $table->float('price')->nullable();         // Ставка
            $table->unsignedTinyInteger('due_date_val')->nullable();    // Срок оплаты
            $table->string('currency_code_prepay')->nullable(); // Валюта предоплаты
            $table->string('currency_code')->nullable();    // Валюта
            $table->float('price_prepay')->nullable();  // Ставка предоплаты
            $table->unsignedSmallInteger('belts_count')->nullable(); // Количество ремней
            $table->boolean('conics')->nullable();      // Коники
            $table->boolean('airway')->nullable();      // Пневмоход
            $table->boolean('coupling')->nullable();    // Сцепка
            $table->boolean('medical_book')->nullable();    // Медкнижка
            $table->boolean('cmr')->nullable();         // CMR
            $table->boolean('tir')->nullable();         // TIR
            $table->boolean('t1')->nullable();          // T1
            $table->string('loading_address')->nullable();  // Адрес погрузки (улица, район)
            $table->string('unloading_address')->nullable();    // Адрес разгрузки (улица, район)
            $table->float('length')->nullable();        // Длина
            $table->float('width')->nullable();         // Ширина
            $table->float('height')->nullable();        // Высота
            $table->unsignedTinyInteger('adr')->nullable(); // ADR
            $table->boolean('consolidated')->nullable();    // Сборный груз
            $table->string('package')->nullable();      // Упаковка
            $table->unsignedTinyInteger('terms_prepay')->nullable();    // Условия оплаты (предоплата)
            $table->unsignedTinyInteger('form_prepay')->nullable();    // Форма оплаты (предоплата)
            $table->unsignedTinyInteger('due_date_prepay')->nullable(); // Срок оплаты (предоплата)
            $table->boolean('treat_price')->nullable(); // Ставка договорная
            $table->boolean('bargain_available')->nullable();   // Возможен торг
            $table->boolean('loading_weekend')->nullable();     // Погрузка в выходные
            $table->boolean('unloading_weekend')->nullable();   // Разгрузка в выходные
            $table->boolean('loading_aroundtheclock')->nullable();  // Погрузка круглосуточно
            $table->boolean('unloading_aroundtheclock')->nullable();    // Разгрузка круглосуточно
            $table->unsignedTinyInteger('terms_pay')->nullable();   // Условия оплаты
            $table->unsignedTinyInteger('form_pay')->nullable();    // Форма оплаты
            // .. Габариты - поле нужно сформировать динамически
            // .. Количество машин строка  - поле нужно сформировать динамически
            $table->string('additional_params')->nullable();    // Дополнительные параметры
            // .. Ремни строка - поле нужно сформировать динамически
            // .. Дата погрузки строка - поле нужно сформировать динамически
            // .. ADR строка - поле нужно сформировать динамически
            $table->string('manager_work_phone')->nullable();   // Рабочий телефон менеджера
            $table->string('manager1_work_phone')->nullable();  // Рабочий телефон менеджера 1
            $table->string('tariff_code')->nullable();  // Код тарифного плана (строка)
            // .. Вес/объем - поле нужно сформировать динамически
            $table->float('distance')->nullable();  // Километраж маршрута (расстояние)
            $table->string('bodies_list');   // Типы кузовов представление
            $table->unsignedBigInteger('bodies')->default(0);  // Типы кузовов (битовая гребенка)
            $table->string('source')->nullable(); // Источник
            $table->boolean('quickly')->nullable(); // Срочно
            $table->boolean('constantly')->nullable();  // Постоянно
            $table->unsignedSmallInteger('package_count')->nullable();  // Количество упаковок
            $table->unsignedTinyInteger('afterload')->nullable();   // Выбор загрузки (отдельно или догрузом)
            $table->tinyInteger('temp_from')->nullable();   // Температурный режим (от)
            $table->tinyInteger('temp_to')->nullable();     // Температурный режим (до)
            $table->time('loading_time_from')->nullable();  // Время погрузки с
            $table->time('loading_time_to')->nullable();    // Время погрузки по
            $table->time('unloading_time_from')->nullable();    // Время разгрузки с
            $table->time('unloading_time_to')->nullable();      // Время разгрузки по
            $table->boolean('circle')->nullable();  // Кругорейс
            $table->string('comment')->nullable();  // Комментарий
            $table->boolean('direct_contract')->nullable();     // Прямой договор
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('goods');
    }
}
