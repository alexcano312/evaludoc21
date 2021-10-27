<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Carrera extends Model
{
    protected $table = "carreras";
    public $timestamps = true;

    public function area()
    {
        return $this->belongsTo('App\Area')->withDefault();
    }
}
