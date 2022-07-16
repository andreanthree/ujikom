<?php

use App\Http\Controllers\Api\DataApiController;
use App\Http\Controllers\Api\DokterControllerAPI;
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
Route::get('/dashboard',[DataApiController::class, 'dashboard']);
Route::post('/analisis',[DataApiController::class, 'analisis']);
Route::post('/dokterprofile',[DokterControllerAPI::class, 'dokterprofile']);
Route::post('/getdokter',[DokterControllerAPI::class, 'getdokter']);
Route::get('/gejala',[DataApiController::class, 'gejala']);
Route::get('/master',[DataApiController::class, 'master']);
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
