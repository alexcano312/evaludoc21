<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comentario_Actividad extends Model
{
    protected $table = "comentarios_actividades";

    public function actividadInscripcionAlumno()
    {
        return $this->belongsTo("\App\Alumno_Actividad", "actividad_inscripcion_alumno_id", "id");
    }

    public function grupo()
    {
        return $this->hasOne('App\Grupo', 'id', "grupo_id");
    }
}
