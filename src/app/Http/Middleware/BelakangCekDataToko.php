<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\PusatController as Fungsi;

class BelakangCekDataToko
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
		$store = DB::table('t_store')
			->where('data_of', Fungsi::dataOfCek())
			->select('domain_toko')
			->get()->first();
        if(is_null($store->domain_toko)){
            return redirect()->route("b.dashboard");
        } else {
            return $next($request);
        }

    }
}
