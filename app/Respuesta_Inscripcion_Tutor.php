<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Respuesta_Inscripcion_Tutor extends Model
{
    protected $table = "respuestas_inscripciones_tutores";

    public function tutorInscripcionGrupo()
    {
        return $this->belongsTo("\App\Evaluado", "tutor_inscripcion_grupo_id", "id");
    }

    public function pregunta()
    {
        return $this->hasOne('App\Pregunta', 'id', "pregunta_id");
    }

    public function alumno()
    {
        return $this->belongsTo("\App\Alumno", "alumno_id	", "id");
    }
}
