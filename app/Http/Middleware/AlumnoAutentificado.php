<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;

class AlumnoAutentificado
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!Session::has("alumno"))
            return redirect()->route("alumno.login",["r"=> encrypt($request->getRequestUri())]);

        return $next($request);
    }
}
