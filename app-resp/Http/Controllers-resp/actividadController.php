<?php

namespace App\Http\Controllers;
use App\Actividad;
use App\Herramienta;
use Illuminate\Http\Request;
use DateTime;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class actividadController extends Controller
{
    // -- Agregar Actividad
    public function agregar (Request $request){

        Validator::make($request->all(), [
            "nombre" => "required",
        ], [
            "nombre.required" => "Debe ingresar un nombre.",
        ])->validated();
        $herramienta = new Herramienta();
        $slug = $herramienta->crearSlug($request->nombreActividad);

        $actividad = Actividad::where("slug",$slug)->first();

        // -- Verificar que no exita un cliente con el mismo correo o teléfono.
        if ($actividad) {
            return back()->withErrors(["generales" => "Ya existe una Actividad con ese nombre"])->withInput();
        } else {

            try {

                DB::beginTransaction();

                $actividad = new Actividad();
                $actividad->nombre = mb_strtoupper($request->nombreActividad);

                $actividad->slug = $slug;
                $actividad->estatus = $request->estatus;
                $actividad->save();

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
