<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Respuesta_Evaluado extends Model
{
    protected $table = "respuestas_evaluados";


    public function pregunta()
    {
        return $this->hasOne('App\Pregunta', 'id', "pregunta_id");
    }

    public function grupo()
    {
        return $this->belongsTo("\App\Grupo", "grupo_id	", "id");
    }
}
