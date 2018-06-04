<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * @property int id
 * @property string name
 */
class Body extends Model
{

    public $timestamps = false;

    /**
     * Find Body by name or create new
     *
     * @param string $name
     * @return \App\Body
     */
    public static function findOrCreate($name)
    {
        $name = Str::lower(trim($name));
        $body = static::where('name', '=', $name)->first();
        if (is_null($body)) {
            $body = new static();
            $body->name = $name;
            $body->save();
            return $body;
        }
        return $body;
    }

}
