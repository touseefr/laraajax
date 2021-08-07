<?php

use App\Http\Controllers\CityController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StateController;
use App\Models\City;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/',[StateController::class,'getstate']);
Route::post('/addcity',[CityController::class,'addcity']);
Route::post('/getcities',[CityController::class,'getcities']);
Route::post('/getCityById',[CityController::class,'getCityById']);

Route::post('/update',[CityController::class,'update']);
Route::get('/delete',[CityController::class,'delete']);
Route::get('/bin',[CityController::class,'bin']);

Route::get('/restore/{id}',[CityController::class,'restore']);
