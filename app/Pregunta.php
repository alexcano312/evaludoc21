<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pregunta extends Model
{
    protected $table = "preguntas";
    public $timestamps = true;

    public function tema()
    {
        return $this->belongsTo("\App\Tema", "tema_id", "id");
    }
}
