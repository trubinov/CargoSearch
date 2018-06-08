<?php

namespace App\Http\Controllers\API;

use App\Body;
use App\Truck;
use App\TruckSearchItem;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

class TrucksController extends Controller
{

    protected $validation_rules = [
        'subscriber_id' => 'string',
        'available_date' => 'date_format:d.m.Y',
        'city_code' => 'string',
        'city_name' => 'string',
        'city_latitude' => 'numeric',
        'city_longitude' => 'numeric',
        'city_name2' => 'string|nullable',
        'body_type' => 'string',
        'weight' => 'numeric',
        'volume' => 'numeric',
        'organization' => 'string',
        'organization_inn' => 'string',
        'manager' => 'string',
        'manager_icq' => 'string',
        'phones' => 'string',
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
        $truck = new Truck();
        $this->fillTruckByRequest($truck, $request);
        return Response::create($truck);
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

    protected function fillTruckByRequest(Truck $truck, Request $request)
    {
        $truck->fill($request->all($truck->getFillable()));
        // dates
        $truck->available_date = Carbon::createFromFormat('d.m.Y', $request->available_date);
        $truck->body_type = Body::findOrCreate($request->body_type)->id;
        $truck->save();
        $search_item = new TruckSearchItem($truck->attributesToArray());
        $search_item->id = uniqid('', true);
        $search_items = [$search_item];
        $truck->searchItems()->delete();
        $truck->searchItems()->saveMany($search_items);
        return $truck;
    }

}
