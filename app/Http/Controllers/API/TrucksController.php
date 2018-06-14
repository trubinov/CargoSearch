<?php

namespace App\Http\Controllers\API;

use App\Body;
use App\Http\Resources\TruckSearchItemResource;
use App\Truck;
use App\TruckSearchItem;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class TrucksController extends Controller
{

    protected $search_validation_rules = [
        'available_date' => 'required|date_format:d.m.Y',
        'city_radius' => 'numeric',
        'city_latitude' => 'numeric|required_with:city_radius',
        'city_longitude' => 'numeric|required_with:city_radius',
        'weight_from' => 'numeric',
        'weight_to' => 'numeric',
        'volume_from' => 'numeric',
        'volume_to' => 'numeric',
        'organization' => 'string|nullable',
        'bodies.*' => 'string',
    ];

    protected $validation_rules = [
        'doc_uid' => 'required|string|size:36',
        'subscriber_id' => 'string',
        'available_date' => 'date_format:d.m.Y',
        'city_code' => 'string',
        'city_name' => 'string',
        'city_latitude' => 'numeric',
        'city_longitude' => 'numeric',
        'city_name2' => 'string|nullable',
        'body_type_name' => 'string',
        'weight' => 'numeric',
        'volume' => 'numeric',
        'length' => 'numeric|nullable',
        'width' => 'numeric|nullable',
        'height' => 'numeric|nullable',
        'organization' => 'string',
        'organization_inn' => 'string',
        'organization_contacts' => 'string',
        'manager' => 'string',
        'manager_icq' => 'string',
        'manager_contacts' => 'string',
        'manager_work_phone' => 'string|nullable',
        'driver_name' => 'string',
        'truck_num' => 'string',
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
        return Response::create(['total' => TruckSearchItem::all()->count()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, $this->validation_rules);
        $truck = Truck::where('doc_uid', '=', $request->get('doc_uid'))->first();
        if (is_null($truck)) {
            $truck = new Truck();
            $this->fillTruckByRequest($truck, $request);
            return Response::create($truck);
        } else {
            return $this->update($request, $truck->id);
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
        return Response::create(Truck::findOrFail($id));
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
        $this->validate($request, $this->validation_rules);
        $truck = Truck::findOrFail($id);
        $this->fillTruckByRequest($truck, $request);
        return Response::create($truck);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (TruckSearchItem::where('truck_id', '=', $id)->delete() > 0)
            return Response::create('OK');
        return Response::create('Failed');
    }

    /**
     * Remove TruckItemSearch by doc_uid
     * @param string $doc_uid
     * @return \Illuminate\Http\Response
     */
    public function delete($doc_uid)
    {
        $truck = Truck::where('doc_uid', '=', $doc_uid)->first();
        if (!is_null($truck)) {
            if (TruckSearchItem::where('truck_id', '=', $truck->id)->delete() > 0)
                return Response::create('OK');
        }
        return Response::create('Failed');
    }

    /**
     * Search Trucks
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $this->validate($request, $this->search_validation_rules);
        $available_date = $this->getDateTimeField($request, 'available_date', 'd.m.Y')->startOfDay();
        $truck_query = TruckSearchItem::with('truck');
        $truck_query->where('available_date', '>=', $available_date);
        $starred_trucks = $request->get('starred');
        if (is_array($starred_trucks)) {
            $truck_query->whereIn('truck_id', $starred_trucks);
        }
        $city_radius = $request->get('city_radius');
        if (!is_null($city_radius)) {
            $city_lat = $request->get('city_latitude');
            $city_long = $request->get('city_longitude');
            $truck_query->whereRaw('sqrt(pow(city_latitude - ?, 2) + pow(city_longitude - ?, 2)) <= ?',
                [$city_lat, $city_long, $city_radius]);
        }
        $bodies = $request->get('bodies');
        if (is_array($bodies)) {
            $body_ids = [];
            foreach ($bodies as $body_name) {
                $body = Body::findOrCreate($body_name);
                $body_ids[] = $body->id;
            }
            if (count($body_ids) > 0) {
                $truck_query->whereIn('body_type', $body_ids);
            }
        }
        if ($request->has('weight_from')) {
            $truck_query->where('weight', '>=', $request->get('weight_from'));
        }
        if ($request->has('weight_to')) {
            $truck_query->where('weight', '<=', $request->get('weight_to'));
        }
        if ($request->has('volume_from')) {
            $truck_query->where('volume', '>=', $request->get('volume_from'));
        }
        if ($request->has('volume_to')) {
            $truck_query->where('volume', '<=', $request->get('volume_to'));
        }
        if ($request->has('organization')) {
            $truck_query->where('organization', 'like', $request->get('organization'));
        }
        $subscriber_ranking = $request->get('subscriber_ranking');
        if (!is_null($subscriber_ranking)) {
            DB::unprepared(DB::raw('DROP TEMPORARY TABLE IF EXISTS `subscriber_ranking`'));
            DB::insert(DB::raw('CREATE TEMPORARY TABLE `subscriber_ranking`(`s_id` VARCHAR(10), `rank` SMALLINT) ENGINE = MEMORY'));
            foreach ($subscriber_ranking as $subscriber_id => $rank)
                DB::table('subscriber_ranking')->insert(['s_id' => $subscriber_id, 'rank' => $rank]);
            $truck_query->leftJoin('subscriber_ranking',
                'truck_search_items.subscriber_id', '=', 'subscriber_ranking.s_id');
            $truck_query->orderByDesc('rank');
        }
        $truck_query->orderBy('available_date', 'asc');
        return TruckSearchItemResource::collection($truck_query->paginate());
    }

    /**
     * @param Request $request
     * @param $name
     * @param $format
     * @return null|\Carbon\Carbon
     */
    protected function getDateTimeField(Request $request, $name, $format)
    {
        $request_val = $request->get($name);
        if (!is_null($request_val)) {
            return Carbon::createFromFormat($format, $request_val);
        }
        return null;
    }

    protected function fillTruckByRequest(Truck $truck, Request $request)
    {
        $truck->fill($request->all($truck->getFillable()));
        // dates
        $truck->available_date = Carbon::createFromFormat('d.m.Y', $request->available_date);
        $truck->body_type = Body::findOrCreate($request->body_type_name)->id;
        $truck->save();
        $search_item = new TruckSearchItem($truck->attributesToArray());
        $search_item->id = uniqid('', true);
        $search_items = [$search_item];
        $truck->searchItems()->delete();
        $truck->searchItems()->saveMany($search_items);
        return $truck;
    }

}
