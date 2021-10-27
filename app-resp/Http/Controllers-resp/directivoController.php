<?php

namespace App\Http\Controllers;
use App\Alumno;
use App\Area;
use App\Carrera;
use App\Comentario_Evaluado_Materia;
use App\Cuatrimestre;
use App\Directivo;
use App\Evaluacion;
use App\Evaluado;
use App\Evaluado_Tipo;
use App\Generacion;
use App\Grupo;
use App\Grupo_Inscripcion_Alumno;
use App\Grupo_Inscripcion_Materia;
use App\Grupo_Inscripcion_Tutor;
use App\Herramienta;
use App\Inscripcion_Resultado;
use App\Materia;
use App\MateriaInscripcionCarrera;
use App\Plan_Estudio;
use App\Personal;
use App\Pregunta;
use App\Respuesta_Inscripcion_Materia;
use App\Tema;
use App\Tutor;
use Illuminate\Http\Request;
use DateTime;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class directivoController extends Controller
{
    // Agregar Directivo
    public function agregar (Request $request){

        Validator::make($request->all(), [
            "personaId" => "required",
            "areaId" => "required",
            "estatus" => "required",
        ], [
            "personaId.required" => "Debe seleccionar una persona.",
            "areaId.required" => "Debe seleccionar un area.",
            "estatus.required" => "Debe seleccionar un estatus.",
        ])->validated();

        $directivo = Directivo::where("persona_id",$request->personaId)->where("area_id",$request->areaId)->first();

        // -- Verificar que no exita un cliente con el mismo correo o teléfono.
        if ($directivo) {
            return back()->withErrors(["generales" => "Ya existe un directivo registrado con esa persona y area"])->withInput();
        } else {

            try {

                DB::beginTransaction();

                $directivo = new Directivo();
                $directivo->persona_id = $request->personaId;
                $directivo->area_id = $request->areaId;
                $directivo->estatus = $request->estatus;
                $directivo->observacion = $request->observacion;

                $tiempo = new DateTime();
                $directivo->created_at = $tiempo;

                $directivo->save();

                DB::commit();
                // -- Retornar correcto
                return back()->with("success", "Correcto");


            } catch (\Exception $e) {
                //DB::rollBack();
//                return back()->withErrors(["generales" => "Ocurrió un error al guardar su información, inténtelo de nuevo más tarde."])->withInput();
                //return back()->withErrors(["generales" => $e->getMessage()])->withInput();
                echo json_encode($e->getMessage());
            }
        }


    }

    // -- Login
    public function login(){
        return view("directivo.login");
    }

    public function home(){
        return redirect()->route("directivo.inicio");
    }

    public function inicio(){
        return view("directivo.inicio");
    }

    // -- Alumnos
    public function alumnos(){
        $carreras = Carrera::all();
        $generaciones = Generacion::all();
        $alumnos = Alumno::all();

        return view("directivo.alumnos",["alumnos" => $alumnos,"carreras" => $carreras, "generaciones" => $generaciones]);
    }

    // -- Detalle de alumno
    public  function alumnoDetalle($id){
        $alumno = Alumno::find($id);
        $carreras = Carrera::orderBy("nombre","ASC")->get();
        $generaciones = Generacion::orderBy("nombre","ASC")->get();
        if($alumno){
            return view("directivo.alumno_detalle",["alumno" => $alumno,"carreras" => $carreras, "generaciones" => $generaciones]);
        }
    }

    // -- Grupos Activos
    public  function gruposActivos(){


        // -- Grupos Activos

        $gruposActivos = Grupo::whereIn("carrera_id",Session('directivo')->carreras())->where('estatus',1)->get();

        $carreras = Carrera::where("area_id",Session('directivo')->area_id)->get();
        $cuatrimestres = Cuatrimestre::all();
        $evaluaciones = Evaluacion::all();

        return view("directivo.grupos_activos",["grupos" => $gruposActivos, "carreras" => $carreras, "cuatrimestres" => $cuatrimestres, "evaluaciones" => $evaluaciones]);

    }

    // -- Grupos
    public function grupos(){
        $grupos = Grupo::whereIn("carrera_id",Session('directivo')->carreras())->get();
        $cuatrimestres = Cuatrimestre::all();
        $carreras = Carrera::WhereIn('id',Session('directivo')->carreras())->orderBy("nombre","ASC")->get();
        $planes = Plan_Estudio::all();
        $evaluaciones = Evaluacion::where("estatus",1)->get();
        return view("directivo.grupos",["grupos" => $grupos, "cuatrimestres" => $cuatrimestres,"carreras" => $carreras, "planes" => $planes, "evaluaciones" => $evaluaciones]);

    }

    // -- Detalle del grupo
    public function grupoDetalle($slug){
        $grupo = Grupo::where("slug",$slug)->first();
        $carreras = Carrera::all();
        $cuatrimestres = Cuatrimestre::all();
        $inscripcionesAlumnos = Grupo_Inscripcion_Alumno::where('grupo_id',$grupo->id)->get();
        $materiasPendientes = MateriaInscripcionCarrera::where('carrera_id',$grupo->carrera_id)->where('cuatrimestre_id',$grupo->cuatrimestre_id)->where("plan_estudio_id",$grupo->plan_estudio_id)->get();
        $materias = [];
        $inscripcionesMaterias = Grupo_Inscripcion_Materia::where('grupo_id',$grupo->id)->get();
        foreach ($materiasPendientes as $materia) {

            $grupoMateria = Grupo_Inscripcion_Materia::where("materia_inscripcion_carrera_id",$materia->id)->where("grupo_id",$grupo->id)->first();
            if(!$grupoMateria){
                array_push($materias,$materia);
            }
        }

        return view("directivo.grupo_detalle",["grupo" => $grupo, "inscripciones" => $inscripcionesAlumnos, "materias" => $materias, "inscripcionesMaterias" => $inscripcionesMaterias, "carreras" => $carreras, "cuatrimestres" => $cuatrimestres]);
    }

    // -- Editar Alumno
    public function editarGrupo (Request $request){

        $validator = Validator::make($request->all(), [
            "nombre" => "required",
        ], [
            "nombre.required" => "Debe ingresar el nombre.",
        ]);

        if ($validator->fails())
            return back()->withErrors($validator->errors())->withInput();

        $grupo = Grupo::find($request->id);
        if (!$grupo)
            return back()->withErrors(["generales" => "No fue posible encontrar el grupo"])->withInput();

        $herramienta = new Herramienta();
        $slug = $herramienta->crearSlug($request->nombre);

        $verificarGrupo = Grupo::where('slug',$slug)->where('id','!=',$grupo->id)->first();
        if ($verificarGrupo)
            return back()->withErrors(["generales" => "Ya existe un grupo con ese nombre"])->withInput();

        try {

            DB::beginTransaction();

            $grupo->nombre = mb_strtoupper($request->nombre);
            $grupo->slug = $slug;
            $grupo->cuatrimestre_id = $request->cuatrimestre;
            $grupo->carrera_id = $request->carrera;
            $grupo->anio = $request->anio;
            $grupo->estatus = $request->estatus;
            $grupo->save();

            DB::commit();

            // -- Retornar correcto
            return redirect()->route("directivo.grupos");


        } catch (\Exception $e) {
            DB::rollBack();
            //return back()->withErrors(["generales" => "Ocurrió un error al guardar su información, inténtelo de nuevo más tarde."])->withInput();
            return back()->withErrors(["generales" => $e->getMessage()])->withInput();
            //echo json_encode($e->getMessage());
        }



    }

    // -- Editar Alumno
    public function editarAlumno (Request $request){

        $validator = Validator::make($request->all(), [
            "nombre" => "required",
            "apellidos" => "required",
            "matricula" => "required",
        ], [
            "nombre.required" => "Debe ingresar el nombre.",
            "apellidos.required" => "Debe ingresar los apellidos.",
            "matricula.required" => "Debe ingresar una matricula.",
        ]);

        if ($validator->fails())
            return back()->withErrors($validator->errors())->withInput();

        $alumno = Alumno::find($request->id);
        if (!$alumno)
            return back()->withErrors(["generales" => "No fue posible encontrar el alumno"])->withInput();

        $verificaAlumno = Alumno::where('matricula',$request->matricula)->where('id','!=',$alumno->id)->first();
        if ($verificaAlumno)
            return back()->withErrors(["generales" => "Ya existe un alumno con esa matricula"])->withInput();

        try {

            DB::beginTransaction();

            $alumno->nombre = mb_strtoupper($request->nombre);
            $alumno->apellidos = mb_strtoupper($request->apellidos);
            $alumno->sexo = $request->sexo;
            $alumno->generacion_id = $request->generacion;
            $alumno->carrera_id = $request->carrera;
            $alumno->tipo = $request->tipo;
            $alumno->matricula = $request->matricula;
            $alumno->estatus = $request->estatus;
            $alumno->save();

            DB::commit();

            // -- Retornar correcto
            return back()->with("success", "Correcto");


        } catch (\Exception $e) {
            DB::rollBack();
                //return back()->withErrors(["generales" => "Ocurrió un error al guardar su información, inténtelo de nuevo más tarde."])->withInput();
            return back()->withErrors(["generales" => $e->getMessage()])->withInput();
            //echo json_encode($e->getMessage());
        }



    }


    // -- Login
    public function verificaCredenciales (Request $request){

        $validator = Validator::make($request->all(), [
            "correo" => "required",
            "password" => "required",
        ], [
            "correo.required" => "Debe ingresar el correo.",
            "password.required" => "Debe ingresar un password.",
        ]);

        if ($validator->fails())
            return back()->withErrors($validator->errors())->withInput();

        $personal = Personal::where("correo",$request->correo)->first();

        if(!$personal)
            return back()->withErrors(["generales" => "No fue posible encontrar el usuario."])->withInput();

        if(!$personal->directivo)
            return back()->withErrors(["generales" => "El usuario no cuenta con provilegios."])->withInput();

        if ($personal->directivo->estatus != 1)
            return back()->withErrors(["generales" => "El usuario no se encuentra activo."])->withInput();

        if (!Hash::check($request->password, $personal->password))
            return back()->withErrors(["generales" => "Usuario o contraseña incorrectos."])->withInput();

        $directivo = $personal->directivo;

        Session::put("directivo", $directivo);

        if($request->url){
            $url = decrypt($request->url);
            return redirect($url);
        }else{
            return redirect()->route("directivo.inicio");
        }

    }

    // -- Cerrar sesion
    public function cerrarSesion()
    {
        if (Session::has("directivo"))
            Session::forget("directivo");

        return redirect()->route("directivo.login");
    }

    // -- Filtro para grupos
    public function filtroGrupos ($carrera, $cuatrimestre, $evaluacion, $anio){
        $filtroGrupos = [];
        $verificaCarreras = Session('directivo')->carreras();

        if($carrera){
            $grupos = Grupo::where("carrera_id",$carrera)->get();
            foreach ($grupos as $grupo) {
                if(in_array($grupo->carrera_id,$verificaCarreras)) {
                    if (!in_array($grupo->id, $filtroGrupos)) {
                        array_push($filtroGrupos, $grupo->id);
                    }
                }
            }
        }

        if($cuatrimestre){
            $grupos = Grupo::where("cuatrimestre_id",$cuatrimestre)->get();
            foreach ($grupos as $grupo) {
                if(in_array($grupo->carrera_id,$verificaCarreras)){
                    if(!in_array($grupo->id,$filtroGrupos)){
                    array_push($filtroGrupos,$grupo->id);
                    }
                }

            }
        }


        if($evaluacion){
            $grupos = Grupo::where("evaluacion_id",$evaluacion)->get();
            foreach ($grupos as $grupo) {
                if(in_array($grupo->carrera_id,$verificaCarreras)){
                    if(!in_array($grupo->id,$filtroGrupos)){
                    array_push($filtroGrupos,$grupo->id);
                    }
                }

            }
        }

        if($anio){
            $grupos = Grupo::where("anio",$anio)->get();
            foreach ($grupos as $grupo) {
                if(in_array($grupo->carrera_id,$verificaCarreras)){
                    if(!in_array($grupo->id,$filtroGrupos)){
                    array_push($filtroGrupos,$grupo->id);
                    }
                }

            }
        }

        $grupos = Grupo::whereIn("id",$filtroGrupos)->get();

        foreach ($grupos as $grupo) {
            $grupo->nombreEvaluacion = $grupo->evaluacion->nombre;
            $grupo->nombreCarrera = $grupo->carrera->nombre;
            $grupo->nombreCuatrimestre = $grupo->cuatrimestre->nombre;
        }

        echo json_encode($grupos);
    }

    public function gruposFiltrados ($ids){

        $idGrupos = explode(",",$ids);

        $grupos = Grupo::whereIn("carrera_id",Session('directivo')->carreras())->whereIn("id",$idGrupos)->get();
        $evaluados = Evaluado::where('estatus',1)->get();

        return view("directivo.grupos_filtrados",["grupos" => $grupos, "evaluados" => $evaluados]);

    }

    public function grupoAgregarEvaluados($grupoId,$elementos){

        $grupoId;

        $filtrarElementos = explode(",",$elementos);
        $verifica = 1;
        foreach ($filtrarElementos as $elemento) {

            try {



                // --(1-1) primer elemento Id de la Materia y segundo id evaluado
                $filtrarIds = explode("-",$elemento);
                $idInscripcionMateria = $filtrarIds[0];
                $idEvaluado = $filtrarIds[1];
                $grupoInscripcionMateria = Grupo_Inscripcion_Materia::where('grupo_id',$grupoId)->where('materia_inscripcion_carrera_id',$idInscripcionMateria)->first();

                if($idEvaluado == 0){

                    if($grupoInscripcionMateria){

                        $respuestas = Respuesta_Inscripcion_Materia::where('grupo_inscripcion_materia_id',$grupoInscripcionMateria->id)->get();
                        foreach ($respuestas as $respuesta) {
                            $respuesta->delete();
                        }

                        $comentariosRespuestas = Comentario_Evaluado_Materia::where('grupo_inscripcion_materia_id',$grupoInscripcionMateria->id)->get();
                        foreach ($comentariosRespuestas as $comentario) {
                            $comentario->delete();
                        }
                        echo json_encode($grupoInscripcionMateria);

                        $eliminar = $grupoInscripcionMateria->delete();

                        if($eliminar){
                            echo "Se elimino okok";
                        }else{
                            echo "no se elimino";
                        }

                    }

                }else{

                    if(!$grupoInscripcionMateria){
                        $grupoInscripcionMateria = new Grupo_Inscripcion_Materia();
                        $grupoInscripcionMateria->grupo_id = $grupoId;
                    }

                    $grupoInscripcionMateria->evaluado_id = $idEvaluado;
                    $grupoInscripcionMateria->materia_inscripcion_carrera_id = $idInscripcionMateria;


                    $grupoInscripcionMateria->save();

                    // -- Retornar correcto
                }

            } catch (\Exception $e) {
                //DB::rollBack();
//                return back()->withErrors(["generales" => "Ocurrió un error al guardar su información, inténtelo de nuevo más tarde."])->withInput();
                //return back()->withErrors(["generales" => $e->getMessage()])->withInput();
                $verifica = 0;
                $mensaje = json_encode($e->getMessage());
            }



        }
        if($verifica == 1){
            return json_encode(["estatus" => "success"]);
        }else{
            return json_encode(["estatus" => "Error", "mensaje" => $mensaje]);
        }


         

    }

    // -- Materias Acarreras
    public function inscripcionMaterias(){

        $materiasCarreras = MateriaInscripcionCarrera::whereIn('carrera_id',Session('directivo')->carreras())->get();
        $materias = Materia::orderBy("nombre","ASC")->get();
        $cuatrimestres = Cuatrimestre::all();
        $carreras = Carrera::WhereIn('id',Session('directivo')->carreras())->orderBy("nombre","ASC")->get();
        $planes = Plan_Estudio::all();
        return view("directivo.inscripcionMaterias",["materiasCarreras" => $materiasCarreras,"materias" => $materias, "cuatrimestres" => $cuatrimestres, "carreras" => $carreras, 'planes' => $planes]);
    }
    // -- Materias Acarreras
    public function detalleInscripcionMaterias($id){

        $inscripcion = MateriaInscripcionCarrera::whereIn('carrera_id',Session('directivo')->carreras())->where('id',$id)->first();
        $materias = Materia::orderBy("nombre","ASC")->get();
        $cuatrimestres = Cuatrimestre::all();
        $carreras = Carrera::WhereIn('id',Session('directivo')->carreras())->orderBy("nombre","ASC")->get();
        $planes = Plan_Estudio::all();
        return view("directivo.detalle_inscripcion_materia",["inscripcion" => $inscripcion,"materias" => $materias, "cuatrimestres" => $cuatrimestres, "carreras" => $carreras, 'planes' => $planes]);
    }

    // -- Materias
    public function materias(){
        $materias = Materia::all();
        return view("directivo.catalogoMaterias",["materias" => $materias]);
    }

        // -- Tutores a grupo
    public function inscripcionTutorGrupo(){
        $grupoInscripciontutor = Grupo_Inscripcion_Tutor::all();
        return view("directivo.grupos_inscripciones_tutor",["inscripciones" => $grupoInscripciontutor]);
    }

    // -- Tutores
    public function tutores(){
        $tutores = Tutor::where('area_id',Session('directivo')->area_id)->get();
        $areas = Area::where('id',Session('directivo')->area_id)->get();
        return view("directivo.tutores",["tutores" => $tutores, "areas" => $areas]);
    }

    public function evaluaciones(){
        $evaluaciones = Evaluacion::all();
        return view("directivo.evaluaciones",["evaluaciones" => $evaluaciones]);
    }

    public function detalleEvaluacion($slug){

        $evaluacion = Evaluacion::where('slug',$slug)->first();

        $idGrupos = [];
        $grupos = Grupo::whereIn('carrera_id',Session('directivo')->carreras())->get();

        // -- Recorrer el grupo para obtener su id
        foreach ($grupos as $grupo) {
            if(!in_array($grupo->id,$idGrupos)){

                $grupoAlumnosConEvaluacion = $grupo->alumnosEvaluacion();

                $grupo->alumnosConevaluacion = $grupoAlumnosConEvaluacion["conEvaluacion"];
                $grupo->alumnosSinevaluacion = $grupoAlumnosConEvaluacion["sinEvaluacion"];

                array_push($idGrupos,$grupo->id);
            }
        }

        $filtroConEvaluación = [];
        $filtroSinEvaluacion = [];
        $inscripcionesConEvaluacion = Grupo_Inscripcion_Alumno::whereIn('grupo_id',$idGrupos)->where('estatus',1)->get();
        foreach ($inscripcionesConEvaluacion as $inscripcion) {
            if($inscripcion->alumno->evaluacion == 1){
                array_push($filtroConEvaluación,$inscripcion->alumno->id);
            }else{
                array_push($filtroSinEvaluacion,$inscripcion->alumno->id);
            }
        }

        $inscripcionesSinEvaluacion = Grupo_Inscripcion_Alumno::whereIn('grupo_id',$idGrupos)->where('estatus',0)->get();
        foreach ($inscripcionesSinEvaluacion as $inscripcion) {
            if($inscripcion->alumno->evaluacion == 1){
                // -- Alumnos dados de baja
                //array_push($filtroSinEvaluación,$inscripcion->alumno->id);
            }
        }

        $alumnosConEvaluacion = Alumno::whereIn('id',$filtroConEvaluación)->get();
        $alumnosSinEvaluacion = Alumno::whereIn('id',$filtroSinEvaluacion)->get();

        return view("directivo.evaluacion_detalle",["evaluacion" => $evaluacion,"grupos" => $grupos, "inscripcionesConEvaluacion" => $alumnosConEvaluacion, "inscripcionesSinEvaluacion" => $alumnosSinEvaluacion]);

    }

    public function resultadosEvaluacion($slug){

        $evaluacion = Evaluacion::where('slug',$slug)->first();
        $idEvaluados = []; // Variables para alamacenar los ids de los evaluados en grupos
        $gruposEnEvaluacion = Grupo::where('evaluacion_id',$evaluacion->id)->get();

        // -- Recorrer cada grupo para sacar sus inscricciones de las materias
        foreach ($gruposEnEvaluacion as $grupo) {
            foreach ($grupo->inscripcionesMaterias as $inscripcionesMateria) {

                if(!in_array($inscripcionesMateria->evaluado_id,$idEvaluados))
                    array_push($idEvaluados,$inscripcionesMateria->evaluado_id);

            }
        }
        $evaluados = Evaluado::whereIn('id',$idEvaluados)->get();

        return view("directivo.resultados_evaluacion",["evaluacion" => $evaluacion, "evaluados" => $evaluados, "grupos" => $gruposEnEvaluacion]);
    }

    public function resultadosEvaluacionEvaluado($slug, $idEvaluado){

        $idGrupos = [];

        $evaluacion = Evaluacion::where("slug",$slug)->first();
        $evaluado = Evaluado::find($idEvaluado);

        $inscripcionesGrupoMateria = Grupo_Inscripcion_Materia::where('evaluado_id',$evaluado->id)->get();

        /*
         * Prgeuntas tipo Docente son para prifesores
         * Preguntas tipo Evauado son para infraestructura
         */
        $temasFiltrados = [];
        $temas = Tema::all();
        foreach ($temas as $tema){

            $tema->filtroPreguntas = Pregunta::where('tema_id',$tema->id)->where('tipo','Docente')->get();
            $tema->nPreguntas = count($tema->filtroPreguntas);

            if($tema->nPreguntas > 0 ){
                array_push($temasFiltrados,$tema);
            }

        }

        foreach ($temasFiltrados as $temasFiltrado) {

            $verificacionTema = 0;
            $sumaTema = 0;
            $nPreguntas = 0;
            $sumaTotalTema = 0;

            $detallesinscripciones = [];
            $promediosDePreguntas = [];
            foreach ($inscripcionesGrupoMateria as $inscripcion) {

                $verificacion = 1;
                $sumaInscripcion = 0;
                $nPreguntasInscripcion = 0;
                $sumaTotalInscripcion = 0;
                // -- Variable para saber cuantos alumnos contestaron la evaluación de la inscripción
                $inscripcion->nAlumnos = 0;
                /*
                echo "<br>Grupo: ";
                echo json_encode($inscripcion->grupo->nombre);
                echo "<br> Materia: ".$inscripcion->materia->materia->nombre;
                echo "<br><br>";
                */



                foreach ($temasFiltrado->filtroPreguntas as $filtroPregunta) {
                    //echo "Pregunta: ".$filtroPregunta->texto."<br>";
                    //echo "Pregunta: ".$filtroPregunta->id."<br><br>";
                    $respuestas = Respuesta_Inscripcion_Materia::where('grupo_inscripcion_materia_id',$inscripcion->id)->where('pregunta_id',$filtroPregunta->id)->get();
                    //echo "N Respuestas:<br>";
                    //echo count($respuestas)."<br>";
                    //echo "Respuestas: <br>";

                    $sumaPreguntaInscripcion = 0;
                    $promedioPreguntaInscripcion = 0;

                    if(count($respuestas) > 0){


                        $inscripcion->tema = $tema->nombre;
                        $verificacionTema = 1;
                        $verificacion = 1;

                        foreach ($respuestas as $respuesta) {
                            $inscripcion->nAlumnos = $inscripcion->nAlumnos + 1;
                            $sumaPreguntaInscripcion = $sumaPreguntaInscripcion + $respuesta->valor;
                            $sumaTema = $sumaTema + $respuesta->valor;
                            $nPreguntas ++;
                            $sumaTotalTema = $sumaTotalTema + 3;

                            $sumaInscripcion = $sumaInscripcion + $respuesta->valor;
                            $nPreguntasInscripcion ++;
                            $sumaTotalInscripcion = $sumaTotalInscripcion + 3;

                        }

                        $promedioPreguntaInscripcion = ($sumaPreguntaInscripcion * 3) / (count($respuestas) * 3);
                        //echo "Promeeeeeeeeeeeeedio: ".$promedioPreguntaInscripcion;

                    }else{
                        $verificacion = 0;
                    }
                    $inscripcionResultado = new Inscripcion_Resultado();
                    $inscripcionResultado->promedio = $promedioPreguntaInscripcion;
                    $inscripcionResultado->preguntaId = $filtroPregunta->id;
                    //echo "<br>********************************<br><br>".$inscripcionResultado."<br><br>********************************";
                    array_push($promediosDePreguntas, $inscripcionResultado);
                    //echo "<br>";
                }

                //echo "<br>///////////////////////////////////////////////////////////<br>";
                //echo json_encode($promediosDePreguntas);
                //echo "<br>///////////////////////////////////////////////////////////<br>";
                // -- Si si tenía respuestas
                if($verificacion == 1){

                    /*
                    echo "LA SUMA DE PREGUNTAS DEL GRUPO ".$inscripcion->grupo->nombre." ES DE: ".$nPreguntasInscripcion;
                    $temasFiltrado->sumaTotal = $sumaTema;
                    echo "<br>";
                    echo "LA SUMA TOTAL DE PREGUNTAS ES DE: ".$sumaInscripcion;
                    echo "<br>";
                    echo "LA SUMA TOTAL DE 3 ES DE: ".$sumaTotalInscripcion;
                    echo "<br>";
                    echo "EL PROMEDIO FINAL ES DE: ".round(($sumaInscripcion * 3) / $sumaTotalInscripcion, 2);
                    echo "<hr>";
                    */
                    $inscripcion->promedioTotal = round(($sumaInscripcion * 3) / $sumaTotalInscripcion, 2);

                }else{
                    /*
                    echo "LA SUMA DE PREGUNTAS DEL GRUPO ".$inscripcion->grupo->nombre." ES DE: ".$nPreguntasInscripcion;
                    echo "<br>INCOMPLEEEEETA<bR>";
                    echo "<hr>";
                    */
                    $inscripcion->promedioTotal = 0;
                }

                // -- Insertarle el promedio de cada pregunta individual




            }
            $temasFiltrado->respuestadePreguntas = $promediosDePreguntas;
            // -- Soma total del tema
            /*
            echo "<br>************************************************<br>";
            echo "EL TEMA ES: ".$temasFiltrado->nombre."<br><br>";
            echo "LA SUMA DE PREGUNTAS ES DE: ".$nPreguntas;
            echo "<br>";
            echo "LA SUMA TOTAL DE PREGUNTAS ES DE: ".$sumaTema;
            echo "<br>";
            echo "LA SUMA TOTAL DE 3 ES DE: ".$sumaTotalTema;
            echo "<br>";
            echo "EL PROMEDIO FINAL ES DE: ".round(($sumaTema * 3) / $sumaTotalTema, 2);
            echo "<hr>";
            echo "<hr>";
            echo "<hr>";
            echo "<hr>";
            echo "<hr>";
            echo "<br>************************************************<br>";
            */

            if($verificacionTema == 1){
                $temasFiltrado->promedioTotal = round(($sumaTema * 3) / $sumaTotalTema, 2);
                $temasFiltrado->promedioTotalEnEscalaA100 = round(($sumaTema * 100) / $sumaTotalTema);

            }else{
                $temasFiltrado->promedioTotal = 0;
                $temasFiltrado->promedioTotalEnEscalaA100 = 0;
            }

        }

        /*
        foreach ($temasFiltrados as $tema){
            echo $tema->promedioTotal;
        }
        */

        return view("directivo.resultados_evaluado_evaluacion",["evaluacion" => $evaluacion, "temas" => $temasFiltrados, "inscripciones" => $inscripcionesGrupoMateria]);

    }

    public function resultadosEvaluacionGrupo($slug, $slugGrupo){
        echo "Evaluado";
        $evaluacion = Evaluacion::where("slug",$slug)->first();
        echo json_encode($evaluacion);
        $grupo = Grupo::where("slug",$slugGrupo)->first();
        echo json_encode($grupo);
    }

    // -- Evaluado
    public function evaluados(){
        $areas = Area::where('id',Session('directivo')->area_id)->get();
        $tipos = Evaluado_Tipo::all();
        $evaluados = Evaluado::where("area_id",Session('directivo')->area_id)->get();
        return view("directivo.evaluados",["areas" => $areas, "tipos" => $tipos, "evaluados" => $evaluados]);
    }

    // -- Personal
    public function personal(){
        $personal = Personal::all();
        return view("directivo.personal",["personal" => $personal]);
    }

}
