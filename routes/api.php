<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\IconController;
use App\Http\Controllers\Api\ImageController;
use App\Http\Controllers\Api\CountryController;
use App\Http\Controllers\Api\EarthquakeController;
use App\Http\Controllers\Api\CountryEarthquakeController;
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

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('icons', IconController::class);

Route::apiResource('countries', CountryController::class);

Route::apiResource('earthquakes', EarthquakeController::class);

Route::apiResource('country_earthquake', CountryEarthquakeController::class);

Route::get('image/{filename}', [ImageController::class,'getImage'])->name('image.getImage'); 

