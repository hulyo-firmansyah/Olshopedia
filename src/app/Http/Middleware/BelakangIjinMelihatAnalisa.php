<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class BelakangIjinMelihatAnalisa
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
        $id_user = Auth::user()->id;
        $data_user = \DB::table('t_user_meta')
            ->where('user_id', $id_user)
            ->select('role', 'ijin')
            ->get()->first();
        if(isset($data_user)){
            $ijin = json_decode($data_user->ijin);
            if(($data_user->role == 'Admin' && $ijin->melihatAnalisa === 1) || $data_user->role == 'Owner'){
                return $next($request);
            } else {
                return redirect()->back();
            }
        } else {
            return redirect()->route("b.dashboard");
        }

    }
}
