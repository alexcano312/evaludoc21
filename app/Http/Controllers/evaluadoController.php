<?php

namespace App\Http\Controllers;

use App\Evaluado;
use Illuminate\Http\Request;
use DateTime;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class evaluadoController extends Controller
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
            "carreraId.required" => "Debe seleccionar una carrera.",
            "tipo.required" => "Debe seleccionar un tipo.",
            "estatus.required" => "Debe seleccionar un estatus.",
        ])->validated();

        $evaluado = Evaluado::where("personal_id",$request->personaId)->where("area_id",$request->areaId)->first();

        // -- Verificar que no exita un cliente con el mismo correo o teléfono.
        if ($evaluado) {
            return back()->withErrors(["generales" => "Ya existe un evaluado registrado con esa persona y carrera"])->withInput();
        } else {

            try {

                DB::beginTransaction();

                $evaluado = new Evaluado();
                $evaluado->personal_id = $request->personaId;
                $evaluado->area_id = $request->areaId;
                $evaluado->estatus = $request->estatus;
                $evaluado->evaluado_tipo_id = $request->tipoId;
                $evaluado->observaciones = $request->observacion;

                $tiempo = new DateTime();
                $evaluado->created_at = $tiempo;

                $evaluado->save();

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
