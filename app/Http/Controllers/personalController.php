<?php

namespace App\Http\Controllers;

use App\Personal;
use Illuminate\Http\Request;
use DateTime;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class personalController extends Controller
{
    // Agregar persona
    public function agregarPersona (Request $request){

        Validator::make($request->all(), [
            "nombrePersona" => "required",
            "apellidosPersona" => "required",
            "passwordPersona" => "required",
        ], [
            "nombrePersona.required" => "Debe ingresar un nombre.",
            "apellidosPersona.required" => "Debe ingresar los apellidos.",
            "passwordPersona.required" => "Debe ingresar la contraseña.",
        ])->validated();

        if($request->matriculaPersona != null){
            $persona = Personal::where("matricula",$request->matriculaPersona)->first();
        }

        if($request->correoPersonal != null){
            $persona = Personal::where("correo",$request->correoPersona)->first();
        }

        // -- Verificar que no exita un cliente con el mismo correo o teléfono.
        if (isset($persona)) {
            return back()->withErrors(["generales" => "Ya existe una correo con ese correo o matricula"])->withInput();
        } else {

            try {

                DB::beginTransaction();

                $persona = new Personal();
                $persona->nombre = mb_strtoupper($request->nombrePersona);
                $persona->apellidos = mb_strtoupper($request->apellidosPersona);
                $persona->sexo = $request->sexo;
                $persona->matricula = $request->matriculaPersona;
                $persona->correo = $request->correoPersona;
                $persona->password = Hash::make($request->password);
                $persona->confirmacion = 0;

                $persona->save();

                DB::commit();
                // -- Retornar correcto
                return back()->with("success", "Correcto");


            } catch (\Exception $e) {
                //DB::rollBack();
//                return back()->withErrors(["generales" => "Ocurrió un error al guardar su información, inténtelo de nuevo más tarde."])->withInput();
                //return back()->withErrors(["generales" => $e->getMessage()])->withInput();
                echo json_encode($e->getMessage());
            }
        }


    }

    public function home(){
        return redirect()->route("personal.inicio");
    }

    // -- Login
    public function login(){
        return view("personal.login");
    }

    // -- Login
    public function verificarCredenciales (Request $request){

        $validator = Validator::make($request->all(), [
            "matricula" => "required",
            "password" => "required",
        ], [
            "matricula.required" => "Debe ingresar la matricula.",
            "password.required" => "Debe ingresar un password.",
        ]);

        if ($validator->fails())
            return back()->withErrors($validator->errors())->withInput();

        $personal = Personal::where("matricula",$request->matricula)->first();

        if(!$personal)
            return back()->withErrors(["generales" => "No fue posible encontrar el usuario."])->withInput();

        if(!$personal->directivo)
            return back()->withErrors(["generales" => "El usuario no cuenta con provilegios."])->withInput();

        if (!$personal->directivo->estatus != 1)
            return back()->withErrors(["generales" => "El usuario no se encuentra activo."])->withInput();

        if (!Hash::check($request->password, $personal->password))
            return back()->withErrors(["generales" => "Usuario o contraseña incorrectos."])->withInput();

        Session::put("personal", $personal);

        if($request->url){
            $url = decrypt($request->url);
            return redirect($url);
        }else{
            return redirect()->route("personal.inicio");
        }

    }

    // -- Cerrar sesion
    public function cerrarSesion()
    {
        if (Session::has("personal"))
            Session::forget("personal");

        return redirect()->route("personal.login");
    }


}
