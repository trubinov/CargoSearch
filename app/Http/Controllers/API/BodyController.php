<?php

namespace App\Http\Controllers\API;

use App\Body;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

class BodyController extends Controller
{

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
        return Response::create(Body::all());
    }

}
