<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TruckSearchItem extends Model
{

    public $incrementing = false;

    protected $perPage = 50;

    protected $fillable = [
        'subscriber_id', 'available_date', 'body_type', 'weight', 'volume',
        'city_code', 'city_name', 'city_latitude', 'city_longitude',
        'organization',
    ];

    public function truck()
    {
        return $this->belongsTo(Truck::class);
    }

}
