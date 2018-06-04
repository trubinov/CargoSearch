<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use InvalidArgumentException;

/**
 * @property int loading_types
 * @property bool loading_lateral
 * @property bool loading_top
 * @property bool loading_back
 * @property bool loading_full
 * @property int unloading_types
 * @property bool unloading_lateral
 * @property bool unloading_top
 * @property bool unloading_back
 * @property bool unloading_full
 * @property float length
 * @property float width
 * @property float height
 * @property string dimensions
 * @property Carbon load_date
 * @property Carbon load_date_to
 * @property int bodies
 * @property string bodies_list
 * @property Carbon loading_time_from
 * @property Carbon loading_time_to
 * @property Carbon unloading_time_from
 * @property Carbon unloading_time_to
 */
class Good extends Model
{

    use SoftDeletes;

    const LATERAL = 0b0001; // Боковая
    const TOP = 0b0010;     // Верхняя
    const BACK = 0b0100;    // Задняя
    const FULL = 0b1000;    // Полная растентовка

    protected $fillable = [
        'good_uid', 'weight', 'volume', 'subscriber_id', 'body_type',
        'loading_city_code', 'loading_city_name', 'loading_city_latitude', 'loading_city_longitude',
        'unloading_city_code', 'unloading_city_name', 'unloading_city_latitude', 'unloading_city_longitude',
        'organization', 'organization_inn',
        'manager', 'manager_contacts', 'manager_icq', 'manager1', 'manager1_contacts', 'manager1_icq',
        'description', 'truck_count', 'due_date_val', 'price_prepay', 'price', 'currency_code_prepay', 'currency_code',
        'belts_count', 'conics', 'airway', 'coupling', 'medical_book', 'cmr', 'tir', 't1',
        'loading_address', 'unloading_address', 'length', 'width', 'height', 'adr', 'consolidated',
        'package', 'terms_prepay', 'form_prepay', 'due_date_prepay', 'treat_price', 'bargain_available',
        'loading_weekend', 'unloading_weekend', 'loading_aroundtheclock', 'unloading_aroundtheclock',
        'terms_pay', 'form_pay', 'additional_params', 'manager_work_phone', 'manager1_work_phone',
        'tariff_code', 'distance', 'bodies_list', 'source', 'quickly', 'constantly',
        'package_count', 'afterload', 'temp_from', 'temp_to',
        'loading_time_from', 'loading_time_to', 'unloading_time_from', 'unloading_time_to',
        'circle', 'comment', 'direct_contract'
    ];

    protected $appends = [
        'loading_lateral', 'loading_top', 'loading_back', 'loading_full',
        'unloading_lateral', 'unloading_top', 'unloading_back', 'unloading_full',
    ];

    protected $casts = [
        'conics' => 'boolean',
        'airway' => 'boolean',
        'coupling' => 'boolean',
        'medical_book' => 'boolean',
        'cmr' => 'boolean',
        'tir' => 'boolean',
        't1' => 'boolean',
        'consolidated' => 'boolean',
        'bargain_available' => 'boolean',
        'treat_price' => 'boolean',
        'loading_weekend' => 'boolean',
        'unloading_weekend' => 'boolean',
        'loading_aroundtheclock' => 'boolean',
        'unloading_aroundtheclock' => 'boolean',
        'quickly' => 'boolean',
        'constantly' => 'boolean',
        'circle' => 'boolean',
        'direct_contract' => 'boolean',
    ];

    protected $dates = ['deleted_at'];

    public function waypoints()
    {
        return $this->hasMany(Waypoint::class);
    }

    public function suburbs()
    {
        return $this->hasMany(Suburb::class);
    }

    public function searchItems()
    {
        return $this->hasMany(GoodSearchItem::class);
    }

    public function setLoadingLateralAttribute($value)
    {
        $this->loading_types = $this->setBitmaskElem($this->loading_types, Good::LATERAL, $value);
    }

    public function getLoadingLateralAttribute()
    {
        return boolval($this->loading_types & Good::LATERAL);
    }

    public function setLoadingTopAttribute($value)
    {
        $this->loading_types = $this->setBitmaskElem($this->loading_types, Good::TOP, $value);
    }

    public function getLoadingTopAttribute()
    {
        return boolval($this->loading_types & Good::TOP);
    }

    public function setLoadingBackAttribute($value)
    {
        $this->loading_types = $this->setBitmaskElem($this->loading_types, Good::BACK, $value);
    }

    public function getLoadingBackAttribute()
    {
        return boolval($this->loading_types & Good::BACK);
    }

    public function setLoadingFullAttribute($value)
    {
        $this->loading_types = $this->setBitmaskElem($this->loading_types, Good::FULL, $value);
    }

    public function getLoadingFullAttribute()
    {
        return boolval($this->loading_types & Good::FULL);
    }

    public function setUnloadingLateralAttribute($value)
    {
        $this->unloading_types = $this->setBitmaskElem($this->unloading_types, Good::LATERAL, $value);
    }

    public function getUnloadingLateralAttribute()
    {
        return boolval($this->unloading_types & Good::LATERAL);
    }

    public function setUnloadingTopAttribute($value)
    {
        $this->unloading_types = $this->setBitmaskElem($this->unloading_types, Good::TOP, $value);
    }

    public function getUnloadingTopAttribute()
    {
        return boolval($this->unloading_types & Good::TOP);
    }

    public function setUnloadingBackAttribute($value)
    {
        $this->unloading_types = $this->setBitmaskElem($this->unloading_types, Good::BACK, $value);
    }

    public function getUnloadingBackAttribute()
    {
        return boolval($this->unloading_types & Good::BACK);
    }

    public function setUnloadingFullAttribute($value)
    {
        $this->unloading_types = $this->setBitmaskElem($this->unloading_types, Good::FULL, $value);
    }

    public function getUnloadingFullAttribute()
    {
        return boolval($this->unloading_types & Good::FULL);
    }

    public function getDimensionsAttribute()
    {
        return sprintf("%.2f / %.2f / %.2f", $this->length, $this->width, $this->height);
    }

    public function getLoadingTimeFromAttribute()
    {
        return $this->getTimeAttributeView('loading_time_from');
    }

    public function getLoadingTimeToAttribute()
    {
        return $this->getTimeAttributeView('loading_time_to');
    }

    public function getUnloadingTimeFromAttribute()
    {
        return $this->getTimeAttributeView('unloading_time_from');
    }

    public function getUnloadingTimeToAttribute()
    {
        return $this->getTimeAttributeView('unloading_time_to');
    }

    /**
     * Get H:i view for time attribute
     *
     * @param $name
     * @return string
     */
    protected function getTimeAttributeView($name)
    {
        $value = $this->attributes[$name];
        try {
            $time = Carbon::createFromFormat('H:i:s', $value);
            return $time->format('H:i');
        } catch (InvalidArgumentException $exception) {
        }
        return $value;
    }

    /**
     * Set bodies attribute (int, bit mask) using string representation (bodies_list)
     *
     * @param string $value
     */
    protected function setBodiesListAttribute($value)
    {
        $bodies = 0;
        $body_names = explode(',', $value);
        foreach ($body_names as $body_name) {
            $body = Body::findOrCreate($body_name);
            $bodies += (1 << ($body->id - 1));
        }
        $this->attributes['bodies'] = $bodies;
        $this->attributes['bodies_list'] = $value;
    }

    /**
     * @param int $current
     * @param int $elem
     * @param bool $value
     * @return int
     */
    protected function setBitmaskElem($current, $elem, $value)
    {
        if ($value) {
            $current |= $elem;
        } else {
            $current &= (~$elem);
        }
        return $current;
    }

}
