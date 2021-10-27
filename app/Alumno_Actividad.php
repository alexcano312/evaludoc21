<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Alumno_Actividad extends Model
{
    protected $table = "alumnos_inscripciones_actividades";
    public $timestamps = true;


    public function actividad()
    {
        return $this->belongsTo('App\Actividad')->withDefault();
    }

    public function alumno()
    {
        return $this->belongsTo('App\Alumno')->withDefault();
    }

}
