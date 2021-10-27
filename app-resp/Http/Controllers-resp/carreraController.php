<?php

namespace App\Http\Controllers;

use App\Area;
use App\Carrera;
use App\Herramienta;
use Illuminate\Http\Request;
use DateTime;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class carreraController extends Controller
{
    // -- Agregar Carrera
    public function agregar (Request $request){

        Validator::make($request->all(), [
            "nombre" => "required",
            "areaId" => "required",
        ], [
            "nombre.required" => "Debe ingresar un nombre.",
            "areaId.required" => "Debe seleccionar una carrera.",
        ])->validated();

        // -- Verificar que exista un area
        $area = Area::where("nombre",$request->nombreArea)->first();

        // -- Verificar que no exita un cliente con el mismo correo o teléfono.
        if ($area) {
            return back()->withErrors(["generales" => "Ya existe una carrera con ese nombre"])->withInput();
        } else {

            try {

                $area = Area::find($request->areaId);

                // -- Verificar que exista el area
                if(!$area){
                    return back()->withErrors(["generales" => "No fue posible encontrar el area"])->withInput();
                }

                DB::beginTransaction();

                $carrera = new Carrera();
                $carrera->nombre = mb_strtoupper($request->nombreCarrera);
                $carrera->area_id = $request->areaId;
                $herramienta = new Herramienta();
                $carrera->slug = $herramienta->crearSlug($request->nombreCarrera);

                $tiempo = new DateTime();
                $carrera->created_at = $tiempo;

                $carrera->save();
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
