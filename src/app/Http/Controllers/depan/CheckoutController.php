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
        $data_store = DB::table('t_store')
            ->where('data_of', Fungsi::dataOfByDomainToko($domain_toko))
            ->select('cek_ongkir', 'kat_customer', 'alamat_toko_offset')
            ->get()->first();
        $cekOngkir = [];
        foreach(Fungsi::genArray(json_decode($data_store->cek_ongkir)) as $iO => $vO){
            if($vO){
                $cekOngkir[] = $iO;
            }
        }
        $cekOngkir = json_encode($cekOngkir);
        $alamat_toko_offset = $data_store->alamat_toko_offset;
        $cart = Cart::session($request->getClientIp())->getContent();
        if(count($cart) < 1){
            return redirect()->route('d.home', ['domain_toko' => $toko->domain_toko]);
        }
        if(isset($toko)){
            return Fungsi::respon('depan.all.checkout', compact('toko', 'cekOngkir', 'cart', 'alamat_toko_offset'), "html", $request);
        } else {
            // ke landing page
        }
    }
}