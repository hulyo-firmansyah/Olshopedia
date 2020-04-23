<?php

namespace App\Http\Controllers\depan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\PusatController as Fungsi;

class DashboardController extends Controller
{
	public function __construct(){
		// $this->middleware('b.auth');
		// $this->middleware('b.locale');
		$this->middleware('xss_protect');
	}

	private function getProduk($dataOf){
		$produk = Cache::remember('data_produk_ajax_'.$dataOf, 60000, function() use($dataOf){
			return DB::table('t_varian_produk')
				->join('t_produk', 't_produk.id_produk', '=', 't_varian_produk.produk_id')
				->select('t_varian_produk.id_varian', 't_varian_produk.produk_id', 't_varian_produk.diskon_jual', 't_varian_produk.harga_beli',
				't_varian_produk.harga_jual_normal', 't_varian_produk.harga_jual_reseller', 't_produk.ket', 't_produk.berat', 
				't_varian_produk.foto_id', 't_produk.nama_produk', 't_produk.kategori_produk_id', 't_produk.supplier_id', 't_varian_produk.sku',
				't_varian_produk.stok', 't_varian_produk.ukuran',  't_varian_produk.warna')
				->where('t_varian_produk.data_of', $dataOf)
				->where('t_produk.arsip', 0)
				->get();
		});
		$data = [];
		foreach(Fungsi::genArray($produk) as $i => $p){
			$data[] = (array)$p;
			if(!is_null($p->foto_id)){
				$fotoSrc = json_decode($p->foto_id);
				if(!is_null($fotoSrc->utama) && is_numeric($fotoSrc->utama)){
					$fotoUtama = DB::table('t_foto')->where('id_foto', $fotoSrc->utama)->where('data_of', $dataOf)->get()->first();
					$data[$i]['foto']["utama"] = asset($fotoUtama->path);
					unset($fotoUtama);
				} else if(!is_null($fotoSrc->utama) && filter_var($fotoSrc->utama, FILTER_VALIDATE_URL)){
					$data[$i]['foto']["utama"] = $fotoSrc->utama;
				}
				if($fotoSrc->lain != ""){
					$fotoLain_list = explode(";", $fotoSrc->lain);
					foreach($fotoLain_list as $iI => $iL){
						if(is_numeric($iL)){
							$fotoLain = DB::table('t_foto')->where('id_foto', $iL)->where('data_of', $dataOf)->get()->first();
							$data[$i]['foto']["lain"][$iI+1] = asset($fotoLain->path);
							unset($fotoLain);
						} else if(filter_var($iL, FILTER_VALIDATE_URL)){
							$data[$i]['foto']["lain"][$iI+1] = $iL;
						}
					}
				}
			}
			if(!is_null($data[$i]['kategori_produk_id'])){
				$kategori = DB::table('t_kategori_produk')->where('id_kategori_produk', $data[$i]['kategori_produk_id'])->where('data_of', $dataOf)->get()->first();
				if(isset($kategori)){
					$data[$i]['kategori']['nama'] = $kategori->nama_kategori_produk;
					$data[$i]['kategori']['id'] = $data[$i]['kategori_produk_id'];
				} else {
					$data[$i]['kategori']['nama'] = null;
					$data[$i]['kategori']['id'] = $data[$i]['kategori_produk_id'];
				}
			} else {
				$data[$i]['kategori']['nama'] = null;
				$data[$i]['kategori']['id'] = null;
			}
			unset($data[$i]['kategori_produk_id']);
			$data[$i] = (object)$data[$i];
		}
		return $data;
	}

    public function index(Request $request, $toko_slug){
		// dd($toko_slug);
		$toko = DB::table('t_store')
			->where('domain_toko', $toko_slug)
			->get()->first();
		if(isset($toko)){
			$produk = $this->getProduk(Fungsi::dataOfByTokoSlug($toko_slug));
			// dd($produk);
			if($request->ajax()){
				return Fungsi::respon('depan.'.$toko->template.'.index', compact("toko", 'produk'), "ajax", $request);
			}
			return Fungsi::respon('depan.'.$toko->template.'.index', compact("toko", 'produk'), "html", $request);
		} else {
			// ke landing page
		}
	}

	// public function locale(Request $request){
	// 	$langAv = ['en', 'id'];
	// 	if(!isset($request->lang)){
	// 		$lang = 'id';
	// 	}
	// 	if(!in_array($request->lang, $langAv)){
	// 		$lang = 'id';
	// 	} else {
	// 		$lang = $request->lang;
	// 	}
		
	// 	$request->session()->put('locale', $lang);
	// 	if(filter_var(base64_decode($request->next), FILTER_VALIDATE_URL)){
	// 		return redirect(base64_decode($request->next));
	// 	} else {
	// 		return redirect('/');
	// 	}
	// }
	
}