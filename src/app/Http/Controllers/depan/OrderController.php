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

		if(Cache::has($order_slug.'-timer')){
			$timer = Cache::get($order_slug.'-timer');
		} else {
			$timer = 0;
		}

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
			$konfirmasi_bayar = DB::table('t_konfirmasi_bayar')
				->where('data_of', Fungsi::dataOfByDomainToko($domain_toko))
				->where('order_slug', $order_slug)
				->get()->first();
			if(isset($konfirmasi_bayar)){
				return Fungsi::respon('depan.'.$toko->template.'.order-bayar', compact("toko", 'r', 'order_data', 'tujuan_kirim', 'bank', 'order_slug', 'timer'), "html", $request);
			} else {
				return Fungsi::respon('depan.'.$toko->template.'.order', compact("toko", 'r', 'order_data', 'tujuan_kirim', 'bank', 'order_slug', 'timer'), "html", $request);
			}
		} else {
			// ke landing page
		}
        
	}
	
	public function konfirmasiBayarIndex(Request $request, $domain_toko, $order_slug = null){
		if(is_null($order_slug)) abort(404);

		$data_of = Fungsi::dataOfByDomainToko($domain_toko);

		$order_data = DB::table('t_order')
			->where('data_of', $data_of)
			->where('src', 'storefront')
			->where('order_slug', $order_slug)
			->get()->first();
		
		if(!isset($order_data)) abort(404);

		$cek_konfimasi = DB::table('t_konfirmasi_bayar')
			->where('data_of', $data_of)
			->where('order_slug', $order_slug)
			->get()->first();

		if(isset($cek_konfirmasi)) abort(404);

        $bank = DB::table('t_bank')
            ->where('data_of', Fungsi::dataOfByDomainToko($domain_toko))
            ->get();

      	$toko = DB::table('t_store')
			->where('domain_toko', $domain_toko)
			->get()->first();
		$r['sort'] = strip_tags($request->sort);
		$r['cari'] = strip_tags($request->q);
		if(isset($toko)){
			return Fungsi::respon('depan.'.$toko->template.'.konfirmasi-bayar', compact("toko", 'r', 'order_data', 'order_slug', 'bank'), "html", $request);
		} else {
			// ke landing page
		}
	}
	
	public function proses(Request $request, $domain_toko){
		// var_dump($request->file('foto_bukti'));
		// return "<pre>".print_r($request->all(), true)."</pre>";
		$support_gambar = ['jpeg', 'jpg', 'png', 'gif'];

		$toko = DB::table('t_store')
			->where('domain_toko', $domain_toko)
			->get()->first();

		if(!isset($toko)) {
			// ke landing page
		}

		$tipe = strip_tags($request->get('tipe'));
		switch($tipe){
			case 'konfirmasi_bayar':
				$atas_nama = strip_tags($request->get('atas_nama'));
				$nominal = strip_tags($request->get('nominal'));
				$tgl_transfer = strip_tags($request->get('tgl_transfer'));
				$catatan = strip_tags($request->get('catatan'));
				$order_slug = strip_tags($request->get('order_pilih'));
				$bank_tujuan = strip_tags($request->get('bank_tujuan'));
				$foto_bukti = $request->file('foto_bukti');

				if(!isset($foto_bukti)){
					return redirect()->back()->with(['msg_error' => "Foto bukti pembayaran belum diupload!"])->withInput($request->input());
				}

				$path = "../data/".base64_encode(base64_encode(Fungsi::dataOfByDomainToko($domain_toko))."+".base64_encode(Fungsi::dataOfByDomainToko($domain_toko, true)))."/";
				//pakai base_path untuk move, pakai asset untuk nampilkan.
				if(is_dir(base_path($path))){
					$path_isset = true;
				} else {
					if(mkdir(base_path($path), 0777, true)){
						$path_isset = true;
					} else {
						$path_isset = false;
						// DB::table('t_produk')->where('id_produk', $lastID_produk)->where('data_of', Fungsi::dataOfCek())->delete();
						// return redirect()->back()->with(['msg_error' => "Tidak dapat membuat folder data!"])->withInput($request->input());
					}
				}

				if(!$path_isset) {
					return redirect()->back()->with(['msg_error' => "Tidak dapat membuat folder penyimpanan foto!"])->withInput($request->input());
				}
				
				$filename = str_random(14).base64_encode(time().mt_rand(0,9)).".".$foto_bukti->getClientOriginalExtension();
				if($foto_bukti->move(base_path($path), $filename)){
					$id_foto = DB::table('t_foto')->insertGetId([
						'path' => $path.$filename,
						'data_of' => Fungsi::dataOfByDomainToko($domain_toko)
					]);
					$simpan['foto_id'] = $id_foto;
				}

				$simpan['atas_nama'] = $atas_nama;
				$simpan['nominal'] = (int)$nominal;
				$simpan['tgl_transfer'] = $tgl_transfer;
				$simpan['catatan'] = $catatan;
				$simpan['bank_tujuan'] = $bank_tujuan;
				$simpan['order_slug'] = $order_slug;
				$simpan['data_of'] = Fungsi::dataOfByDomainToko($domain_toko);

				$konfirmasi_bayar = DB::table('t_konfirmasi_bayar')->insert($simpan);
				echo "sukses";
				break;	
		}
	}
}