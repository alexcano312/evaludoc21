<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tutor extends Model
{
    protected $table = "tutores";
    public $timestamps = true;

    public function personal()
    {
        return $this->belongsTo("\App\Personal", "personal_id", "id");
    }

    public function area()
    {
        return $this->belongsTo("\App\Area", "area_id", "id");
    }
}
