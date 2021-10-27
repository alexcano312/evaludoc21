<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Respuesta_Inscripcion_Materia extends Model
{
    protected $table = "respuestas_inscripciones_materias";
    public $timestamps = true;
    public function grupoInscripcionMateria()
    {
        return $this->belongsTo("\App\Evaluado", "grupo_inscripcion_materia_id	", "id");
    }

    public function pregunta()
    {
        return $this->hasOne('App\Pregunta', 'id', "pregunta_id");
    }

    public function grupo()
    {
        return $this->hasOne('App\Grupo', 'id', "grupo_id");
    }

    public function alumno()
    {
        return $this->belongsTo("\App\Alumno", "alumno_id	", "id");
    }
}
