<?php

namespace App\Http\Controllers\depan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\PusatController as Fungsi;
use Illuminate\Support\Facades\Mail;
use App\Mail\GuestOrder;
use App\Cart;

class OrderController extends Controller
{

	public function __construct(){
		$this->middleware('cek_toko_domain');
    }

    public function orderIndex(Request $request, $domain_toko, $order_slug = null){
		if(is_null($order_slug)) abort(404);

		$cekOrder = DB::table('t_order')
			->where('data_of', Fungsi::dataOfByDomainToko($domain_toko))
			->where('order_slug', $order_slug)
			->get()->first();
		
		if(!isset($cekOrder)) abort(404);

      	$toko = DB::table('t_store')
			->where('domain_toko', $domain_toko)
			->get()->first();
		$r['sort'] = strip_tags($request->sort);
		$r['cari'] = strip_tags($request->q);
		if(isset($toko)){
			return Fungsi::respon('depan.'.$toko->template.'.order', compact("toko", 'r'), "html", $request);
		} else {
			// ke landing page
		}
        
    }
}