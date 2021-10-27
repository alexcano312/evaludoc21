<?php

namespace App\Http\Controllers;

use App\Alumno;
use App\Alumno_Actividad;
use App\Directivo;
use Illuminate\Http\Request;
use DateTime;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class alumnoActividadController extends Controller
{
    // Agregar Directivo
    public function agregar (Request $request){

        Validator::make($request->all(), [
            "alumnoId" => "required",
            "actividadId" => "required",
            "estatus" => "required",
        ], [
            "alumnoId.required" => "Debe seleccionar un alumno.",
            "actividadId.required" => "Debe seleccionar una actividad.",
            "estatus.required" => "Debe seleccionar un estatus.",
        ])->validated();
        $verificaalumno = Alumno::find($request->alumnoId);
        if(!$verificaalumno){
            return back()->withErrors(["generales" => "No fue posible encontrar el alumno"])->withInput();
        }
        $nombre = $verificaalumno->nombre." ".$verificaalumno->apellidos;
        if($request->buscarNombre != $nombre){
            return back()->withErrors(["generales" => "No fue posible buscar el alumno"])->withInput();
        }

        $alumno = Alumno_Actividad::where("alumno_id",$request->alumnoId)->first();

        // -- Verificar que no exita un alumno con actividad
        if ($alumno) {
            return back()->withErrors(["generales" => "El alumno ya cuenta con una actividad registrada"])->withInput();
        } else {

            try {

                DB::beginTransaction();

                $alumno = new Alumno_Actividad();
                $alumno->alumno_id = $request->alumnoId;
                $alumno->actividad_id = $request->actividadId;
                $alumno->estatus = $request->estatus;

                $alumno->save();

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
