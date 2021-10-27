<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Infraestructura_Inscripcion_Alumno extends Model
{
    protected $table = "inscripciones_infraestructura";
    public $timestamps = true;

    public function alumnoInscripcionInfraestructura()
    {
        return $this->belongsTo("\App\Grupo_Inscripcion_Alumno", "inscripcion_alumno_id", "id");
    }
}
