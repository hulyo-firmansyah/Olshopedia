<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BelakangIfRedirectAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::check() && !is_null(Auth::user()->email_verified_at)) {
            $userData = DB::table('t_user_meta')
                ->where('user_id', Auth::user()->id)
                ->select('role')
                ->get()->first();
            if(isset($userData) && ( $userData->role === 'Owner' || $userData->role === 'Admin')){
                return redirect()->route('b.dashboard');
            }
        }

        return $next($request);
    }
}
