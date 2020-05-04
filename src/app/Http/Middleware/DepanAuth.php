<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DepanAuth
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
            $userData = DB::table('t_customer')
                ->where('user_id', Auth::user()->id)
                ->select('kategori')
                ->get()->first();
            if(isset($userData)){
                return $next($request);
            }
        }

        return redirect()->route("d.login");
    }
}
