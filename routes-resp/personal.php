<?php

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

Route::get('/', 'personalController@home')->name("personal.home");

Route::get('/login', 'personalController@login')->name("personal.login");

// -- Cerrar Sesion
Route::get('/cerrar-sesion', 'personalController@cerrarSesion')->name("personal.cerrar.sesion");
// -- Vista para recuperar contraseña
Route::get('/recuperar-password', 'personalController@recuperarPassword')->name("personal.recuperar.password");

// -- Verificar Credenciales
Route::post('/verificar-credenciales', 'personalController@verificaCredenciales')->name("personal.verifica.credenciales");


Route::group(["middleware" => "PersonalAutentificado"], function() {

    // -- Inicio
    Route::get('/inicio', 'personalController@inicio')->name("personal.inicio");

    // -- Mostrar menu del código
    Route::get('/codigo_evaluacion/{slug}/{correo}', 'personalController@codigoEvaluacion')->name("personal.codigo.evaluacion");

    // -- Generar el pdf de la evaluación
    Route::get('/pdf_evaluacion/{slug}', 'personalController@pdfEvaluacion')->name("personal.pdf.evaluacion");

    // -- Verificar Credenciales
    Route::post('/enviar_evaluacion', 'perosnalController@enviarEvaluacion')->name("personal.enviar.evaluacion");

});