<?php

namespace App\Http\Controllers\depan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\PusatController as Fungsi;
use Cart;

class CheckoutController extends Controller
{
	public function __construct(){
		$this->middleware('cek_toko_domain');
    }
    
    public function guest_checkout(Request $request, $domain_toko){
        $cart = Cart::session($request->getClientIp())->getContent();
		$toko = DB::table('t_store')
            ->where('domain_toko', $domain_toko)
            ->get()->first();
        if(isset($toko)){
            return Fungsi::respon('depan.all.checkout', compact('toko'), "html", $request);
        } else {
            // ke landing page
        }
    }
}