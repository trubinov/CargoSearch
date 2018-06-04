<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Suburb extends Model
{

    public $incrementing = false;

    public $timestamps = false;

    protected $fillable = ['id', 'kind', 'city_code', 'city_name', 'good_id'];

}
