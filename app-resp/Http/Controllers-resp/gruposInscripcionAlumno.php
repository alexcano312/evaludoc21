<?php

namespace App\Http\Controllers;

use App\Alumno;
use App\Directivo;
use App\Grupo_Inscripcion_Alumno;
use Illuminate\Http\Request;
use DateTime;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class gruposInscripcionAlumno extends Controller
{
    // Agregar Directivo
    public function agregar (Request $request){

        Validator::make($request->all(), [
            "alumnoId" => "required",
            "grupoId" => "required",
            "estatus" => "required",
        ], [
            "alumnoId.required" => "Debe seleccionar un alumno.",
            "grupoId.required" => "Debe seleccionar un grupo.",
            "estatus.required" => "Debe seleccionar un estatus.",
        ])->validated();


        // -- Verificar el alumno con lo que recibe.
        if($request->alumnoId == ""){
            return back()->withErrors(["alumnoId" => "Selecciona el alumno"])->withInput();
        }


        $alumno = Alumno::find($request->alumnoId);
        $nombre = $alumno->nombre." ".$alumno->apellidos;
        if($nombre != $request->buscarNombre){
            return back()->withErrors(["alumnoId" => "No es posible encontrar el alumno"])->withInput();
        }

        // -- Verificar que el alumno no cuente con una inscripción activa
        $verificarInscripcion = Grupo_Inscripcion_Alumno::where("alumno_id",$request->alumnoId)->where("estatus",1)->first();
        if($verificarInscripcion){
            return back()->withErrors(["generales" => "El alumno se encuentra activo en otro grupo"])->withInput();
        }

        $inscripcionAlumno = Grupo_Inscripcion_Alumno::where("alumno_id",$request->alumnoId)->where("grupo_id",$request->grupoId)->first();

        // -- Verificar que no exita un cliente con el mismo correo o teléfono.
        if ($inscripcionAlumno) {
            return back()->withErrors(["generales" => "El alumno ya se encuentra registrado en el grupo"])->withInput();
        } else {

            try {

                DB::beginTransaction();

                $inscripcionAlumno = new Grupo_Inscripcion_Alumno();
                $inscripcionAlumno->alumno_id = $request->alumnoId;
                $inscripcionAlumno->grupo_id = $request->grupoId;
                $inscripcionAlumno->estatus = $request->estatus;

                $tiempo = new DateTime();
                $inscripcionAlumno->created_at = $tiempo;

                $inscripcionAlumno->save();

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
