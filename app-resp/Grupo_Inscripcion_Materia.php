<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Grupo_Inscripcion_Materia extends Model
{
    protected $table = "grupos_inscripciones_materias";
    public $timestamps = true;

    public function evaluado()
    {
        return $this->belongsTo("\App\Evaluado", "evaluado_id", "id");
    }

    public function materia()
    {
        return $this->belongsTo("\App\MateriaInscripcionCarrera", "materia_inscripcion_carrera_id", "id");
    }

    public function grupo()
    {
        return $this->belongsTo("\App\Grupo", "grupo_id", "id");
    }
}
