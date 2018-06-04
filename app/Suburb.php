<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Suburb extends Model
{

    public $incrementing = false;

    public $timestamps = false;

    protected $fillable = ['id', 'kind', 'code', 'name', 'latitude', 'longitude', 'good_id'];

}
