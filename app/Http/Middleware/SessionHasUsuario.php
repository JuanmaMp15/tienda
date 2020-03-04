<?php

namespace App\Http\Middleware;

use Closure;

class SessionHasUsuario
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
        if(session()->has("usuario")) {
            return $next($request);
        }
        return abort(404);;
    }
}
