<?php

namespace App\Http\Controllers;

use App\Entrenador;
use Illuminate\Http\Request;
use DateTime;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class entrenadorController extends Controller
{
    // Agregar Entrenador
    public function agregar (Request $request){

    Validator::make($request->all(), [
        "personaId" => "required",
        "carreraId" => "required",
        "tipo" => "required",
        "estatus" => "required",
    ], [
        "personaId.required" => "Debe seleccionar una persona.",
        "actividadId.required" => "Debe seleccionar una actividad.",
        "estatus.required" => "Debe seleccionar un estatus.",
    ])->validated();

    $entrenador = Entrenador::where("personal_id",$request->personaId)->where("actividad_id",$request->actividadId)->first();

    // -- Verificar que no exita un cliente con el mismo correo o teléfono.
    if ($entrenador) {
        return back()->withErrors(["generales" => "Ya existe un entrenador registrado con esa persona y actividad"])->withInput();
    } else {

        try {

            DB::beginTransaction();

            $entrenador = new Entrenador();
            $entrenador->personal_id = $request->personaId;
            $entrenador->actividad_id = $request->actividadId;
            $entrenador->estatus = $request->estatus;
            $entrenador->observacion = $request->observacion;

            $tiempo = new DateTime();
            $entrenador->created_at = $tiempo;

            $entrenador->save();

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
