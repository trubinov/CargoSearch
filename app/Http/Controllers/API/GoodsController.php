<?php

namespace App\Http\Controllers\API;

use App\Body;
use App\Good;
use App\Suburb;
use App\Waypoint;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

class GoodsController extends Controller
{

    protected $search_validation_rules = [
        'load_date' => 'required|date_format:d.m.Y',
        'loading_radius' => 'numeric',
        'loading_latitude' => 'numeric|required_with:loading_radius',
        'loading_longitude' => 'numeric|required_with:loading_radius',
        'unloading_radius' => 'numeric',
        'unloading_latitude' => 'numeric|required_with:unloading_radius',
        'unloading_longitude' => 'numeric|required_with:unloading_radius',
        'weight_from' => 'numeric',
        'weight_to' => 'numeric',
        'volume_from' => 'numeric',
        'volume_to' => 'numeric',
        'loading_lateral' => 'boolean',
        'loading_top' => 'boolean',
        'loading_back' => 'boolean',
        'loading_full' => 'boolean',
    ];

    protected $validation_rules = [
        'good_uid' => 'required|string|size:36',
        'load_date' => 'required|date_format:d.m.Y',
        'weight' => 'required|numeric',
        'volume' => 'required|numeric',
        'subscriber_id' => 'required|string',
        'body_type' => 'string|nullable',
        'loading_city_code' => 'required|string',
        'loading_city_name' => 'required|string',
        'loading_city_latitude' => 'required|numeric',
        'loading_city_longitude' => 'required|numeric',
        'unloading_city_code' => 'required|string',
        'unloading_city_name' => 'required|string',
        'unloading_city_latitude' => 'required|numeric',
        'unloading_city_longitude' => 'required|numeric',
        'loading_lateral' => 'boolean',
        'loading_top' => 'boolean',
        'loading_back' => 'boolean',
        'loading_full' => 'boolean',
        'unloading_lateral' => 'boolean',
        'unloading_top' => 'boolean',
        'unloading_back' => 'boolean',
        'unloading_full' => 'boolean',
        'load_date_to' => 'date_format:d.m.Y',
        'organization' => 'required',
        'organization_inn' => 'required',
        'manager' => 'required',
        'manager_contacts' => 'required',
        'manager_icq' => 'string',
        'manager1' => 'string|nullable',
        'manager1_contacts' => 'string|nullable',
        'manager1_icq' => 'string|nullable',
        'description' => 'required',
        'truck_count' => 'required|numeric',
        'due_date_val' => 'numeric',
        'price_prepay' => 'numeric',
        'price' => 'numeric',
        'currency_code_prepay' => 'string|nullable',
        'currency_code' => 'string|nullable',
        'belts_count' => 'numeric',
        'conics' => 'boolean',
        'airway' => 'boolean',
        'coupling' => 'boolean',
        'medical_book' => 'boolean',
        'cmr' => 'boolean',
        'tir' => 'boolean',
        't1' => 'boolean',
        'loading_address' => 'string|nullable',
        'unloading_address' => 'string|nullable',
        'length' => 'numeric',
        'width' => 'numeric',
        'height' => 'numeric',
        'adr' => 'numeric',
        'consolidated' => 'boolean',
        'package' => 'string|nullable',
        'terms_prepay' => 'numeric',
        'form_prepay' => 'numeric',
        'due_date_prepay' => 'numeric',
        'treat_price' => 'boolean',
        'bargain_available' => 'boolean',
        'loading_weekend' => 'boolean',
        'unloading_weekend' => 'boolean',
        'loading_aroundtheclock' => 'boolean',
        'unloading_aroundtheclock' => 'boolean',
        'terms_pay' => 'numeric',
        'form_pay' => 'numeric',
        'additional_params' => 'string|nullable',
        'manager_work_phone' => 'string|nullable',
        'manager1_work_phone' => 'string|nullable',
        'tariff_code' => 'string|nullable',
        'distance' => 'numeric',
        'bodies_list' => 'required|string',
        'source' => 'string|nullable',
        'quickly' => 'boolean',
        'constantly' => 'boolean',
        'package_count' => 'numeric',
        'afterload' => 'numeric',
        'temp_from' => 'numeric',
        'temp_to' => 'numeric',
        'loading_time_from' => 'date_format:H:i:s',
        'loading_time_to' => 'date_format:H:i:s',
        'unloading_time_from' => 'date_format:H:i:s',
        'unloading_time_to' => 'date_format:H:i:s',
        'circle' => 'boolean',
        'comment' => 'string|nullable',
        'direct_contract' => 'boolean',
        'waypoints.*.kind' => 'required|numeric',
        'waypoints.*.city_code' => 'required|string',
        'waypoints.*.city_name' => 'required|string',
        'waypoints.*.address' => 'string|nullable',
        'suburbs.*.kind' => 'required|numeric',
        'suburbs.*.city_code' => 'required|string',
        'suburbs.*.city_name' => 'required|string'
    ];

    protected $sort_fields = [
        0 => ['load_date', 'asc'],
        1 => ['load_date', 'desc'],
        2 => ['loading_city_name', 'asc'],
        3 => ['loading_city_name', 'desc'],
        4 => ['unloading_city_name', 'asc'],
        5 => ['unloading_city_name', 'desc'],
        6 => ['weight', 'asc'],
        7 => ['weight', 'desc'],
        8 => ['volume', 'asc'],
        9 => ['volume', 'desc'],
        10 => ['price', 'asc'],
        11 => ['price', 'desc'],
    ];

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Response::create(["total" => Good::all('id')->count()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate($this->validation_rules);
        $good = Good::where('good_uid', '=', $request->get('good_uid'))->first();
        if (is_null($good)) {
            $good = new Good();
            $this->fillGoodByRequest($good, $request);
            return Response::create($good);
        } else {
            return $this->update($request, $good->id);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Response::create(Good::with(['waypoints', 'suburbs'])->findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate($this->validation_rules);
        $good = Good::findOrFail($id);
        $this->fillGoodByRequest($good, $request);
        $good->save();
        return Response::create($good);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Good::destroy($id) > 0)
            return Response::create('OK');
        return Response::create('Failed');
    }

    /**
     * Search Goods
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $request->validate($this->search_validation_rules);
        $load_date_from = $this->getDateTimeField($request, 'load_date', 'd.m.Y')->startOfDay();
        $goods_query = Good::query();
        $goods_query->where(function (Builder $query) use ($load_date_from) {
            $query->where('load_date', '>=', $load_date_from)->orWhere('load_date_to', '>=', $load_date_from);
        });
        $loading_radius = $request->get('loading_radius');
        if (!is_null($loading_radius)) {
            $loading_lat = $request->get('loading_latitude');
            $loading_long = $request->get('loading_longitude');
            $goods_query->whereRaw('sqrt(pow(loading_city_latitude - ?, 2) + pow(loading_city_longitude - ?, 2)) <= ?',
                [$loading_lat, $loading_long, $loading_radius]);
        }
        $unloading_radius = $request->get('unloading_radius');
        if (!is_null($unloading_radius)) {
            $unloading_lat = $request->get('unloading_latitude');
            $unloading_long = $request->get('unloading_longitude');
            $goods_query->whereRaw('sqrt(pow(unloading_city_latitude - ?, 2) + pow(unloading_city_longitude - ?, 2)) <= ?',
                [$unloading_lat, $unloading_long, $unloading_radius]);
        }
        if ($request->has('weight_from')) {
            $goods_query->where('weight', '>=', $request->get('weight_from'));
        }
        if ($request->has('weight_to')) {
            $goods_query->where('weight', '<=', $request->get('weight_to'));
        }
        if ($request->has('volume_from')) {
            $goods_query->where('volume', '>=', $request->get('volume_from'));
        }
        if ($request->has('volume_to')) {
            $goods_query->where('volume', '<=', $request->get('volume_to'));
        }
        $goods_query->where(function (Builder $query) use ($request) {
            if ($request->get('loading_lateral', false)) {
                $query->orWhereRaw('loading_types & ? > 0', [Good::LATERAL])
                    ->orWhereRaw('unloading_types & ? > 0', [Good::LATERAL]);
            }
            if ($request->get('loading_top', false)) {
                $query->orWhereRaw('loading_types & ? > 0', [Good::TOP])
                    ->orWhereRaw('unloading_types & ? > 0', [Good::TOP]);
            }
            if ($request->get('loading_back', false)) {
                $query->orWhereRaw('loading_types & ? > 0', [Good::BACK])
                    ->orWhereRaw('unloading_types & ? > 0', [Good::BACK]);
            }
            if ($request->get('loading_full', false)) {
                $query->orWhereRaw('loading_types & ? > 0', [Good::FULL])
                    ->orWhereRaw('unloading_types & ? > 0', [Good::FULL]);
            }
        });
        $bodies = $request->get('bodies');
        if (is_array($bodies)) {
            $goods_query->where(function (Builder $query) use ($bodies) {
                foreach ($bodies as $body_name) {
                    $body = Body::findOrCreate($body_name);
                    $query->orWhereRaw('bodies & ? > 0', [1 << ($body->id - 1)]);
                }
            });
        }
        if ($request->get('prepay', false)) {
            $goods_query->where('price_prepay', '>', 0);
        }
        $form_pay_list = [];
        if ($request->get('cash', false))
            $form_pay_list[] = 0;
        if ($request->get('no_vat', false))
            $form_pay_list[] = 1;
        if ($request->get('with_vat', false))
            $form_pay_list[] = 2;
        if (count($form_pay_list) > 0)
            $goods_query->whereIn('form_pay', $form_pay_list);
        $starred_goods = $request->get('starred');
        if (is_array($starred_goods)) {
            $goods_query->whereIn('id', $starred_goods);
        }
        $sort = $request->get('sort');
        if (!is_null($sort) && array_key_exists($sort, $this->sort_fields)) {
            $goods_query->orderBy($this->sort_fields[$sort][0], $this->sort_fields[$sort][1]);
        }
        return Response::create($goods_query->paginate());
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param string $name
     * @param string $format
     * @return \Carbon\Carbon|null
     */
    protected function getDateTimeField(Request $request, $name, $format) {
        $request_val = $request->get($name);
        if (!is_null($request_val)) {
            return Carbon::createFromFormat($format, $request_val);
        }
        return null;
    }

    /**
     * @param \App\Good $good
     * @param \Illuminate\Http\Request $request
     * @return \App\Good
     */
    protected function fillGoodByRequest(Good $good, Request $request)
    {

        $good->fill($request->all($good->getFillable()));
        // dates
        $good->load_date = $this->getDateTimeField($request, 'load_date', 'd.m.Y');
        $good->load_date_to = $this->getDateTimeField($request, 'load_date_to', 'd.m.Y');
        // times
        $good->loading_time_from = $this->getDateTimeField($request, 'loading_time_from', 'H:i:s');
        $good->loading_time_to = $this->getDateTimeField($request, 'loading_time_to', 'H:i:s');
        $good->unloading_time_from = $this->getDateTimeField($request, 'unloading_time_from', 'H:i:s');
        $good->unloading_time_to = $this->getDateTimeField($request, 'unloading_time_to', 'H:i:s');
        // loading types
        $good->loading_types = 0;
        $good->loading_lateral = $request->get('loading_lateral', false);
        $good->loading_top = $request->get('loading_top', false);
        $good->loading_back = $request->get('loading_back', false);
        $good->loading_full = $request->get('loading_full', false);
        // unloading types
        $good->unloading_types = 0;
        $good->unloading_lateral = $request->get('unloading_lateral', false);
        $good->unloading_top = $request->get('unloading_top', false);
        $good->unloading_back = $request->get('unloading_back', false);
        $good->unloading_full = $request->get('unloading_full', false);
        $good->save();
        // append suburbs
        $suburbs = [];
        foreach ($request->get('suburbs', []) as $item) {
            $item['id'] = uniqid();
            $suburbs[] = new Suburb($item);
        }
        $good->suburbs()->delete();
        $good->suburbs()->saveMany($suburbs);
        // append waypoints
        $waypoints = [];
        foreach ($request->get('waypoints', []) as $item) {
            $item['id'] = uniqid();
            $waypoints[] = new Waypoint($item);
        }
        $good->waypoints()->delete();
        $good->waypoints()->saveMany($waypoints);
        return $good;
    }

}
