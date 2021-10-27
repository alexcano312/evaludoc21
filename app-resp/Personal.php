<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Personal extends Model
{
    protected $table = "personal";
    public $timestamps = true;

    public function evaluado()
    {
        return $this->hasOne('App\Evaluado', 'personal_id', "id");
    }

    public function directivo()
    {
        return $this->hasOne('App\Directivo', 'persona_id', "id");
    }


    public function tutores()
    {
        return $this->hasMany("\App\Tutor","personal_id");
    }

    public function estatusTutor(){
        $tutor = Tutor::where('personal_id',$this->id)->where("estatus",1)->first();
        if($tutor){
            return $tutor;
        }else{
            return false;
        }
    }


}
