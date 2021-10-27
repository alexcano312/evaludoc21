<?php

namespace App\Http\Controllers;

use App\Plan_Estudio;
use Illuminate\Http\Request;
use DateTime;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class planesestudioController extends Controller
{

    // -- Agregar Planes
    public function agregar (Request $request){

        Validator::make($request->all(), [
            "nombre" => "required",
            "estatus" => "required",
        ], [
            "nombre.required" => "Debe ingresar un nombre.",
            "estatus.required" => "Debe ingresar un estatus.",
        ])->validated();

        $plan = Plan_Estudio::where("nombre",$request->nombrePlan)->first();

        // -- Verificar que no exita un cliente con el mismo correo o teléfono.
        if ($plan) {
            return back()->withErrors(["generales" => "Ya existe un plan de estudios con ese nombre"])->withInput();
        } else {

            try {

                DB::beginTransaction();

                $plan = new Plan_Estudio();
                $plan->nombre = mb_strtoupper($request->nombrePlan);
                $plan->estatus = $request->estatus;

                $plan->save();

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
