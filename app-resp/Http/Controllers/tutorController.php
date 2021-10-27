<?php

namespace App\Http\Controllers;

use App\Personal;
use Illuminate\Http\Request;

use App\Tutor;
use DateTime;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class tutorController extends Controller
{
    // Agregar Entrenador
    public function agregar (Request $request){

        Validator::make($request->all(), [
            "personaId" => "required",
            "areaId" => "required",
            "estatus" => "required",
        ], [
            "personaId.required" => "Debe seleccionar una persona.",
            "areaId.required" => "Debe seleccionar un area.",
            "estatus.required" => "Debe seleccionar un estatus.",
        ])->validated();

        $tutor = Tutor::where("personal_id",$request->personaId)->where("area_id",$request->areaId)->first();

        // -- Verificar que no exita un cliente con el mismo correo o teléfono.
        if ($tutor) {
            return back()->withErrors(["generales" => "Ya existe un tutor registrado con esa persona y area"])->withInput();
        } else {

            $personal = Personal::find($request->personaId);
            if(!$personal){return back()->withErrors(["generales" => "No fue posible encontrar a la persona"])->withInput();}

            //$nombrePersonal = $personal->nombre." ".$personal->apellidos;
            //if($nombrePersonal != $request->buscarTutor){return back()->withErrors(["generales" => "No fue posible encontrar a la persona"])->withInput();}

            try {

                DB::beginTransaction();

                $tutor = new Tutor();
                $tutor->personal_id = $request->personaId;
                $tutor->area_id = $request->areaId;
                $tutor->estatus = $request->estatus;

                $tutor->save();

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
