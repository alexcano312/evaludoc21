<?php

namespace App\Http\Controllers;
use App\Evaluado;
use App\Grupo;
use App\Materia;
use App\Grupo_Inscripcion_Tutor;
use App\Personal;
use App\Tutor;
use Illuminate\Http\Request;
use App\Herramienta;
use DateTime;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class gruposInscripcionTutoresController extends Controller
{
    // -- Agregar Actividad
    public function agregar (Request $request){

        Validator::make($request->all(), [
            "tutorId" => "required",
            "grupoId" => "required",
        ], [
            "evaluadoId.required" => "Debe ingresar un tutor.",
            "grupoId.required" => "Debe ingresar un grupo.",
        ])->validated();

        $verificaGrupo = Grupo_Inscripcion_Tutor::where("grupo_id",$request->grupoId)->first();

        if ($verificaGrupo) {

            return back()->withErrors(["generales" => "Ya existe un tutor asignado en ese grupo"])->withInput();

        } else {

            try {

                $tutor = Tutor::find($request->tutorId);
                if(!$tutor){
                    return back()->withErrors(["generales" => "No fue posible validar el tutor"])->withInput();
                }
                // -- Validar que el personal exista
                $personal = Personal::find($tutor->personal_id);

                if(!$personal){
                    return back()->withErrors(["generales" => "No fue posible validar el tutor con el evaluado"])->withInput();
                }

                /*
                $nombre = $personal->nombre." ".$personal->apellidos;
                if($nombre != $request->buscarNombre){
                    return back()->withErrors(["generales" => "No fue posible encontrar al tutor"])->withInput();
                }
                */

                // -- Validar que el grupo exista
                $grupo = Grupo::where('id',$request->grupoId)->where('nombre',$request->buscarGrupo)->first();

                if(!$grupo){
                    return back()->withErrors(["generales" => "No fue posible encontrar el grupo"])->withInput();
                }
                DB::beginTransaction();

                $grupoInscripcionTutor = new Grupo_Inscripcion_Tutor();
                $grupoInscripcionTutor->tutor_id = $request->tutorId;
                $grupoInscripcionTutor->grupo_id = $request->grupoId;
                $grupoInscripcionTutor->estatus = $request->estatus;


                $grupoInscripcionTutor->save();

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
}
