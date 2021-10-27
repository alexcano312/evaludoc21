<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MateriaInscripcionCarrera extends Model
{
    protected $table = "materias_inscripciones_carreras";
    public $timestamps = true;

    public function cuatrimestre()
    {
        return $this->belongsTo("\App\Cuatrimestre", "cuatrimestre_id", "id");
    }

    public function area()
    {
        return $this->hasOne('App\Area', 'area_id', "id");
    }

    public function materia()
    {
        return $this->hasOne('App\Materia', 'id', "catalogo_materia_id");
    }

    public function carrera()
    {
        return $this->hasOne('App\Carrera', 'id', "carrera_id");
    }

    public function plan()
    {
        return $this->hasOne('App\Plan_Estudio', 'id', "plan_estudio_id");
    }
}
