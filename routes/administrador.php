<?php
use Illuminate\Http\Request;
use App\Arbol;


use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Input;
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
// -- Index
Route::get('/', 'administradorController@index')->name("administrador.index");
// -- Vista de login
Route::get('/login', 'administradorController@login')->name("administrador.login");
// -- Cerrar Sesion
Route::get('/cerrar-sesion', 'administradorController@cerrarSesion')->name("administrador.cerrar.sesion");
// -- Vista para recuperar contraseña
Route::get('/recuperar-password', 'administradorController@recuperarPassword')->name("administrador.recuperar.password");

// -- Verificar Credenciales
Route::post('/verificar-credenciales', 'administradorController@verificarCredenciales')->name("administrador.verifica.credenciales");

// -- Agregar Alumno
Route::post('/agregar-alumno', 'alumnoController@agregar')->name("generales.agregar.alumno");

Route::group(["middleware" => "AdministradorAutentificado"], function() {

    // -- Inicio
    Route::get('/inicio', 'administradorController@inicio')->name("administrador.inicio");

    // -- Alumnos
    Route::get('/alumnos', 'administradorController@alumnos')->name("administrador.alumnos");

    // -- Detalle del grupo
    Route::get('/alumno/{id}', 'administradorController@alumnoDetalle')->name("administrador.vista-alumno.detalle");

    // -- Alumnos
    Route::get('/alumnos-actividades', 'administradorController@alumnosActividades')->name("administrador.alumnos.actividades");

    // -- Actividades
    Route::get('/actividades', 'administradorController@actividades')->name("administrador.actividades");

    // -- Areas
    Route::get('/areas', 'administradorController@areas')->name("administrador.areas");

    // -- Evaluados
    Route::get('/directivos', 'administradorController@directivos')->name("administrador.directivos");

    // -- Carreras
    Route::get('/carreras', 'administradorController@carreras')->name("administrador.carreras");

    // -- Configuraciones
    Route::get('/configuraciones', 'administradorController@configuraciones')->name("administrador.configuraciones");
    
    // -- Entrenador
    Route::get('/entrenadores', 'administradorController@entrenadores')->name("administrador.entrenadores");

    // -- Evaluados
    Route::get('/evaluados', 'administradorController@evaluados')->name("administrador.evaluados");

    // -- Evaluados Tipo
    Route::get('/evaluados-tipos', 'administradorController@evaluadosTipo')->name("administrador.evaluados.tipos");

    // -- Cuatrimestres
    Route::get('/cuatrimestres', 'administradorController@cuatrimestres')->name("administrador.cuatrimestres");

    // -- Generaciones
    Route::get('/generaciones', 'administradorController@generaciones')->name("administrador.generaciones");

    // -- Grupos
    Route::get('/grupos', 'administradorController@grupos')->name("administrador.grupos");

    // -- Detalle del grupo
    Route::get('/grupo-detalle/{slug}', 'administradorController@grupoDetalle')->name("administrador.vista-grupo.detalle");

    // -- Inscripcion de las materias a los grupos
    Route::get('/inscripciones-grupos-materias', 'administradorController@inscripcionMateriasGrupo')->name("administrador.inscripciones.grupos.materias");

    // -- Inscripcion de los tutores
    Route::get('/inscripciones-grupos-tutores', 'administradorController@inscripcionTutorGrupo')->name("administrador.inscripciones.grupos.tutores");

    // -- Inscripción Materias
    Route::get('/inscripciones-materias', 'administradorController@inscripcionMaterias')->name("administrador.inscripciones.materias");

    // -- Materias
    Route::get('/materias', 'administradorController@materias')->name("administrador.materias");

    // -- Planes de estudio
    Route::get('/planes', 'administradorController@planes')->name("administrador.planes");

    // -- Personal
    Route::get('/personal', 'administradorController@personal')->name("administrador.personal");

    // -- Preguntas
    Route::get('/preguntas', 'administradorController@preguntas')->name("administrador.preguntas");

    // -- temas
    Route::get('/temas', 'administradorController@temas')->name("administrador.temas");

    // -- Tutores
    Route::get('/tutores', 'administradorController@tutores')->name("administrador.tutores");




    // -- Agregar Actividad
    Route::post('/agregar-actividad', 'actividadController@agregar')->name("generales.agregar.actividad");

    // -- Agregar Alumno
    Route::post('/agregar-alumno-actividad', 'alumnoActividadController@agregar')->name("generales.agregar.alumno.actividad");

    // -- Agregar Alumno a Grupo
    Route::post('/agregar-alumno-grupo', 'gruposInscripcionAlumno@agregar')->name("generales.agregar.alumno.grupo");

    // -- Agregar Area
    Route::post('/agregar-area', 'areaController@agregar')->name("generales.agregar.area");

    // -- Agregar Carrera
    Route::post('/agregar-carrera', 'carreraController@agregar')->name("generales.agregar.carrera");

    // -- Agregar Cuatrimestre
    Route::post('/agregar-cuatrimestre', 'cuatrimestreController@agregar')->name("generales.agregar.cuatrimestre");

    // -- Agregar Persona
    Route::post('/agregar-directivo', 'directivoController@agregar')->name("generales.agregar.directivo");

    // -- Agregar evaluado Tipo
    Route::post('/agregar-evaluado-tipo', 'tipoevaluadoController@agregar')->name("generales.agregar.evaluado.tipo");

    // -- Agregar evaluado Tipo
    Route::post('/agregar-entrenador', 'entrenadorController@agregar')->name("generales.agregar.entrenador");







    // -- Agregar Pregunta
    Route::post('/agregar-pregunta', 'preguntaController@agregar')->name("generales.agregar.pregunta");

    // -- Agregar Tema
    Route::post('/agregar-tema', 'temaController@agregar')->name("generales.agregar.tema");



    // -- Ruta para probar consultas
    Route::get('/pruebarutas', 'buscarController@buscarPruebaRutas')->name("general.pruebaruta");

    // -- Buscar Personal
    Route::get('/autocompletaradmin', 'buscarController@buscar')->name("general.buscar.personal.administrador");

    //////////////////
    ///
    /// Actualizar todos los grupos
    ///
    //////////////////
    // -- Actualizar todos los grupos 
    Route::post('/actualizar-informacion-grupos', 'administradorController@actualizarInformacionCompleta')->name("administrador.actualizar.informacion.completa");

});

Route::group(["middleware" => "AdministradorAutentificado", "middleware" => "DirectivoAutentificado"], function() {

    // -- Agregar Inscripción Materia
    Route::post('/agregar-inscripcion-materia', 'materiaController@agregarInscripcionMateria')->name("generales.agregar.inscripcion.materia");

    // -- Agregar Inscripción Materia
    Route::post('/editar-inscripcion-materia', 'materiaController@editarInscripcionMateria')->name("generales.editar.inscripcion.materia");

    // -- Agregar Materia
    Route::post('/agregar-materia', 'materiaController@agregar')->name("generales.agregar.materia");

    // -- Agregar Planes
    Route::post('/agregar-planes', 'planesestudioController@agregar')->name("generales.agregar.planes");

    // -- Agregar Persona
    Route::post('/agregar-persona', 'personalController@agregarPersona')->name("generales.agregar.persona");

    // -- Agregar Tutpr
    Route::post('/agregar-tutor', 'tutorController@agregar')->name("generales.agregar.tutor");

    // -- Buscar Alumnos
    Route::get('/autocompletar-alumnos', 'buscarController@buscarAlumnos')->name("general.buscar.alumnos");

    // -- Buscar Personal
    Route::get('/autocompletar', 'buscarController@buscar')->name("general.buscar.personal");

    // -- Buscar Evaluados
    Route::get('/autocompletar-evalaudos', 'buscarController@buscarEvaluados')->name("general.buscar.evaluados");

    // -- Buscar Grupos
    Route::get('/autocompletar-grupos', 'buscarController@buscarGrupos')->name("general.buscar.grupos");

    // -- Buscar Inscripciones Materias
    Route::get('/autocompletar-inscripciones-materias', 'buscarController@buscarInscripcionesMaterias')->name("general.buscar.inscripciones.materias");

    // -- Buscar tutores Activos
    Route::get('/autocompletar-tutores', 'buscarController@buscarTutores')->name("general.buscar.tutores");

    // -- Agregar evaluado Tipo
    Route::post('/agregar-evaluado', 'evaluadoController@agregar')->name("generales.agregar.evaluado");

    // -- Agregar Generacion
    Route::post('/agregar-generacion', 'generacionController@agregar')->name("generales.agregar.generacion");

    // -- Agregar grupo
    Route::post('/agregar-grupo', 'grupoController@agregar')->name("generales.agregar.grupo");

    // -- Agregar materia agrupo
    Route::post('/agregar-grupo-materia', 'gruposInscripcionMateriasController@agregar')->name("generales.agregar.grupo.materia");

    // -- Agregar tutor a grupo
    Route::post('/agregar-grupo-tutor', 'gruposInscripcionTutoresController@agregar')->name("generales.agregar.grupo.tutor");
});