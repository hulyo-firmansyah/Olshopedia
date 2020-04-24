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

	private function getProduk($dataOf, $cari = ''){
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
		$i = 0;
		foreach(Fungsi::genArray($produk) as $p){
			if(preg_match("/".$cari."/", strtolower($p->nama_produk))){
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
				$i++;
			}
		}
		unset($i);
		$hasil = [];
		foreach(Fungsi::genArray($data) as $i => $d){
			$index = array_search($d->produk_id, array_column($hasil, 'id_produk'));
			if($index !== false){
				$count = count($hasil[$index]->varian);
				$hasil[$index]->varian[$count] = new \stdclass();
				$hasil[$index]->varian[$count]->diskon_jual = $d->diskon_jual;
				$hasil[$index]->varian[$count]->harga_jual_normal = $d->harga_jual_normal;
				$hasil[$index]->varian[$count]->sku = $d->sku;
				$hasil[$index]->varian[$count]->stok = $d->stok;
				$hasil[$index]->varian[$count]->ukuran = $d->ukuran;
				$hasil[$index]->varian[$count]->warna = $d->warna;
				$hasil[$index]->varian[$count]->foto_id = $d->foto_id;
				if($d->harga_jual_normal > $hasil[$index]->termahal) $hasil[$index]->termahal = $d->harga_jual_normal;
				if($d->harga_jual_normal < $hasil[$index]->termurah) $hasil[$index]->termurah = $d->harga_jual_normal;
			} else {
				$hasil[$i] = new \stdclass();
				$hasil[$i]->id_produk = $d->produk_id;
				$hasil[$i]->ket = $d->ket;
				$hasil[$i]->berat = $d->berat;
				$hasil[$i]->kategori = $d->kategori;
				$hasil[$i]->nama_produk = $d->nama_produk;
				$hasil[$i]->termurah = $d->harga_jual_normal;
				$hasil[$i]->termahal = $d->harga_jual_normal;
				$hasil[$i]->varian = [];
				$hasil[$i]->varian[0] = new \stdclass();
				$hasil[$i]->varian[0]->diskon_jual = $d->diskon_jual;
				$hasil[$i]->varian[0]->harga_jual_normal = $d->harga_jual_normal;
				$hasil[$i]->varian[0]->sku = $d->sku;
				$hasil[$i]->varian[0]->stok = $d->stok;
				$hasil[$i]->varian[0]->ukuran = $d->ukuran;
				$hasil[$i]->varian[0]->warna = $d->warna;
				$hasil[$i]->varian[0]->foto_id = $d->foto_id;
			}
		}
		return $hasil;
	}

	private function sortingProduk(string $tipe = null, array &$produk){
		switch($tipe){
			case 'murah-mahal':
				usort($produk, function ($a, $b){
					if ($a->termurah == $b->termurah) {
						return 0;
					}
					return ($a->termurah < $b->termurah) ? -1 : 1;
				});
				break;
			case 'mahal-murah':
				usort($produk, function ($a, $b){
					if ($a->termahal == $b->termahal) {
						return 0;
					}
					return ($a->termahal > $b->termahal) ? -1 : 1;
				});
				break;
			case 'z-a':
				usort($produk, function($a, $b){
					return strcasecmp($a->nama_produk, $b->nama_produk);
				});
			break;
			case 'a-z':
			default:
				usort($produk, function($a, $b){
					return strcasecmp($b->nama_produk, $a->nama_produk);
				});
			break;
		}
	}

    public function index(Request $request, $toko_slug){
		$r['sort'] = strip_tags($request->sort);
		$r['cari'] = strip_tags($request->q);
		$toko = DB::table('t_store')
			->where('domain_toko', $toko_slug)
			->get()->first();
		if(isset($toko)){
			$produk = $this->getProduk(Fungsi::dataOfByTokoSlug($toko_slug), $r['cari']);
			$this->sortingProduk($r['sort'], $produk);
			return Fungsi::respon('depan.'.$toko->template.'.home', compact("toko", 'produk', 'r'), "html", $request);
		} else {
			// ke landing page
		}
	}

	public function produkIndex(Request $request, $toko_slug, $id_produk = null){
		if(is_null($id_produk) || preg_match("/[^0-9]/", $id_produk)){
            return redirect()->route('d.home', ['toko_slug' => $toko_slug]);
		}
		$toko = DB::table('t_store')
			->where('domain_toko', $toko_slug)
			->get()->first();
		$r['sort'] = strip_tags($request->sort);
		$r['cari'] = strip_tags($request->q);
		if(isset($toko)){
			return Fungsi::respon('depan.'.$toko->template.'.detail-produk', compact("toko", 'r'), "html", $request);
			// $produk = $this->getProduk(Fungsi::dataOfByTokoSlug($toko_slug));
			// $this->sortingProduk($r['sort'], $produk);
			// return Fungsi::respon('depan.'.$toko->template.'.home', compact("toko", 'produk', 'r'), "html", $request);
		} else {
			// ke landing page
		}
		// dd($id_produk);
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