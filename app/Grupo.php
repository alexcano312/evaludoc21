<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Grupo extends Model
{
    protected $table = "grupos";
    public $timestamps = true;

    public function cuatrimestre()
    {
        return $this->belongsTo("\App\Cuatrimestre", "cuatrimestre_id", "id");
    }

    public function carrera()
    {
        return $this->belongsTo("\App\Carrera", "carrera_id", "id");
    }

    public function inscripcionesMaterias()
    {
        return $this->hasMany("\App\Grupo_Inscripcion_Materia","grupo_id");

    }

    public function inscripcionesAlumno()
    {
        return $this->hasMany("\App\Grupo_Inscripcion_Alumno","grupo_id");

    }

    public function evaluacion()
    {
        return $this->hasOne('App\Evaluacion', 'id', "evaluacion_id");
    }

    public function inscripcionTutor()
    {
        return $this->hasOne('App\Grupo_Inscripcion_Tutor', 'grupo_id', "id");
    }

    public function materias(){
        $materias = MateriaInscripcionCarrera::where('carrera_id',$this->carrera_id)->where('cuatrimestre_id',$this->cuatrimestre_id)->where('plan_estudio_id',$this->plan_estudio_id)->get();
        return$materias;
    }

    public function verificaInscripcionMateria($id){
        $verificaInscripcionMateriaGrupo = Grupo_Inscripcion_Materia::where('grupo_id',$this->id)->where('materia_inscripcion_carrera_id',$id)->first();
        return $verificaInscripcionMateriaGrupo;
    }

    public function alumnosEvaluacion(){

        $conEvaluacion = [];
        $sinEvaluacion = [];
        
        $alumnosConevaluacion = Grupo_Inscripcion_Alumno::where('grupo_id',$this->id)->get();
        $n = 0;
        foreach ($alumnosConevaluacion as $inscripcion) {
            if(!$inscripcion->alumno){
               // echo "No existe : ".$inscripcion->id; 
                $inscripcion->delete();                                
            }
            
            
            if($inscripcion->alumno->evaluacion == 1){
                if(!in_array($inscripcion->alumno->id,$conEvaluacion)){
                 array_push($conEvaluacion,$inscripcion->alumno->id);
               }
           }else{
               if(!in_array($inscripcion->alumno->id,$sinEvaluacion)){
                 array_push($sinEvaluacion,$inscripcion->alumno->id);
              }
        }
            

        }
        

        return ["conEvaluacion" => Alumno::whereIn("id",$conEvaluacion)->get(), "sinEvaluacion" => Alumno::whereIn("id",$sinEvaluacion)->get()];

    }

}
