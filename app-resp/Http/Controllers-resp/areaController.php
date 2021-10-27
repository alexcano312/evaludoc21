<?php

namespace App\Http\Controllers;
use App\Area;
use Illuminate\Http\Request;
use DateTime;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
class areaController extends Controller
{
    // -- Agregar Area
    public function agregar (Request $request){

        Validator::make($request->all(), [
            "nombre" => "required",
        ], [
            "nombre.required" => "Debe ingresar un nombre.",
        ])->validated();

        $area = Area::where("nombre",$request->nombreArea)->first();

        // -- Verificar que no exita un cliente con el mismo correo o teléfono.
        if ($area) {
            return back()->withErrors(["generales" => "Ya existe una area con ese nombre"])->withInput();
        } else {

            try {

                DB::beginTransaction();

                $area = new Area();
                $area->nombre = mb_strtoupper($request->nombreArea);

                $area->save();

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
