<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Grupo_Inscripcion_Tutor extends Model
{
    protected $table = "grupos_inscripciones_tutores";
    public $timestamps = true;
    public function tutor()
    {
        return $this->belongsTo("\App\Tutor", "tutor_id", "id");
    }

    public function grupo()
    {
        return $this->belongsTo("\App\Grupo", "grupo_id", "id");
    }
}
