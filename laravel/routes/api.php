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

Route::get('grados', 'Api\EntregaController@grados');
Route::get('matriculas/{id}', 'Api\EntregaController@matriculas');
Route::get('asignaturas/{id}', 'Api\EntregaController@asignaturas');

Route::get('matricula/{id}', 'Api\EntregaController@matricula');
Route::post('entrega/guardar', 'Api\EntregaController@store');
