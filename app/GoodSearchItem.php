<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class GoodSearchItem
 *
 * Модель результатов поиска. Полями этой модели должны быть такие же поля из модели Груза,
 * но только те, по которым осуществляется поиск.
 * В таблице этой модели должны храниться только актуальные грузы, неактуальные должны периодически удаляться.
 *
 * @package App
 */
class GoodSearchItem extends Model
{

    public $incrementing = false;

    protected $fillable = [
        'load_date', 'load_date_to', 'weight', 'volume', 'subscriber_id',
        'loading_city_code', 'loading_city_name', 'loading_city_latitude', 'loading_city_longitude',
        'unloading_city_code', 'unloading_city_name', 'unloading_city_latitude', 'unloading_city_longitude',
        'loading_types', 'unloading_types', 'price', 'price_prepay', 'terms_pay', 'form_pay',
        'bodies_list', 'bodies'
    ];

    public function good()
    {
        return $this->belongsTo(Good::class);
    }

}
