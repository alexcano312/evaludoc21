<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Evaluado extends Model
{
    protected $table = "evaluados";
    public $timestamps = true;

    public function area()
    {
        return $this->belongsTo("\App\Area", "area_id", "id");
    }

    public function persona()
    {
        return $this->belongsTo("\App\Personal", "personal_id", "id");
    }

    public function tipo()
    {
        return $this->belongsTo("\App\Evaluado_Tipo", "evaluado_tipo_id", "id");
    }
}
