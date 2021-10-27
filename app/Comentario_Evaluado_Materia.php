<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comentario_Evaluado_Materia extends Model
{
    protected $table = "comentarios_evaluados";

    public function grupoInscripcionMateria()
    {
        return $this->belongsTo("\App\Grupo_Inscripcion_Materia", "grupo_inscripcion_materia_id", "id");
    }

    public function grupo()
    {
        return $this->hasOne('App\Grupo', 'id', "grupo_id");
    }
}
