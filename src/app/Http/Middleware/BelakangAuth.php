<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
            $userData = DB::table('t_user_meta')
                ->where('user_id', Auth::user()->id)
                ->select('role')
                ->get()->first();
            if(isset($userData) && ( $userData->role === 'Owner' || $userData->role === 'Admin')){
                return $next($request);
            }
        } else if($request->ajax()){
            return redirect()->route("b.login")->with(['dari_ajax_butuh_login' => true]);
        }

        return redirect()->route("b.login");
    }
}
