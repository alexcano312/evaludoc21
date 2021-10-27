<?php

namespace App\Http\Controllers;
use App\Cuatrimestre;

use Illuminate\Http\Request;
use DateTime;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class cuatrimestreController extends Controller
{
    // -- Agregar Cuatrimestre
    public function agregar (Request $request){

        Validator::make($request->all(), [
            "cuatrimestreNombre" => "required",
            "claveCuatrimestre" => "required",
        ], [
            "cuatrimestreNombre.required" => "Debe ingresar un nombre.",
            "claveCuatrimestre.required" => "Debe ingresar una clave numérica.",
        ])->validated();

        $cuatrimestre = Cuatrimestre::where("nombre",$request->cuatrimestreNombre)->orWhere("clave",$request->claveCuatrimestre)->first();

        // -- Verificar que no exita un cliente con el mismo correo o teléfono.
        if ($cuatrimestre) {
            return back()->withErrors(["generales" => "Ya existe una cuatrimestre con ese nombre o clave"])->withInput();
        } else {

            try {

                DB::beginTransaction();

                $cuatrimestre = new Cuatrimestre();
                $cuatrimestre->nombre = mb_strtoupper($request->cuatrimestreNombre);
                $cuatrimestre->clave = $request->claveCuatrimestre;
                $tiempo = new DateTime();

                //echo $tiempo->date;
                $cuatrimestre->created_at = $tiempo;
                $cuatrimestre->save();

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
