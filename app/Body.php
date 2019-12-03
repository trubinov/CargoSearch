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

    /**
     * Заглушка для тента
     */
    const AWNING_IDS = [3, 15, 19, 23, 25, 36, 72, 86];

    public $timestamps = false;

    /**
     * Заглушка для тента
     *
     * @param string $name
     * @return array
     */
    public static function checkAwning($name)
    {
        $name = Str::lower(trim($name));
        if (Str::startsWith($name, 'тент'))
            return self::AWNING_IDS;
        return [];
    }

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
