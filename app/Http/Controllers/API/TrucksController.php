<?php

namespace App\Http\Controllers\API;

use App\Truck;
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
        'body_type' => 'numeric',
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
        return Response::create(Truck::all()->count());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return Response::create('OK');
    }
}
