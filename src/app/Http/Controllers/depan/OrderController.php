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

		$order_data = DB::table('t_order')
			->where('data_of', Fungsi::dataOfByDomainToko($domain_toko))
			->where('src', 'storefront')
			->where('order_slug', $order_slug)
			->get()->first();
		
		if(!isset($order_data)) abort(404);

		$tujuan_kirim = DB::table('users')
			->join('t_customer', 't_customer.user_id', '=', 'users.id')
			->where('t_customer.data_of', Fungsi::dataOfByDomainToko($domain_toko))
			->where('users.id', $order_data->tujuan_kirim_id)
			->get()->first();

		// dd($tujuan_kirim);

		$bank = DB::table('t_bank')
            ->select('bank', 'id_bank')
            ->where('data_of', Fungsi::dataOfByDomainToko($domain_toko))
            ->get();

      	$toko = DB::table('t_store')
			->where('domain_toko', $domain_toko)
			->get()->first();
		$r['sort'] = strip_tags($request->sort);
		$r['cari'] = strip_tags($request->q);
		if(isset($toko)){
			return Fungsi::respon('depan.'.$toko->template.'.order', compact("toko", 'r', 'order_data', 'tujuan_kirim', 'bank'), "html", $request);
		} else {
			// ke landing page
		}
        
    }
}