<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Directivo extends Model
{
    protected $table = "directivos";
    public $timestamps = true;

    public function area()
    {
        return $this->belongsTo("\App\Area", "area_id", "id");
    }

    public function persona()
    {
        return $this->belongsTo("\App\Personal", "persona_id", "id");
    }

    public function carreras(){
        $idCarreras = [];
        $carreras = Carrera::where("area_id",$this->area_id)->select('id')->get();
        foreach ($carreras as $carrera) {
            array_push($idCarreras,$carrera->id);
        }
        return $idCarreras;
    }
}
