<?php

namespace App\Http\Middleware;

use auth;
use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */

    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            if(auth()->user()->role === "ADMIN"){
                return $next($request);
            }else{
                return redirect()->route('inicio');
            }
        }
        else{
            return redirect()->route('login');
        }
    }
}
