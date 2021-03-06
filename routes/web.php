<?php

use App\Http\Controllers\Api\LinksController as ApiControllerAlias;
use App\Http\Controllers\Api\StatsController as StatsControllerAlias;
use App\Http\Controllers\IndexController as IndexControllerAlias;
use App\Http\Controllers\RedirectController;
use Illuminate\Support\Facades\Route;

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


Route::get('/', [IndexControllerAlias::class, 'index']);


Route::post('/links',           [ApiControllerAlias::class, 'createLink'])
    ->middleware('simple_auth');
Route::patch('/links/{id}',     [ApiControllerAlias::class, 'updateLink'])
    ->where('id', '[a-z0-9]+')
    ->middleware('simple_auth');
Route::delete('/links/{id}',    [ApiControllerAlias::class, 'deleteLink'])
    ->where('id', '[a-z0-9]+')
    ->middleware('simple_auth');

Route::get('/links',            [ApiControllerAlias::class, 'getLinks'])
    ->middleware('simple_auth');
Route::get('/links/{id}',       [ApiControllerAlias::class, 'getLink'])
    ->where('id', '[a-z0-9]+')
    ->middleware('simple_auth');

Route::get('/stats',            [StatsControllerAlias::class, 'getStats'])
    ->middleware('simple_auth');
Route::get('/stats/{id}',       [StatsControllerAlias::class, 'getStatsByLink'])
    ->where('id', '[a-z0-9]+')
    ->middleware('simple_auth');

//redirect
Route::get('/{url}', [RedirectController::class, 'index'])
    ->where('url', '[a-z0-9]+');
