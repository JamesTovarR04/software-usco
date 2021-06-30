<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class HasAProgram
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ( !$request->user()->hasAProgram() ){
            return redirect('/auth/addprogram');
        }

        return $next($request);
    }
}
