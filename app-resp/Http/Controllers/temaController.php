<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Herramienta;
use App\Tema;
use DateTime;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class temaController extends Controller
{
    // -- Agregar Actividad
    public function agregar (Request $request){

        Validator::make($request->all(), [
            "nombre" => "required",
        ], [
            "nombre.required" => "Debe ingresar un nombre.",
        ])->validated();

        $herramienta = new Herramienta();
        $slug = $herramienta->crearSlug($request->nombreTema);

        $tema = Tema::where("slug",$slug)->first();

        if ($tema) {
            return back()->withErrors(["generales" => "Ya existe una tema con ese nombre"])->withInput();
        } else {

            try {

                DB::beginTransaction();

                $tema = new Tema();
                $tema->nombre = mb_strtoupper($request->nombreTema);
                $tema->tema_id = $request->temaId;

                $tema->slug = $slug;

                $tema->save();

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
