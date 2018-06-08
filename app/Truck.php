<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Truck extends Model
{

    use SoftDeletes;

    protected $fillable = [
        'subscriber_id', 'city_code', 'city_name', 'city_latitude', 'city_longitude', 'city_name2',
        'weight', 'volume', 'organization', 'organization_inn',
        'manager', 'manager_icq', 'phones'
    ];

    protected $dates = ['deleted_at'];

    public function searchItems()
    {
        return $this->hasMany(TruckSearchItem::class);
    }

}
