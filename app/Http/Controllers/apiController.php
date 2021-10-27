<?php

namespace App\Http\Controllers;

use App\Actividad;
use App\Alumno;
use App\Alumno_Actividad;
use App\Alumno_Codigo;
use App\Area;
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
use App\Trayectoria;
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

class apiController extends Controller
{
    //////////////////////////////////
    //                              //
    //           Alumnos            //
    //                              //
    //////////////////////////////////

    // -- Verificar si el alumno se encuentra registrado
    public function alumnoVerificar($matricula = false)
    {

        if ($matricula == false) {
            echo json_encode(["estatus" => "error"]);
        }

        $alumno = Alumno::where("matricula", $matricula)->first();

        if ($alumno) {
            echo json_encode(["estatus" => "success"]);
        } else {
            echo json_encode(["estatus" => "error"]);
        }

    }

    // -- Detalles del alumno
    public function alumnoDetalles($matricula = false)
    {

        if ($matricula == false) {
            echo json_encode(["estatus" => "error"]);
        }

        $alumno = Alumno::where("matricula", $matricula)->first();

        if ($alumno) {

            // -- verificar si tiene actividad extracurricular
            $alumno->inscripcionGrupoAlumnoId = $alumno->grupoActual()->id;
            $alumno->grupoNombre = $alumno->grupoActual()->grupo->nombre;
            $alumno->carreraNombre = $alumno->carrera->nombre;
            $alumno->generacionNombre = $alumno->generacion->nombre;
            $alumno->actividadExtracurricularNombre = $alumno->inscripcionActividad->actividad->nombre;
            echo json_encode(["estatus" => "success", "alumno" => $alumno]);

        } else {
            echo json_encode(["estatus" => "error"]);
        }

    }



    //////////////////////////////////
    //                              //
    //           Personal           //
    //                              //
    //////////////////////////////////

    // -- Detalles del Personal
    public function personalDetalles($id = false)
    {

        if ($id == false) {
            echo json_encode(["estatus" => "error"]);
        }

        $personal = Personal::find($id);

        if ($personal) {

            echo json_encode(["estatus" => "success", "personal" => $personal]);

        } else {
            echo json_encode(["estatus" => "error"]);
        }

    }

    // -- Agregar Actividad
    public function agregar(Request $request)
    {

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

        $alumno = Alumno::where("matricula", $request->matricula)->first();

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


                if ($request->actividadId) {

                    if ($request->actividadId != 0) {
                        $inscripcionActividad = new Alumno_Actividad();
                        $inscripcionActividad->actividad_id = $request->actividadId;
                        $inscripcionActividad->alumno_id = $alumno->id;
                        $inscripcionActividad->estatus = 1;
                        $inscripcionActividad->save();
                    }

                }

                if ($request->grupoId) {
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
    public function login()
    {

        $generaciones = Generacion::where('estatus', 1)->get();
        $carreras = Carrera::orderBy("nombre", "ASC")->get();
        $actividades = Actividad::orderBy("nombre", "ASC")->get();
        $grupos = Grupo::orderBy("carrera_id", "DESC")->get();
        return view("alumno.login", ["generaciones" => $generaciones, "carreras" => $carreras, "actividades", "actividades" => $actividades, "grupos" => $grupos]);
    }

    /*
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

    */
    public function verGrupos()
    {
        $grupos = Grupo::orderBy('nombre')->get();
        return json_encode(["estado" => true, "detalle" => $grupos]);
    }

    public function alumnosFaltantes($id)
    {
        $grupo = Grupo::where("id", $id)->first();
        $alumnos = $grupo->inscripcionesAlumno;
        $alumnosFalt = [];
        foreach ($alumnos as $alumnoF) {
            $alum = $alumnoF->alumno;
            $alum->generacion;
            $alum->carrera;
            if ($alum->evaluacion == 0) {
                array_push($alumnosFalt, $alum);
            }
        }
        echo json_encode(["estado" => true, "detalle" => $alumnosFalt]);
    }

    public function datosGraficas($id, $idE)
    {
        $carreras = Carrera::where("area_id", $id)->get();
        for ($i = 0; $i < count($carreras); $i++) {
            $carreras[$i]["mujeres"] = 0;
            $carreras[$i]["hombres"] = 0;
        }
        $arrGruposCarrera = [];
        foreach ($carreras as $carrera) {
            $grupos = Grupo::where("carrera_id", $carrera->id)->where("evaluacion_id",$idE)->get();
            array_push($arrGruposCarrera, $grupos);
        }
        $alumnosFalt = 0;
        $alumnosFaltArr = [];
        $alumnosFaltHomres = 0;
        $alumnosFaltMujeres = 0;
        foreach ($arrGruposCarrera as $grupoCarr) {
            foreach ($grupoCarr as $grupo) {
                $alumnos = $grupo->inscripcionesAlumno;
                foreach ($alumnos as $alumnoF) {
                    $alum = $alumnoF->alumno;
                    $grupoA=$alum->grupoActual();
                    if ($alum->estatus == "Activo") {
                        $idCarrera = $alum->carrera->id;
                        if ($alum->evaluacion == 0)
                        {
                            $alum->generacion;
                            $alumnoParaArreglo=["alumno"=>$alum,"grupoActual"=>$grupoA->grupo];
                            array_push($alumnosFaltArr,$alumnoParaArreglo);
                            $alumnosFalt++;
                            if ($alum->sexo == 1) {
                                for ($i = 0; $i < count($carreras); $i++) {
                                    if ($carreras[$i]["id"] == $idCarrera) {
                                        $a = $carreras[$i]["hombres"] + 1;
                                        $carreras[$i]["hombres"] = $a;
                                    }
                                }
                                $alumnosFaltHomres++;
                            } else {
                                for ($i = 0; $i < count($carreras); $i++) {
                                    if ($carreras[$i]["id"] == $idCarrera) {
                                        $a = $carreras[$i]["mujeres"] + 1;
                                        $carreras[$i]["mujeres"] = $a;
                                    }
                                }
                                $alumnosFaltMujeres++;
                            }
                        }
                    }
                }
            }
        }
        $grupos = Grupo::where("evaluacion_id", $idE)->get();
        $arrayProfes = [];
        $arrayTutores = [];
        foreach ($grupos as $grupo) {
            $materias = $grupo->inscripcionesMaterias;
            $tutores = $grupo->inscripcionTutor;
            foreach ($materias as $materia) {
                $idProf = $materia->evaluado_id;
                if (!in_array($idProf, $arrayProfes)) {
                    array_push($arrayProfes, $idProf);
                }
            }
            if ($tutores) {
                $idTutor = $tutores->tutor_id;
                if (!in_array($idTutor, $arrayTutores)) {
                    array_push($arrayTutores, $idTutor);
                }

            }
        }
        $numProfEvaluados = count($arrayProfes);
        $numTutoresEvaluados = count($arrayTutores);
        return json_encode(["estado" => true, "detalle" => ["arrFaltantes" => ["Hombres" => $alumnosFaltHomres,
            "Mujeres" => $alumnosFaltMujeres], "carreras" => $carreras, "numProfEvaluados" => $numProfEvaluados,
            "numTutoresEvaluados" => $numTutoresEvaluados,"alumnosFaltos"=>$alumnosFaltArr]]);
    }
}
