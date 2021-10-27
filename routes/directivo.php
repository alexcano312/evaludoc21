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

Route::get('/', 'directivoController@home')->name("directivo.home");

Route::get('/login', 'directivoController@login')->name("directivo.login");

// -- Cerrar Sesion
Route::get('/cerrar-sesion', 'directivoController@cerrarSesion')->name("directivo.cerrar.sesion");

// -- Vista para recuperar contraseña
Route::get('/recuperar-password', 'directivoController@recuperarPassword')->name("directivo.recuperar.password");

// -- Verificar Credenciales
Route::post('/verificar-credenciales', 'directivoController@verificaCredenciales')->name("directivo.verifica.credenciales");



Route::get('/totalAlumnos', 'directivoController@mostrarAlumnos')->name("directivo.mostrar.alumnos");

Route::get('/alumnosCarrera/{slug}', 'directivoController@alumnosCarreras')->name("directivo.mostrar.alumnos.carrera");

Route::group(["middleware" => "DirectivoAutentificado"], function() {

    // -- Inicio
    Route::get('/inicio', 'directivoController@inicio')->name("directivo.inicio");

    // -- Alumnos
    Route::get('/alumnos', 'directivoController@alumnos')->name("directivo.alumnos");

    // -- Detalle del grupo
    Route::get('/alumno/{id}', 'directivoController@alumnoDetalle')->name("directivo.alumno.detalle");

    // -- Detalle del grupo
    Route::get('/eliminar/alumno/{id?}', 'directivoController@eliminarAlumno')->name("directivo.eliminar.alumno");

    // -- Materias
    Route::get('/materias', 'directivoController@materias')->name("directivo.materias");

    // -- Evaluados
    Route::get('/evaluados', 'directivoController@evaluados')->name("directivo.evaluados");

    // -- Grupos
    Route::get('/grupos', 'directivoController@grupos')->name("directivo.grupos");

    // -- Detalle del grupo
    Route::get('/grupo-detalle/{slug}', 'directivoController@grupoDetalle')->name("directivo.grupo.detalle");

    // -- Grupos
    Route::get('/grupos/activos/', 'directivoController@gruposActivos')->name("directivo.grupos.activos");

    // -- Agregar Evaluados a Grupos filtrados
    Route::get('/grupos-filtrados/{ids?}', 'directivoController@gruposFiltrados')->name("directivo.grupos.filtrados");

    // -- Agregar Evaluados a Grupos filtrados
    Route::get('/grupo-evaluados/{grupoId?}/{elementos?}', 'directivoController@grupoAgregarEvaluados')->name("directivo.grupo.agregar.evaluados");

    // -- Tutores
    Route::get('/tutores', 'directivoController@tutores')->name("directivo.tutores");

    // -- Evaluaciones
    Route::get('/evaluaciones', 'directivoController@evaluaciones')->name("directivo.evaluaciones");

    // -- Generar el pdf de la evaluación
    Route::get('/evaluacion/{slug}', 'directivoController@detalleEvaluacion')->name("directivo.detalle.evaluacion");

    // -- Resultados evaluación
    Route::get('/resultados/evaluacion/{slug}', 'directivoController@resultadosEvaluacion')->name("directivo.resultados.evaluacion");

    // -- Resultados evaluado Evaluación
    Route::get('/resultados/evaluacion/evaluado/{slug?}/{idEvaluado?}', 'directivoController@resultadosEvaluacionEvaluado')->name("directivo.resultados.evaluacion.evaluado");

    // -- Resultados Tutor Evaluación
    Route::get('/resultados/evaluacion/tutor/{slug?}/{idTutor?}', 'directivoController@resultadosEvaluacionTutor')->name("directivo.resultados.evaluacion.tutor");
    
    // -- GENERAR PDF DE EXTRACURRICULARES
    Route::get('/resultados/evaluacion/entrenador/{slug?}/{idEntrenador?}', 'directivoController@resultadosEvaluacionEntrenador')->name("directivo.resultados.evaluacion.entrenador");
    
    // -- Resultados evaluado Evaluación
    Route::get('/resultados/evaluacion/grupo/{slug?}/{slugGrupo?}', 'directivoController@resultadosEvaluacionGrupo')->name("directivo.resultados.evaluacion.grupo");

    // -- Comentarios evaluado Evaluación
    Route::get('/comentarios/evaluacion/evaludo/{slug?}/{idEvaluado?}', 'directivoController@comentariosEvaluacionEvaluado')->name("directivo.comentarios.evaluacion.evaluado");

    // -- Comentarios Tutor Evaluación
    Route::get('/comentarios/evaluacion/tutor/{slug?}/{idTutor?}', 'directivoController@comentariosEvaluacionTutor')->name("directivo.comentarios.evaluacion.tutor");
    
    // -- Comentarios DEL ENTRENADOR
    Route::get('/comentarios/evaluacion/entrenador/{slug?}/{idEntrenador?}', 'directivoController@comentariosEvaluacionEntrenador')->name("directivo.comentarios.evaluacion.entrenador");

    // -- Inscripcino Materias
    Route::get('/inscripciones-materias', 'directivoController@inscripcionMaterias')->name("directivo.inscripciones.materias");

    // -- Inscripcino Materias
    Route::get('/inscripciones-materias/detalle/{id}', 'directivoController@detalleInscripcionMaterias')->name("directivo.inscripciones.materias.detalle");

    // -- Inscripcion de los tutores
    Route::get('/inscripciones-grupos-tutores', 'directivoController@inscripcionTutorGrupo')->name("directivo.inscripciones.grupos.tutores");

    // -- Mostrar menu del código
    Route::get('/codigo_evaluacion/{slug}/{correo}', 'directivoController@codigoEvaluacion')->name("directivo.codigo.evaluacion");

    // -- Generar el pdf de la evaluación
    Route::get('/pdf_evaluacion/{slug}', 'directivoController@pdfEvaluacion')->name("directivo.pdf.evaluacion");

    // -- Verificar Credenciales
    Route::post('/enviar_evaluacion', 'directivoController@enviarEvaluacion')->name("directivo.enviar.evaluacion");

    // -- Editar Alumno
    Route::post('/editar-alumno', 'directivoController@editarAlumno')->name("generales.directivo.editar.alumno");

    // -- Editar Alumno
    Route::post('/editar-grupo', 'directivoController@editarGrupo')->name("generales.directivo.editar.grupo");

    // -- Personal
    Route::get('/personal', 'directivoController@personal')->name("directivo.personal");

    // -- Filtro de Grupos
    Route::get('/filtrar-grupos/{carrera?}/{cuatrimestre?}/{evaluacion?}/{anio?}', 'directivoController@filtroGrupos')->name("directivo.filtro.grupos");

    // -- Fuciona rgrupos
    Route::get('/fucionar-grupos/{grupoMovido}/{grupoDestino}', 'directivoController@fucionarGrupos')->name("generales.directivo.fucionar.grupo");
});