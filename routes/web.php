<?php

use App\Http\Controllers\ApiController as ApiControllerAlias;
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


Route::post('/links',           [ApiControllerAlias::class, 'createLink']);
Route::patch('/links/{id}',     [ApiControllerAlias::class, 'updateLink']);
Route::delete('/links/{id}',    [ApiControllerAlias::class, 'deleteLink']);

Route::get('/links',            [ApiControllerAlias::class, 'getLinks']);
Route::get('/links/{id}',       [ApiControllerAlias::class, 'getLink']);

Route::get('/stats',            [ApiControllerAlias::class, 'getStats']);
Route::get('/stats/{id}',       [ApiControllerAlias::class, 'getStatsByLink']);

//redirect
Route::get('/{url}', [RedirectController::class, 'index']);
