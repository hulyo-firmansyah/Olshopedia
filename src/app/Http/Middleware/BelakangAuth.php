<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class BelakangAuth
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
        if (Auth::check() && !is_null(Auth::user()->email_verified_at)) {
            return $next($request);
        } else if($request->ajax()){
            return redirect()->route("b.login")->with(['dari_ajax_butuh_login' => true]);
        }

        return redirect()->route("b.login");
    }
}
