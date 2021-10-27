<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Respuesta_Inscripcion_Actividad extends Model
{
    protected $table = "respuestas_inscripciones_actividades";
    public $timestamps = true;

    public function alumnoInscripcionActividad()
    {
        return $this->belongsTo("\App\Evaluado", "tutor_inscripcion_grupo_id", "id");
    }

    public function pregunta()
    {
        return $this->hasOne('App\Pregunta', 'id', "pregunta_id");
    }

    public function entrenador()
    {
        return $this->hasOne('App\Entrenador', 'id', "entrenador_id");
    }

    public function grupo()
    {
        return $this->belongsTo("\App\Grupo", "grupo_id", "id");
    }
}
