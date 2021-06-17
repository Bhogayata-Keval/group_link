<?php

namespace App\Http\Middleware;

use Closure;

class JsonMiddleware
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
        if(!$request->hasFile('icon') && !$request->hasFile('image') && !$request->hasFile('images') && !$request->hasFile('file') && !$request->hasFile('icons')){
            $request->headers->set("Accept", "application/json");
        }
        return $next($request);
    }
}
