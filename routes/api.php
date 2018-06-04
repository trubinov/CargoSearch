<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/* Resource Route for Body table */
Route::apiResource('bodies', 'API\BodyController')->only(['index']);

/* Resource Route for Goods table */
Route::apiResources(['goods' => 'API\GoodsController']);
Route::post('goods/search', 'API\GoodsController@search')->name('goods.search');