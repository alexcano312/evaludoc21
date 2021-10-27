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

Route::get('/', function () {
    return view('alumno.login');
});


// -- Inicio
Route::get('/archivos', 'alumnoController@archivos')->name("alumno.archivos");

// -- Vista de login
Route::get('/cerrar-sesion', 'alumnoController@cerrarSesion')->name("alumno.cerrar.sesion");

// -- Inicio
Route::get('/', 'alumnoController@login')->name("alumno.login");

// -- Verificar Credenciales
Route::post('/verificar-credenciales', 'alumnoController@verificarCredenciales')->name("alumno.verifica.credenciales");

// -- Vista de login
Route::get('/cerrar-sesion', 'alumnoController@cerrarSesion')->name("alumno.cerrar.sesion");

// -- Verificar código de evaluación
Route::get('/validar/{codigo}', 'alumnoController@validarCodigo')->name("validar.codigo");

Route::group(["middleware" => "AlumnoAutentificado"], function() {
    // -- Inicio
    Route::get('/inicio', 'alumnoController@inicio')->name("alumno.inicio");

    // -- Mostrar cuestionario de evaluación
    Route::get('/evaluacion/{slug}', 'alumnoController@contestarEvaluacion')->name("alumno.contestar.evaluacion");

    // -- Mostrar menu del código
    Route::get('/codigo_evaluacion/{slug}/{correo}', 'alumnoController@codigoEvaluacion')->name("alumno.codigo.evaluacion");

    // -- Generar el pdf de la evaluación
    Route::get('/pdf_evaluacion/{slug}', 'alumnoController@pdfEvaluacion')->name("alumno.pdf.evaluacion");

    // -- Verificar Credenciales
    Route::post('/evaluar_evaluado', 'alumnoController@evaluarEvaluado')->name("alumno.evaluar.evaluado");

    // -- Verificar Credenciales
    Route::post('/enviar_evaluacion', 'alumnoController@enviarEvaluacion')->name("alumno.enviar.evaluacion");

});