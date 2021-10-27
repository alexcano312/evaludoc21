<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Herramienta;
use App\Evaluado_Tipo;
use DateTime;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class tipoevaluadoController extends Controller
{
    // -- Agregar Actividad
    public function agregar (Request $request){

        Validator::make($request->all(), [
            "nombre" => "required",
        ], [
            "nombre.required" => "Debe ingresar un nombre.",
        ])->validated();

        $tipo = Evaluado_Tipo::where("nombre",$request->nombre)->first();

        if ($tipo) {
            return back()->withErrors(["generales" => "Ya existe una tipo con ese nombre"])->withInput();
        } else {

            try {

                DB::beginTransaction();

                $tipo = new Evaluado_Tipo();
                $tipo->nombre = $request->nombreTipo;
                $tipo->save();

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
