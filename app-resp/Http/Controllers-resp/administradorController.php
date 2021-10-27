<?php

namespace App\Http\Controllers;
use App\Administrador;
use App\Actividad;
use App\Alumno;
use App\Alumno_Actividad;
use App\Area;
use App\Carrera;
use App\Cuatrimestre;
use App\Directivo;
use App\Entrenador;
use App\Evaluado;
use App\Evaluado_Tipo;
use App\Generacion;
use App\Grupo;
use App\Grupo_Inscripcion_Alumno;
use App\Grupo_Inscripcion_Materia;
use App\Grupo_Inscripcion_Tutor;
use App\Materia;
use App\MateriaInscripcionCarrera;
use App\Personal;
use App\Plan_Estudio;
use App\Pregunta;
use App\Tema;
use App\Tutor;
use Faker\Provider\ar_JO\Person;
use Illuminate\Http\Request;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;


class administradorController extends Controller
{

    /*********************************
     *             Vistas
     *********************************/
    public function recuperarPassword(){
        return view("administrador.recuperar_password");
    }

    // -- Actividades
    public function actividades(){
        $actividades = Actividad::all();
        return view("administrador.actividades",["actividades" => $actividades]);
    }

    // -- Alumnos
    public function alumnos(){
        $carreras = Carrera::all();
        $generaciones = Generacion::all();
        $alumnos = Alumno::all();

        return view("administrador.alumnos",["alumnos" => $alumnos,"carreras" => $carreras, "generaciones" => $generaciones]);
    }

    // -- Detalle de alumno
    public  function alumnoDetalle($id){
        $alumno = Alumno::find($id);
        $carreras = Carrera::orderBy("nombre","ASC")->get();
        $generaciones = Generacion::orderBy("nombre","ASC")->get();
        if($alumno){
            return view("administrador.alumno_detalle",["alumno" => $alumno,"carreras" => $carreras, "generaciones" => $generaciones]);
        }
    }

    // -- Alumnos
    public function alumnosActividades(){
        $inscripciones = Alumno_Actividad::all();
        $actividades = Actividad::all();

        return view("administrador.alumnos_actividades",["inscripciones" => $inscripciones,"actividades" => $actividades]);
    }
    // -- Areas
    public function areas(){
        $areas = Area::all();
        return view("administrador.areas",["areas" => $areas]);
    }

    // -- Carreras
    public function carreras(){
        $carreras = Carrera::all();
        $areas = Area::all();
        return view("administrador.carreras",["carreras" => $carreras, "areas" => $areas]);
    }

    // -- Cuatrimestres
    public function cuatrimestres(){
        $cuatrimestres = Cuatrimestre::all();
        return view("administrador.cuatrimestres",["cuatrimestres" => $cuatrimestres]);
    }

    // -- Directivos
    public function directivos(){
        $areas = Area::all();
        $directivos = Directivo::all();
        return view("administrador.directivos",["areas" => $areas, "directivos" => $directivos]);
    }

    // -- Entrenador
    public function entrenadores(){
        $actividades = Actividad::all();
        $entrenadores = Entrenador::all();
        return view("administrador.entrenadores",["actividades" => $actividades, "entrenadores" => $entrenadores]);
    }

    // -- Evaluado
    public function evaluados(){
        $areas = Area::all();
        $tipos = Evaluado_Tipo::all();
        $evaluados = Evaluado::all();
        return view("administrador.evaluados",["areas" => $areas, "tipos" => $tipos, "evaluados" => $evaluados]);
    }

    // -- Evaluados Tipo
    public function evaluadosTipo(){
        $evaluados = Evaluado_Tipo::all();
        $tipos = Evaluado_Tipo::all();
        $areas = Area::all();
        return view("administrador.evaluados_tipos",["tipos" => $evaluados, "tipos" => $tipos, "areas" => $areas]);
    }

    // -- Generaciones
    public function generaciones(){
        $generaciones = Generacion::all();
        return view("administrador.generaciones",["generaciones" => $generaciones]);
    }

    // -- Grupos
    public function grupos(){
        $grupos = Grupo::all();
        $cuatrimestres = Cuatrimestre::all();
        return view("administrador.grupos",["grupos" => $grupos, "cuatrimestres" => $cuatrimestres]);
    }

    // -- Detalle del grupo
    public function grupoDetalle($slug){
        $grupo = Grupo::where("slug",$slug)->first();
        $inscripcionesAlumnos = Grupo_Inscripcion_Alumno::where('grupo_id',$grupo->id)->get();
        $materiasPendientes = MateriaInscripcionCarrera::where('carrera_id',$grupo->carrera_id)->where('cuatrimestre_id',$grupo->cuatrimestre_id)->get();
        $materias = [];
        $inscripcionesMaterias = Grupo_Inscripcion_Materia::where('grupo_id',$grupo->id)->get();
        foreach ($materiasPendientes as $materia) {

            $grupoMateria = Grupo_Inscripcion_Materia::where("materia_inscripcion_carrera_id",$materia->id)->where("grupo_id",$grupo->id)->first();
            if(!$grupoMateria){
                array_push($materias,$materia);
            }
        }

        return view("administrador.grupo_detalle",["grupo" => $grupo, "inscripciones" => $inscripcionesAlumnos, "materias" => $materias, "inscripcionesMaterias" => $inscripcionesMaterias]);

    }

    //Index
    public function index(){
        return redirect()->route("administrador.inicio");
    }

    // -- Inicio / Dashboard
    public function inicio(){
        return view("administrador.inicio");
    }

    // -- Materias
    public function inscripcionMaterias(){
        $materiasCarreras = MateriaInscripcionCarrera::all();
        $materias = Materia::orderBy("nombre","ASC")->get();
        $cuatrimestres = Cuatrimestre::all();
        $carreras = Carrera::orderBy("nombre","ASC")->get();
        $planes = Plan_Estudio::all();
        return view("administrador.inscripcionMaterias",["materiasCarreras" => $materiasCarreras,"materias" => $materias, "cuatrimestres" => $cuatrimestres, "carreras" => $carreras, 'planes' => $planes]);
    }

    // -- Materias A grupo
    public function inscripcionMateriasGrupo(){
        $grupoInscripcionMaterias = Grupo_Inscripcion_Materia::all();
        return view("administrador.grupos_inscripciones_materias",["inscripciones" => $grupoInscripcionMaterias]);
    }

    // -- Tutores a grupo
    public function inscripcionTutorGrupo(){
        $grupoInscripciontutor = Grupo_Inscripcion_Tutor::all();
        return view("administrador.grupos_inscripciones_tutor",["inscripciones" => $grupoInscripciontutor]);
    }

    // -- Login
    public function login(){
        return view("administrador.login");
    }

    // -- Materias
    public function materias(){
        $materias = Materia::all();
        return view("administrador.catalogoMaterias",["materias" => $materias]);
    }

    // -- Personal
    public function planes(){
        $planes = Plan_Estudio::all();
        return view("administrador.planes_estudio",["planes" => $planes]);
    }

    // -- Personal
    public function personal(){
        $personal = Personal::all();
        return view("administrador.personal",["personal" => $personal]);
    }

    // -- Preguntas
    public function preguntas(){
        $preguntas = Pregunta::all();
        $temas = Tema::all();
        return view("administrador.preguntas",["preguntas" => $preguntas, 'temas' => $temas]);
    }

    // -- Temas
    public function temas(){
        $temas = Tema::all();
        return view("administrador.temas",["temas" => $temas]);
    }

    // -- Tutores
    public function tutores(){
        $tutores = Tutor::all();
        $areas = Area::all();
        return view("administrador.tutores",["tutores" => $tutores, "areas" => $areas]);
    }




    /*********************************
     *           Procesos
     *********************************/

    public function cerrarSesion()
    {
        if (Session::has("administrador"))
            Session::forget("administrador");

        return redirect()->route("administrador.login");
    }

    public function verificarCredenciales (Request $request){

        $validator = Validator::make($request->all(), [
            "correo" => "required",
            "password" => "required",
        ], [
            "correo.required" => "Debe ingresar un correo.",
            "password.required" => "Debe ingresar una contraseña.",
        ]);


        if ($validator->fails())
            return back()->withErrors($validator->errors())->withInput();

        $administrador = Administrador::where("correo", $request->correo)->first();

        if (!$administrador)
            return back()->withErrors(["generales" => "Usuario incorrecto."])->withInput();

        if (!Hash::check($request->password, $administrador->password))
            return back()->withErrors(["generales" => "Contraseña incorrecta."])->withInput();

        Session::put("administrador", $administrador);

        if($request->url){
            $url = decrypt($request->url);
            return redirect($url);
        }else{
            return redirect()->route("administrador.inicio");
        }

    }

}
