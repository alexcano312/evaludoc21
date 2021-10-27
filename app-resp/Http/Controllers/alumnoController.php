<?php

namespace App\Http\Controllers;

use App\Actividad;
use App\Alumno;
use App\Alumno_Actividad;
use App\Alumno_Codigo;
use App\Carrera;
use App\Comentario_Actividad;
use App\Comentario_Evaluado_Materia;
use App\Comentario_Infraestructura;
use App\Comentario_Tutor;
use App\Cuatrimestre;
use App\Evaluacion;
use App\Evaluado;
use App\Generacion;
use App\Grupo;
use App\Grupo_Inscripcion_Alumno;
use App\Grupo_Inscripcion_Materia;
use App\Grupo_Inscripcion_Tutor;
use App\Herramienta;
use App\Materia;
use App\Infraestructura_Inscripcion_Alumno;
use App\Personal;
use App\Pregunta;
use App\Respuesta_Evaluado;
use App\Respuesta_Inscripcion_Actividad;
use App\Respuesta_Inscripcion_Materia;
use App\Respuesta_Inscripcion_Tutor;
use Illuminate\Http\Request;
use Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use DateTime;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use App\Mail\EnviarCorreo;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
class alumnoController extends Controller
{

    // -- Agregar Actividad
    public function agregar (Request $request){

        Validator::make($request->all(), [
            "nombre" => "required",
            "apellidos" => "required",
            "sexo" => "required",
            "generacion" => "required",
            "carrera" => "required",
            "matricula" => "required",
            "estatus" => "required",
        ], [
            "nombre.required" => "Debe ingresar un nombre.",
            "apellidos.required" => "Debe ingresar los apellidos",
            "sexo.required" => "Debe ingresar el sexo",
            "generacion.required" => "Debe ingresar la generación",
            "carrera.required" => "Debe ingresar la carrera",
            "matricula.required" => "Debe ingresar la matricula",
            "estatus.required" => "Debe ingresar el estatus",
        ])->validated();

        $alumno = Alumno::where("matricula",$request->matricula)->first();

        // -- Verificar que no exita un cliente con el mismo correo o teléfono.
        if ($alumno) {
            return back()->withErrors(["generales" => "Ya existe un alumno con esa matricula"])->withInput();
        } else {

            try {

                DB::beginTransaction();

                $alumno = new Alumno();
                $alumno->nombre = mb_strtoupper($request->nombre);
                $alumno->apellidos = mb_strtoupper($request->apellidos);
                $alumno->sexo = $request->sexo;
                $alumno->matricula = $request->matricula;
                $alumno->generacion_id = $request->generacionId;
                $alumno->carrera_id = $request->carreraId;
                $alumno->tipo = $request->tipo;
                $alumno->estatus = $request->estatus;
                $alumno->evaluacion = 0;
                $alumno->save();
                

                if($request->actividadId){

                    if($request->actividadId != 0){
                        $inscripcionActividad = new Alumno_Actividad();
                        $inscripcionActividad->actividad_id = $request->actividadId;
                        $inscripcionActividad->alumno_id = $alumno->id;
                        $inscripcionActividad->estatus = 1;
                        $inscripcionActividad->save();
                    }

                }

                if($request->grupoId){
                    $inscripcionGrupo = new Grupo_Inscripcion_Alumno();
                    $inscripcionGrupo->alumno_id = $alumno->id;
                    $inscripcionGrupo->grupo_id = $request->grupoId;
                    $inscripcionGrupo->estatus = 1;
                    $inscripcionGrupo->save();
                }

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

    // -- Vista Login alumno
    public  function login(){

        $generaciones = Generacion::where('estatus',1)->get();
        $carreras = Carrera::orderBy("nombre","ASC")->get();
        $actividades = Actividad::orderBy("nombre", "ASC")->get();
        $grupos = Grupo::orderBy("carrera_id","DESC")->get();
        return view("alumno.login",["generaciones" => $generaciones, "carreras" => $carreras, "actividades", "actividades" => $actividades, "grupos" => $grupos]);
    }

    // -- Vista alumno Inicio
    public  function inicio(){
        $alumno = Alumno::find(Session::get("alumno")->id);
        $evaluacion = Evaluacion::where('estatus',1)->first();
        return view("alumno.inicio",["alumno" => $alumno, 'evaluacion' => $evaluacion]);

    }

    public function contestarEvaluacion($slug){

        $alumno = Alumno::find(Session::get("alumno")->id);

        // -- Obtener la evaluación del slug
        $evaluacion = Evaluacion::where('slug',$slug)->first();

        if (!$evaluacion) {
            return redirect()->route("alumno.inicio");
        }

        if($evaluacion->estatus == 0){
            return redirect()->route("alumno.inicio");
        }

        // Obtener la inscripcion actual del alumno
        $inscripcionGrupoActual = $alumno->grupoActual();

        // -- Obtener el grupo actual
        
        $grupo = Grupo::find($inscripcionGrupoActual->grupo_id);



        // -- EVALUACIÓN DE DOCENTES



        // -- variable para almacenar los id de las preguntas que ya se contestaron
        $preguntasResultas = [];

        // -- Variable para almacenar la inscripción que se va a retornar
        $informacionInscripcion = null;

        // -- Obtener la cantidad de preguntas de docentes
        $nPreguntas = Pregunta::where("tipo","Docente")->count();

        // -- Variable para saber si ya contesto todas la preguntas
        $respuestasTotales = count($grupo->inscripcionesMaterias) * $nPreguntas;

        // -- Obtener todas las inscripciones de las materias registradas en ese grupo
        foreach ($grupo->inscripcionesMaterias as $inscripcion){


            // -- Buscar todas las respuestas del alumno con respecto a la inscripción
            $respuestas = Respuesta_Inscripcion_Materia::where('grupo_inscripcion_materia_id',$inscripcion->id)->where("alumno_id",Session::get("alumno")->id)->get();

            // -- Verificar si existen repsuestas para todas las preguntas de esa inscripción
            if(count($respuestas) < $nPreguntas){

                if($respuestas){

                    // --- Recorrer  las respuestas para saber cuales no se deben buscar
                    foreach ($respuestas as $respuesta){
                        array_push($preguntasResultas, $respuesta->pregunta_id);
                    }

                    // -- Asignarle la isncripción a la variable de apoyo "informacionInscripcion" para retornar la isncripción a la vista
                    $informacionInscripcion = $inscripcion;
                    break;

                }

            }else{
                $preguntasResultas = [];
                $informacionInscripcion = null;
            }
        }
        // -- Contar las repsuestas totales del alumno
        $respuestas = Respuesta_Inscripcion_Materia::where("alumno_id",Session::get("alumno")->id)->where("grupo_id",$grupo->id)->count();
        // -- Verificar la cantidad de respuestas para saber si ha concluido
        if($respuestas != $respuestasTotales){

            // -- Buscar las preguntas pendientes de la isncripción con respecto al alumno
            $preguntasPendientes = Pregunta::where('tipo','Docente')->whereNotIn('id',$preguntasResultas)->orderBy("tema_id","ASC")->get();
            return view("alumno.cuestionario",["preguntas" => $preguntasPendientes, "inscripcion" => $informacionInscripcion, "slug" => $slug]);

        }



        // -- EVALUACIÓN DEL TUTOR


        // -- Verificar si ya evaluo al tutor
        if ($grupo->inscripcionTutor){

            // -- Obtener todas la presguntas de tutores
            $preguntasTutores = Pregunta::where('tipo','Tutor')->get();

            // -- Contar todas la preguntas de tutores
            $nPreguntasTutores = count($preguntasTutores);

            // -- Obtener todas las respuestas del alumno con respecto al tutor
            $respuestasTutores = Respuesta_Inscripcion_Tutor::where('alumno_id',Session::get("alumno")->id)->where('grupo_inscripcion_tutor_id',$grupo->inscripcionTutor->id)->get();

            // -- Si aún tiene preguntas pendientes

            if(count($respuestasTutores) < $nPreguntasTutores){


                // -- Variable de apoyo para almacenar el id de las preguntas que ya contesto
                $preguntasResultasTutor = [];

                // -- Recorrer las respuestas para saber el id de las que contesto e insertarla en el array
                foreach ($respuestasTutores as $respuesta) {

                    array_push($preguntasResultasTutor, $respuesta->pregunta_id);

                }

                // -- Asignarle la isncripción a la variable de apoyo "informacionInscripcion" para retornar la isncripción a la vista
                $informacionInscripcionTutor = $grupo->inscripcionTutor;

                // -- obtener todas las preguntas pendientes
                $preguntasPendientesTutor = Pregunta::where('tipo','Tutor')->whereNotIn('id',$preguntasResultasTutor)->orderBy("tema_id","ASC")->get();

                return view("alumno.cuestionario_tutor",["preguntas" => $preguntasPendientesTutor, "inscripcion" => $informacionInscripcionTutor, "slug" => $slug]);

            }

        }


        // -- EVALUACIÓN DEL TUTOR


        // -- Verificar si ya evaluo a su actividad
        if ($alumno->inscripcionActividad){

            // -- Verificar que se encuentre activa suinscripción a su actividad
            if($alumno->inscripcionActividad->estatus == 1){

                // -- Obtener todas las preguntas de las actividades
                $preguntasActividades = Pregunta::where("tipo","Actividad")->get();

                // -- Saber cuantas prgeuntas de actividades hay
                $nPreguntasActividades = count($preguntasActividades);

                // -- Obtener todas las respuestas del alumno con respecto a la actividad
                $respuestasActividad = Respuesta_Inscripcion_Actividad::where('alumno_inscripcion_actividad_id',$alumno->inscripcionActividad->id)->get();

                if(count($respuestasActividad) < $nPreguntasActividades){

                    // -- Variable de apoyo para saber que preguntas ya contesto de actividades
                    $preguntasResultasActividad = [];
                    
                    // -- Recorrer las preguntas resueltas para saber cuales no ha contestado
                    foreach ($preguntasResultasActividad as $preguntaActividad) {

                        // -- Insertar id de la pregunta para poder filtrar en la consulta (Más abajo)
                        array_push($preguntasResultasActividad, $preguntaActividad->pregunta_id);

                        // -- Asignarle la isncripción a la variable de apoyo "informacionInscripcion" para retornar la isncripción a la vista
                        $informacionInscripcionActividad = $alumno->inscripcionActividad;

                    }

                    // -- obtener todas las preguntas pendientes
                    $preguntasPendientesActividad = Pregunta::where('tipo','Actividad')->whereNotIn('id',$preguntasResultasActividad)->orderBy("tema_id","ASC")->get();


                    return view("alumno.cuestionario_actividad",["preguntas" => $preguntasPendientesActividad, "inscripcion" => $alumno->inscripcionActividad, "slug" => $slug]);
                }
            }

        }


        // -- Buscar si realizo la encuestra de infraestructura
        $inscripcionInfraestructura = Infraestructura_Inscripcion_Alumno::where("inscripcion_alumno_id",$inscripcionGrupoActual->id)->first();

        if(!$inscripcionInfraestructura){

            // -- Obtener todas las preguntas de las actividades
            $preguntasInfraestructura = Pregunta::where("tipo","Evaluado")->get();

            return view("alumno.cuestionario_evaluado",["preguntas" => $preguntasInfraestructura, "inscripcion" => $inscripcionGrupoActual, "slug" => $slug]);

        }

        // -- Mostrar código


        // -- Objeto para crear la cadena de codigo aleatorio

        $herramienta = new Herramienta();

        // -- Generar el código de la evaluación.
        $codigo = new Alumno_Codigo();
        $codigo->alumno_id = $alumno->id;
        $codigo->evaluacion_id = $evaluacion->id;

        // -- Crear un código que no exista
        $aux = false;
        while ($aux == false){
            $generarCodigo = $herramienta->crearCodigo();
            $verificaCodigo = Alumno_Codigo::where("codigo",$generarCodigo)->first();
            if(!$verificaCodigo){
                $aux = true;
            }
        }

        $codigo->codigo = $generarCodigo;
        $codigo->save();

        // -- Cambiarle el estatus al alumno, para saber que ya realizo su evaluación
        $alumno->evaluacion = 1;
        $alumno->save();


        return redirect()->route("alumno.codigo.evaluacion",["slug"=>$slug, "correo" => 1]);


    }

    // -- Guardar respuestas de evaluados realizadas por alumnos
    public function evaluarEvaluado (Request $request){

        // -- Si la evaluación es de un docente
        if($request->tipo_evaluacion == "Docente"){
            // -- Buscar la inscripción de la materia y docente proveniente del formulario
            $inscripcion = Grupo_Inscripcion_Materia::find($request->inscripcionId);
            if(!$inscripcion){
                return redirect()->route("alumno.inicio");
            }

            for($x = 1; $x <= $request->nPreguntas; $x++){

                // -- variable para construir el nombre de la pregunta
                $nombrePregunta = "p_".$x;
                // -- Se optiene el id de la pregunta por medio del nombre construido
                $preguntaId = $request->$nombrePregunta;

                // -- se optiene el valor de la respuesta por medio del nombre construido
                $nombreRespuesta = "n_".$preguntaId;
                $valor = $request->$nombreRespuesta;

                $verificacionRespuesta = Respuesta_Inscripcion_Materia::where("alumno_id",Session::get("alumno")->id)->where("pregunta_id",$preguntaId)->where("grupo_inscripcion_materia_id",$inscripcion->id)->first();
                echo json_encode($verificacionRespuesta);
                if(!$verificacionRespuesta){
                    // -- Guardar respuesta con lso valores recibidos
                    $respuesta = new Respuesta_Inscripcion_Materia();
                    $respuesta->grupo_id = $inscripcion->grupo_id;
                    $respuesta->grupo_inscripcion_materia_id = $inscripcion->id;
                    $respuesta->alumno_id = Session::get("alumno")->id;
                    $respuesta->pregunta_id = $preguntaId;
                    $respuesta->valor = $valor;
                    $respuesta->save();
                }


            }

            // -- Si el alumno escribio un comentario
            if($request->comentario){
                $comentario = new Comentario_Evaluado_Materia();
                $comentario->grupo_id = $inscripcion->grupo_id;
                $herramienta = new Herramienta();
                $comentario->texto = mb_strtoupper(str_replace("-"," ",$herramienta->crearSlug(substr(mb_strtoupper($request->comentario),0,256))));
                $comentario->grupo_inscripcion_materia_id = $inscripcion->id;
                $comentario->save();
            }

        // -- Si la evaluación es tutor
        }elseif ($request->tipo_evaluacion == "Tutor"){
            // -- Obtener la inscripción del tutor al grupo
            $inscripcion = Grupo_Inscripcion_Tutor::find($request->inscripcionId);

            if(!$inscripcion){
                return redirect()->route("alumno.inicio");
            }

            for($x = 1; $x <= $request->nPreguntas; $x++){

                // -- variable para construir el nombre de la pregunta
                $nombrePregunta = "p_".$x;
                // -- Se optiene el id de la pregunta por medio del nombre construido
                $preguntaId = $request->$nombrePregunta;

                // -- se optiene el valor de la respuesta por medio del nombre construido
                $nombreRespuesta = "n_".$preguntaId;
                $valor = $request->$nombreRespuesta;

                $verificacionRespuestaTutor = Respuesta_Inscripcion_Tutor::where("alumno_id",Session::get("alumno")->id)->where("pregunta_id",$preguntaId)->where("grupo_inscripcion_tutor_id",$inscripcion->id)->first();
                // -- Guardar respuesta con lso valores recibidos
                if(!$verificacionRespuestaTutor) {
                    $respuesta = new Respuesta_Inscripcion_Tutor();
                    $respuesta->grupo_inscripcion_tutor_id = $inscripcion->id;
                    $respuesta->alumno_id = Session::get("alumno")->id;
                    $respuesta->pregunta_id = $preguntaId;
                    $respuesta->valor = $valor;
                    $respuesta->save();
                }

            }

            // -- Si el alumno escribio un comentario
            if($request->comentario){
                $comentario = new Comentario_Tutor();
                $comentario->grupo_id = $inscripcion->grupo_id;
                $comentario->texto = mb_strtoupper(str_replace("-"," ",$herramienta->crearSlug(substr(mb_strtoupper($request->comentario),0,256))));
                $comentario->grupo_inscripcion_tutor_id = $inscripcion->id;
                $comentario->save();
            }

        // -- Si la evaluación es una actividad
        }elseif ($request->tipo_evaluacion == "Actividad"){

            // -- Obtener la inscripción del tutor al grupo
            $inscripcion = Alumno_Actividad::find($request->inscripcionId);

            if(!$inscripcion){
                return redirect()->route("alumno.inicio");
            }

            $alumno = Alumno::find(Session::get("alumno")->id);
            // Obtener la inscripcion actual del alumno
            $inscripcionGrupoActual = $alumno->grupoActual();

            // -- Obtener el grupo actual
            $grupo = Grupo::find($inscripcionGrupoActual->grupo_id);

            for($x = 1; $x <= $request->nPreguntas; $x++){

                // -- variable para construir el nombre de la pregunta
                $nombrePregunta = "p_".$x;
                // -- Se optiene el id de la pregunta por medio del nombre construido
                $preguntaId = $request->$nombrePregunta;

                // -- se optiene el valor de la respuesta por medio del nombre construido
                $nombreRespuesta = "n_".$preguntaId;
                $valor = $request->$nombreRespuesta;

                // -- Guardar respuesta con lso valores recibidos
                $verificacionRespuestaActividad = Respuesta_Inscripcion_Actividad::where("alumno_inscripcion_actividad_id",$inscripcion->id)->where("prgeunta_id",$preguntaId)->where("alumno_inscripcion_actividad_id",$inscripcion->id)->first();
                if(!$verificacionRespuestaActividad) {
                    $respuesta = new Respuesta_Inscripcion_Actividad();
                    $respuesta->grupo_id = $grupo->id;
                    $respuesta->alumno_inscripcion_actividad_id = $inscripcion->id;
                    $respuesta->entrenador_id = $inscripcion->actividad->entrenador->id;
                    $respuesta->valor = $valor;
                    $respuesta->pregunta_id = $preguntaId;

                    $respuesta->save();
                }

            }


            // -- Si el alumno escribio un comentario
            if($request->comentario){
                $comentario = new Comentario_Actividad();
                $comentario->grupo_id = $grupo->id;
                $comentario->texto = mb_strtoupper(str_replace("-"," ",$herramienta->crearSlug(substr(mb_strtoupper($request->comentario),0,256))));
                $comentario->actividad_inscripcion_alumno_id = $inscripcion->id;
                $comentario->save();
            }

        }elseif ($request->tipo_evaluacion == "Evaluado"){

            $alumno = Alumno::find(Session::get("alumno")->id);
            // Obtener la inscripcion actual del alumno
            $inscripcionGrupoActual = $alumno->grupoActual();

            // -- Obtener el grupo actual
            $grupo = Grupo::find($inscripcionGrupoActual->grupo_id);

            for($x = 1; $x <= $request->nPreguntas; $x++){

                // -- variable para construir el nombre de la pregunta
                $nombrePregunta = "p_".$x;
                // -- Se optiene el id de la pregunta por medio del nombre construido
                $preguntaId = $request->$nombrePregunta;

                // -- se optiene el valor de la respuesta por medio del nombre construido
                $nombreRespuesta = "n_".$preguntaId;
                $valor = $request->$nombreRespuesta;

                // -- Guardar respuesta con lso valores recibidos
                $respuesta = new Respuesta_Evaluado();
                $respuesta->grupo_id = $grupo->id;
                $respuesta->valor = $valor;
                $respuesta->pregunta_id = $preguntaId;
                $respuesta->save();

            }


            // -- Si el alumno escribio un comentario
            if($request->comentario){
                $comentario = new Comentario_Infraestructura();
                $comentario->grupo_id = $grupo->id;
                $comentario->texto = mb_strtoupper(str_replace("-"," ",$herramienta->crearSlug(substr(mb_strtoupper($request->comentario),0,256))));
                $comentario->save();
            }

            $registroevaluacionInfraestructura = new Infraestructura_Inscripcion_Alumno();
            $registroevaluacionInfraestructura->inscripcion_alumno_id = $inscripcionGrupoActual->id;
            $registroevaluacionInfraestructura->save();

        }

        return redirect()->route("alumno.contestar.evaluacion",["slug"=>$request->slug]);
    }

    // -- Vista de fin de evaluación
    public  function codigoEvaluacion ($slug, $correo){

        // -- Buscar la evaluación conrespondiente con su slug
        $evaluacion = Evaluacion::where('slug',$slug)->first();
        if(!$evaluacion){
            return redirect()->route("alumno.inicio");
        }

        // -- Buscar el código del alumno con respecto a su evaluación
        $codigo = Alumno_Codigo::where('alumno_id',Session::get("alumno")->id)->where('evaluacion_id',$evaluacion->id)->first();

        if(!$codigo){
            return redirect()->route("alumno.inicio");
        }

        $constructorCodigo = encrypt($codigo->codigo."_".Session::get("alumno")->matricula);

        $codigo->contructrorCodigo = $constructorCodigo;

        return view("alumno.codigo",["evaluacion" => $evaluacion, "codigo" => $codigo, "correo" => $correo]);
    }

    // -- Vista del pdf
    public function pdfEvaluacion($slug){

        // -- Buscar la evaluación conrespondiente con su slug
        $evaluacion = Evaluacion::where('slug',$slug)->first();
        if(!$evaluacion){
            return redirect()->route("alumno.inicio");
        }

        // -- Buscar el código del alumno con respecto a su evaluación
        $codigo = Alumno_Codigo::where('alumno_id',Session::get("alumno")->id)->where('evaluacion_id',$evaluacion->id)->first();

        if(!$codigo){
            return redirect()->route("alumno.inicio");
        }

        $constructorCodigo = encrypt($codigo->codigo."_".Session::get("alumno")->matricula);

        $codigo->contructrorCodigo = $constructorCodigo;

        //echo $constructorCodigo;
        $pdf = PDF::loadView('alumno.pdf.pdf_codigo', compact('evaluacion','codigo'));

        return $pdf->download(strtolower(Session::get("alumno")->nombre.'_'.Session::get("alumno")->apellidos).'_evaluacion_'.$evaluacion->slug.'.pdf');
    }

    // -- Validar código de evaluación
    public function validarCodigo($datos){


        try {
            $cadena = Crypt::decrypt($datos);
        } catch (DecryptException $e) {
            //
            return view("alumno.validar_codigo");
        }

        //echo json_encode($verificaCadena);


        // -- Separar cadena para obtener el codigo y la matricula
        $separarCadena = explode('_',$cadena);

        $codigo = $separarCadena[0];

        $matricula = $separarCadena[1];

        $alumno = Alumno::where("matricula",$matricula)->first();

        if(!$alumno){
            echo "Código incorrecto";
        }

        $verificaCodigo = Alumno_Codigo::where("alumno_id",$alumno->id)->where("codigo",$codigo)->first();

        if(!$verificaCodigo){
            echo "Codigo incorrecto";
        }

        $constructorCodigo = encrypt($verificaCodigo->codigo."_".Session::get("alumno")->matricula);

        $verificaCodigo->contructrorCodigo = $constructorCodigo;

        $evaluacion = Evaluacion::find($verificaCodigo->evaluacion_id);

        return view("alumno.validar_codigo",["evaluacion" => $evaluacion, "codigo" => $verificaCodigo, "alumno" => $alumno, "url" => $datos]);

    }

    // -- Enviar Evaluacion
    public function enviarEvaluacion(Request $request){

        // -- Buscar el código del alumno con respecto a su evaluación
        $codigo = Alumno_Codigo::find($request->codigoId);

        if(!$codigo){
            return redirect()->route("alumno.inicio");
        }

        // -- Buscar la evaluación conrespondiente con su slug
        $evaluacion = Evaluacion::find($codigo->evaluacion_id);
        if(!$evaluacion){
            return redirect()->route("alumno.inicio");
        }

        $constructorCodigo = encrypt($codigo->codigo."_".Session::get("alumno")->matricula);

        $codigo->contructrorCodigo = $constructorCodigo;

        Mail::to($request->correo)->send(new EnviarCorreo($codigo));


        return redirect()->route("alumno.codigo.evaluacion",["slug" => $evaluacion->slug,"correo" => $request->correo]);
    }

    // -- Login
    public function verificarCredenciales (Request $request){

        $validator = Validator::make($request->all(), [
            "matricula" => "required",
            "matricula_2" => "required",
        ], [
            "matricula.required" => "Debe ingresar la matricula.",
            "matricula_2.required" => "Debe ingresar nuevamente la matricula.",
        ]);


        if ($validator->fails())
            return back()->withErrors($validator->errors())->withInput();

        if($request->matricula != $request->matricula_2)
            return back()->withErrors(["generales" => "Las matriculas no son iguales."])->withInput();

        $alumno = Alumno::where("matricula", $request->matricula)->first();
        if (!$alumno)
            return back()->withErrors(["generales" => "No fue posible encontrar el alumno."])->withInput();

        Session::put("alumno", $alumno);

        if($request->url){
            $url = decrypt($request->url);
            return redirect($url);
        }else{
            return redirect()->route("alumno.inicio");
        }

    }

    // -- Cerrar sesion
    public function cerrarSesion()
    {
        if (Session::has("alumno"))
            Session::forget("alumno");

        return redirect()->route("alumno.login");
    }
}
