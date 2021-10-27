<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Entrenador extends Model
{
    protected $table = "entrenadores";

    public function actividad()
    {
        return $this->belongsTo("\App\Actividad", "actividad_id", "id");
    }

    public function persona()
    {
        return $this->belongsTo("\App\Personal", "personal_id", "id");
    }
}
