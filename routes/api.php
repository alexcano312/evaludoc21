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
Route::group(['middleware' => ['cors']], function () {
    // -- obtener detalles del alumno
    Route::get('/alumno/detalles/{matricula?}', 'apiController@alumnoDetalles')->name("api.detalles.alumno");

    Route::post('/alumno/verificar/{matricula?}', 'apiController@alumnoVerificar')->name("api.verificar.alumno");

    Route::get('/grupos', 'apiController@verGrupos')->name('api.grupos');

    Route::get('/alumnosFalt/{id?}', 'apiController@alumnosFaltantes')->name('api.alumnosFalt');
    
});
Route::get('/datosGraf/{id?}/{idE?}', 'apiController@datosGraficas')->name('api.datosGraf');