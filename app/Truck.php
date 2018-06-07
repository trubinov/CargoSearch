<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Truck extends Model
{

    use SoftDeletes;

    protected $fillable = [
        'subscriber_id', 'available_date', 'city_code', 'city_name', 'city_latitude', 'city_longitude', 'city_name2',
        'body_type', 'weight', 'volume', 'organization', 'organization_inn',
        'manager', 'manager_icq', 'phones'
    ];

    protected $dates = ['deleted_at'];

}
