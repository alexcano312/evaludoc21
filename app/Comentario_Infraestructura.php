<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comentario_Infraestructura extends Model
{
    protected $table = "comentarios_infraestructura";

    public function grupo()
    {
        return $this->hasOne('App\Grupo', 'id', "grupo_id");
    }
}
