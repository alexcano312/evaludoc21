<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Alumno extends Model
{
    protected $table = "alumnos";
    public $timestamps = true;
    public function generacion()
    {
        return $this->belongsTo('App\Generacion')->withDefault();
    }

    public function carrera()
    {
        return $this->belongsTo('App\Carrera')->withDefault();
    }

    public function grupos (){
        return $this->hasMany('App\Grupo');
    }

    public function inscripcionActividad()
    {
        return $this->hasOne('App\Alumno_Actividad', 'alumno_id', "id");
    }

    public function grupoActual (){

        $grupoInscripcion = Grupo_Inscripcion_Alumno::where('alumno_id',$this->id)->where('estatus',1)->first();

        return $grupoInscripcion;
    }
}
