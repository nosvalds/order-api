<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// orders
Route::group(["prefix" => "/orders"], function () {
    // POST /orders create an order
    Route::post('/','API\Orders@store');
    
    // PUT /orders/:id - update an order
    Route::put('/{order}','API\Orders@update');
    
    // GET /orders/:id - return a single order information
    Route::get('/{order}','API\Orders@show');
});
