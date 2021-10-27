<?php

namespace App\Http\Controllers;

use App\Evaluado;
use App\Grupo;
use App\Materia;
use App\MateriaInscripcionCarrera;
use Illuminate\Http\Request;
use App\Herramienta;
use App\Grupo_Inscripcion_Materia;
use DateTime;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class gruposInscripcionMateriasController extends Controller
{
    // -- Agregar Actividad
    public function agregar (Request $request){

        Validator::make($request->all(), [
            "evaluadoId" => "required",
            "materiaId" => "required",
            "grupoId" => "required",
        ], [
            "evaluadoId.required" => "Debe ingresar un evaluado.",
            "materiaId.required" => "Debe ingresar una materia.",
            "grupoId.required" => "Debe ingresar un grupo.",
        ])->validated();

        $grupoInscripcionMateria = Grupo_Inscripcion_Materia::where("evaluado_id",$request->evaluadoId)->where("materia_inscripcion_carrera_id",$request->materiaInscripcionCarreraId)->where("grupo_id",$request->grupoId)->first();

        if ($grupoInscripcionMateria) {
            return back()->withErrors(["generales" => "Ya existe una materia en ese grupo"])->withInput();
        } else {

            try {

                // -- Validar que el personal exista
                $evaluado = Evaluado::find($request->evaluadoId);
                if(!$evaluado){
                    return back()->withErrors(["generales" => "No fue posible encontrar el evaluado"])->withInput();
                }

                $nombre = $evaluado->persona->nombre." ".$evaluado->persona->apellidos;
                if($nombre != $request->buscarNombre){
                    return back()->withErrors(["generales" => "No fue posible validar el evaluado"])->withInput();
                }

                // -- Validar que el grupo exista
                if($request->buscarGrupo) {
                    $grupo = Grupo::where('id', $request->grupoId)->where('nombre', $request->buscarGrupo)->first();
                }else{
                    $grupo = Grupo::find($request->grupoId);
                }

                if(!$grupo){
                    return back()->withErrors(["generales" => "No fue posible encontrar el grupo"])->withInput();
                }


                // -- Validar que la materia exista
                $materiaInscripcion = MateriaInscripcionCarrera::find($request->materiaId);
                if($request->buscarMateria){
                    $materia = Materia::where('id',$materiaInscripcion->catalogo_materia_id)->where('nombre',$request->buscarMateria)->first();
                }else{
                    $materia = Materia::find($materiaInscripcion->catalogo_materia_id);
                }

                if(!$materia){
                    return back()->withErrors(["generales" => "No fue posible encontrar la materia"])->withInput();
                }


                DB::beginTransaction();

                $grupoInscripcionMateria = new Grupo_Inscripcion_Materia();
                $grupoInscripcionMateria->evaluado_id = $request->evaluadoId;
                $grupoInscripcionMateria->grupo_id = $request->grupoId;
                $grupoInscripcionMateria->materia_inscripcion_carrera_id = $request->materiaId;


                $grupoInscripcionMateria->save();

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
