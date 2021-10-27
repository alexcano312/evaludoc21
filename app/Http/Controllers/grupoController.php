<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Herramienta;
use App\Grupo;
use DateTime;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class grupoController extends Controller
{
    // -- Agregar Actividad
    public function agregar (Request $request){

        Validator::make($request->all(), [
            "nombre" => "required",
            "cuatrimestreId" => "required",
            "anio" => "required",
        ], [
            "nombre.required" => "Debe ingresar un nombre.",
            "cuatrimestre.required" => "Debe ingresar un cuatrimestre.",
            "anio.required" => "Debe ingresar un anio.",
        ])->validated();

        $herramienta = new Herramienta();
        $slug = $herramienta->crearSlug($request->nombreGrupo);

        $grupo = Grupo::where("slug",$slug)->first();

        if ($grupo) {
            return back()->withErrors(["generales" => "Ya existe un grupo con ese nombre"])->withInput();
        } else {

            try {

                DB::beginTransaction();

                $grupo = new Grupo();
                $grupo->nombre = mb_strtoupper($request->nombreGrupo);
                $grupo->cuatrimestre_id = $request->cuatrimestreId;
                $grupo->evaluacion_id = $request->evaluacion;
                $grupo->carrera_id = $request->carrera;
                $grupo->plan_estudio_id = $request->plan;
                $grupo->anio = $request->anio;
                $grupo->slug = $slug;
                $grupo->estatus = 1;
                $grupo->save();

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
