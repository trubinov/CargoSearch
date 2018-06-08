<?php

namespace App\Http\Controllers\API;

use App\GoodSearchItem;
use App\Http\Controllers\Controller;
use App\TruckSearchItem;
use Illuminate\Http\Response;
use Carbon\Carbon;

class InfoController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        $today_begin = Carbon::now()->addRealHours(-24);
        return Response::create([
            'goods_today' => GoodSearchItem::where('created_at', '>=', $today_begin)->count(),
            'goods_total' => GoodSearchItem::all('id')->count(),
            'trucks_today' => TruckSearchItem::where('created_at', '>=', $today_begin)->count(),
            'trucks_total' => TruckSearchItem::all('id')->count(),
        ]);
    }

}
