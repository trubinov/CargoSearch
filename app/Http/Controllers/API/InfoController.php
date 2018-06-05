<?php

namespace App\Http\Controllers\API;

use App\GoodSearchItem;
use App\Http\Controllers\Controller;
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
        return Response::create([
            'goods_today' => GoodSearchItem::where('created_at', '>=', Carbon::now()->addRealHours(-24))->count(),
            'goods_total' => GoodSearchItem::all('id')->count(),
            'trucks_today' => 0,
            'trucks_total' => 0,
        ]);
    }

}
