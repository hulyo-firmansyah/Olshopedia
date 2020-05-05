<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CekTokoDomain
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
        $domain_toko = $request->domain_toko;
        $cekToko = DB::table('t_store')
            ->where('domain_toko', $domain_toko)
            ->get()->first();
        if(isset($cekToko)){
            return $next($request);
        } else {
            //landing page
            return redirect()->route('b.login');
        }
    }
}
