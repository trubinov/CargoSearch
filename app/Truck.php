<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Truck extends Model
{

    use SoftDeletes;

    protected $fillable = [
        'doc_uid', 'subscriber_id', 'city_code', 'city_name', 'city_latitude', 'city_longitude', 'city_name2',
        'weight', 'volume', 'organization', 'organization_inn', 'organization_contacts',
        'manager', 'manager_icq', 'manager_contacts', 'manager_work_phone', 'driver_name', 'truck_num',
    ];

    protected $dates = ['deleted_at'];

    public function searchItems()
    {
        return $this->hasMany(TruckSearchItem::class);
    }

}
