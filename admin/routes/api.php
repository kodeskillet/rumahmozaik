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

Route::get('product','ProductController@index');
Route::get('product/{id}','ProductController@show');
Route::get('product/table','ProductController@indexTable');
Route::post('product','ProductController@store');
Route::put('product','ProductController@store');
Route::delete('product/{id}','ProductController@destroy');

Route::get('catalogtype','CatalogTypeController@index');
Route::get('catalogtype/{id}','CatalogTypeController@show');
Route::post('catalogtype','CatalogTypeController@store');
Route::put('catalogtype','CatalogTypeController@store');
Route::delete('catalogtype/{id}','CatalogTypeController@destroy');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
