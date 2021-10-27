<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Alumno_Codigo extends Model
{
    protected $table = "alumnos_codigos_evaluaciones";
    public $timestamps = true;


    public function evaluacion()
    {
        return $this->belongsTo('App\Evaluacion')->withDefault();
    }

    public function alumno()
    {
        return $this->belongsTo('App\Alumno')->withDefault();
    }

}
