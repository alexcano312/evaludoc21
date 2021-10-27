<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Actividad extends Model
{
    protected $table = "actividades";
    public $timestamps = true;

    public function entrenador()
    {
        return $this->hasOne('App\Entrenador', 'id', "entrenador_id");
    }
}
