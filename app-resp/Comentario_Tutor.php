<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comentario_Tutor extends Model
{
    protected $table = "comentarios_tutores";

    public function grupoInscripcionMateria()
    {
        return $this->belongsTo("\App\Grupo_Inscripcion_Tutor", "grupo_inscripcion_tutor_id", "id");
    }

    public function grupo()
    {
        return $this->hasOne('App\Grupo', 'id', "grupo_id");
    }
}
