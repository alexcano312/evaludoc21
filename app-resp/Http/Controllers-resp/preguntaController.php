<?php

namespace App\Http\Controllers;

use App\Pregunta;
use Illuminate\Http\Request;
use DateTime;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class preguntaController extends Controller
{
    // -- Agregar Pregunta
    public function agregar (Request $request){

        Validator::make($request->all(), [
            "texto" => "required",
        ], [
            "texto.required" => "Debe ingresar la pregunta.",
        ])->validated();

            try {


                $pregunta = new Pregunta();
                $pregunta->texto = mb_strtoupper($request->texto);
                $pregunta->tema_id = $request->temaId;
                $pregunta->tipo = $request->tipo;

                $pregunta->save();

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
