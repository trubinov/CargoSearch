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

/* Resource Route for total search information */
Route::get('info', 'API\InfoController@index')->name('info.index');

/* Resource Route for Body table */
Route::apiResource('bodies', 'API\BodyController')->only(['index']);

/* Resource Route for Goods table */
Route::apiResources(['goods' => 'API\GoodsController']);
Route::post('goods/search', 'API\GoodsController@search')->name('goods.search');
Route::delete('goods/{good_uid}/delete', 'API\GoodsController@delete')->name('goods.delete');

/* Resource Route for Trucks table */
Route::apiResources(['trucks' => 'API\TrucksController']);
Route::post('trucks/search', 'API\TrucksController@search')->name('trucks.search');
Route::delete('trucks/{doc_uid}/delete', 'API\TrucksController@delete')->name('trucks.delete');