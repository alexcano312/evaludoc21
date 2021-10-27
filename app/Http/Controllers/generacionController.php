<?php

namespace App\Http\Controllers;

use App\Generacion;
use Illuminate\Http\Request;
use DateTime;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class generacionController extends Controller
{
    public function agregar (Request $request){

        Validator::make($request->all(), [
            "nombre" => "required",
            "fechaInicio" => "required",
            "fechaTermino" => "required",
        ], [
            "nombre.required" => "Debe ingresar un nombre.",
            "fechaInicio.required" => "Debe ingresar una fecha de inicio.",
            "fechaTermino.required" => "Debe ingresar una fecha de termino.",
        ])->validated();

        $generacion = Generacion::where("nombre",$request->nombreGeneracion)->first();

        // -- Verificar que no exita un cliente con el mismo correo o teléfono.
        if ($generacion) {
            return back()->withErrors(["generales" => "Ya existe una generación con ese nombre"])->withInput();
        } else {

            try {

                DB::beginTransaction();

                $generacion = new Generacion();
                $generacion->nombre = mb_strtoupper($request->nombreGeneracion);
                $generacion->fecha_inicio = $request->fechaInicio;
                $generacion->fecha_termino = $request->fechaTermino;
                $tiempo = new DateTime();
                $generacion->created_at = $tiempo;
                $generacion->estatus = 1;
                $generacion->save();

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
