<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Grupo_Inscripcion_Alumno extends Model
{
    protected $table = "grupos_inscripciones_alumnos";
    public $timestamps = true;

    public function grupo()
    {
        return $this->belongsTo("\App\Grupo", "grupo_id", "id");
    }

    public function alumno()
    {
        return $this->belongsTo("\App\Alumno", "alumno_id", "id");
    }
}
