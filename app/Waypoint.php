<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Waypoint extends Model
{

    public $incrementing = false;

    public $timestamps = false;

    protected $fillable = ['id', 'kind', 'code', 'name', 'latitude', 'longitude', 'address', 'good_id'];

}
