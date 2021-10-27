<?php

namespace App\Http\Controllers;

use App\Alumno;
use App\Evaluado;
use App\MateriaInscripcionCarrera;
use App\Personal;
use App\Grupo_Inscripcion_Materia;
use App\Grupo;
use Illuminate\Http\Request;

class buscarController extends Controller
{
    // -- Buscar Alumnos
    public function buscarAlumnos(Request $request)
    {
        $buscar = $request->get('q');

        $resultado = Alumno::where('nombre', 'LIKE', '%'. $buscar. '%')->orWhere('matricula', 'LIKE', '%'. $buscar. '%')->where('estatus',1)->get();

        $contenido = [];

        foreach ($resultado as $item) {
            $item->nombreCompleto = $item->nombre." ".$item->apellidos;
            array_push($contenido,$item);
        }
        return json_encode($contenido);
    }


    public function buscar(Request $request)
    {
        $buscar = $request->get('q');

        $resultado = Personal::where('nombre', 'LIKE', '%'. $buscar. '%')->orWhere('apellidos', 'LIKE', '%'. $buscar. '%')->get();

        $contenido = [];

        foreach ($resultado as $item) {
            $item->nombreCompleto = $item->nombre." ".$item->apellidos;
            array_push($contenido,$item);
        }
        return json_encode($contenido);
    }

    public function buscarEvaluados(Request $request)
    {
        $buscar = $request->get('q');
        $personal = Personal::where('nombre', 'LIKE', '%'. $buscar. '%')->orWhere('apellidos', 'LIKE', '%'. $buscar. '%')->get();
        $contenido = [];

        foreach ($personal as $item) {
            $item->nombreCompleto = $item->nombre." ".$item->apellidos;
            $item->evaluado = $item->evaluado;
            array_push($contenido,$item);
        }

        return json_encode($contenido);
    }

    public function buscarGrupos(Request $request)
    {
        $buscar = $request->get('q');

        $resultado = Grupo::where('nombre', 'LIKE', '%'. $buscar. '%')->get();

        return json_encode($resultado);
    }


    public function buscarInscripcionesMaterias(Request $request)
    {
        $grupo = Grupo::find($request->g);
        $inscripciones = MateriaInscripcionCarrera::where('cuatrimestre_id',$grupo->cuatrimestre_id)->where('carrera_id',$grupo->carrera_id)->get();
        $materias = [];
        foreach ($inscripciones as $inscripcion) {
            $inscripcion->nombreMateria = $inscripcion->materia->nombre;
            array_push($materias,$inscripcion);
        }

        echo json_encode($materias);
    }

    // -- Buscar tutor
    public function buscarTutores(Request $request)
    {
        $buscar = $request->get('q');
        $personal = Personal::where('nombre', 'LIKE', '%'. $buscar. '%')->orWhere("apellidos", 'LIKE','%'. $buscar. '%')->get();
        $contenido = [];

        foreach ($personal as $item) {
            $item->nombreCompleto = $item->nombre." ".$item->apellidos;
            if($item->estatusTutor()){
                $item->tutorId = $item->estatusTutor()->id;
                array_push($contenido,$item);
            }
        }

        return json_encode($contenido);
    }

    public function buscarPruebaRutas (){



    }
}
