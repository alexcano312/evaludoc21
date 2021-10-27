<?php

namespace App\Http\Controllers;
use App\Materia;
use App\MateriaInscripcionCarrera;
use Illuminate\Http\Request;
use DateTime;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
class materiaController extends Controller
{
    // -- Agregar Actividad
    public function agregar (Request $request){

        Validator::make($request->all(), [
            "nombre" => "required",
        ], [
            "nombre.required" => "Debe ingresar un nombre.",
        ])->validated();

        $materia = Materia::where("nombre",$request->nombreMateria)->first();

        // -- Verificar que no exita un cliente con el mismo correo o teléfono.
        if ($materia) {
            return back()->withErrors(["generales" => "Ya existe una area con ese nombre"])->withInput();
        } else {

            try {

                DB::beginTransaction();

                $materia = new Materia();
                $materia->nombre = mb_strtoupper($request->nombreMateria);



                $materia->save();

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

    // -- Agregar Inscripción Materia
    public function agregarInscripcionMateria (Request $request){

        $materia = MateriaInscripcionCarrera::where("catalogo_materia_id",$request->materiaId)->where("carrera_id",$request->carreraId)->where("cuatrimestre_id",$request->cuatrimestreId)->where('plan_estudio_id',$request->planId)->first();

        // -- Verificar que no exita un cliente con el mismo correo o teléfono.
        if ($materia) {
            return back()->withErrors(["generales" => "La materia ya se encuentra registrada en esa carrera y cuatrimestre"])->withInput();
        } else {

            try {

                DB::beginTransaction();

                $materia = new MateriaInscripcionCarrera();
                $materia->cuatrimestre_id = $request->cuatrimestreId;
                $materia->carrera_id = $request->carreraId;
                $materia->catalogo_materia_id = $request->materiaId;
                $materia->plan_estudio_id = $request->planId;
                $tiempo = new DateTime();
                $materia->created_at = $tiempo;

                $materia->save();

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

    // -- Editar inscripción
    public function editarInscripcionMateria (Request $request){

        $inscripcion = MateriaInscripcionCarrera::find($request->inscripcion_id);

        // -- Verificar que no exita un cliente con el mismo correo o teléfono.
        if (!$inscripcion) {
            return back()->withErrors(["generales" => "No se encontró la matería"])->withInput();
        } else {

            try {

                DB::beginTransaction();

                $inscripcion->cuatrimestre_id = $request->cuatrimestreId;
                $inscripcion->carrera_id = $request->carreraId;
                $inscripcion->catalogo_materia_id = $request->materiaId;
                $inscripcion->plan_estudio_id = $request->planId;
                $inscripcion->save();

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
