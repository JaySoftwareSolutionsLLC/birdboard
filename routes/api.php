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

// API stands for Application Programming Interface and typically refers to a series of endpoints which allow reading and modification of information in the database from outide applications.

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
