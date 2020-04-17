<?php

namespace App\Http\Middleware;

use Closure, App;
use Illuminate\Support\Facades\Auth;

class BelakangLocale
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
        if($request->session()->has('locale')){
            App::setLocale($request->session()->get('locale'));
        }
		return $next($request);
    }
}
