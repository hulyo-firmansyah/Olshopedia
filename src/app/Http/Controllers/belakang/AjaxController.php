<?php

namespace App\Http\Controllers\belakang;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\PusatController as Fungsi;

class AjaxController extends Controller
{
	public function __construct(){
		$this->middleware('xss_protect');
		$this->middleware('b.auth')->except([
			'getWilayah',
			'getWilayahDetail',
			'cariKecamatan'
		]);
	}

	public function getWilayah(Request $request){
		if($request->ajax()){
			$wilayah_indonesia = json_decode(Fungsi::getContent('data/wilayah_indonesia.json'));
			if(!empty($request->term)){
				foreach(Fungsi::genArray($wilayah_indonesia) as $w){
					if($w->provinsi == $request->term){
						return Fungsi::respon($w->kabupaten, [], "json", $request);
					}
				}
			}
			return Fungsi::respon($wilayah_indonesia, [], "json", $request);
		} else {
			abort(404);
		}
	}
    
	public function getWilayahDetail(Request $request){
		if($request->ajax()){
			$wilayah_lengkap = json_decode(Fungsi::getContent('data/wilayah-lengkap.json'));
			if(!empty($request->term) && !empty($request->tipe)){
				$data = [];
				$i = 0;
				foreach(Fungsi::genArray($wilayah_lengkap) as $w){
					if(strtolower($w->provinsi->nama) == strtolower($request->term) && $request->tipe == "1"){
						$data[$i] = $w;
						$i++;
					}
					if(strtolower($w->kota->nama) == strtolower($request->term) && $request->tipe == "2"){
						$data[$i] = $w;
						$i++;
					}
					if(strtolower($w->kecamatan->nama) == strtolower($request->term) && $request->tipe == "3"){
						if(!empty($request->asd)){
							if(strtolower($w->kota->nama) == strtolower($request->asd)){
								$data[$i] = $w;
								$i++;
							} else {
								continue;
							}
						} else {
							$data[$i] = $w;
							$i++;
						}
					}
				}
				return Fungsi::respon($data, [], "json", $request);
			}
		} else {
			abort(404);
		}
	}

	
	public function cariKecamatan(Request $request){
		if($request->ajax()){
			$wilayah_lengkap = json_decode(Fungsi::getContent('data/wilayah-lengkap.json'));
			$data = [];
			$i = 0;
			if(!empty($request->term)){
				foreach(Fungsi::genArray($wilayah_lengkap) as $w){
					if(preg_match("/".strTolower($request->term)."/", strtolower($w->kecamatan->nama))){
						$data[$i]["value"] = $w->provinsi->id."|".$w->kota->id."|".$w->kecamatan->id;
						$data[$i]["label"] = $w->kecamatan->nama.", ".$w->kota->nama.", ".$w->provinsi->nama;
						$i++;
					}
				}
			}
			return Fungsi::respon($data, [], "json", $request);
		} else {
			abort(404);
		}
	}

	
    public function getProduk(Request $request){
		if($request->ajax()){
			$produk = Cache::remember('data_produk_ajax_'.Fungsi::dataOfCek(), 30000, function(){
				return DB::table('t_varian_produk')
					->join('t_produk', 't_produk.id_produk', '=', 't_varian_produk.produk_id')
					->select('t_varian_produk.id_varian', 't_varian_produk.produk_id', 't_varian_produk.diskon_jual', 't_varian_produk.harga_beli',
					't_varian_produk.harga_jual_normal', 't_varian_produk.harga_jual_reseller', 't_produk.ket', 't_produk.berat', 
					't_varian_produk.foto_id', 't_produk.nama_produk', 't_produk.kategori_produk_id', 't_produk.supplier_id', 't_varian_produk.sku',
					't_varian_produk.stok', 't_varian_produk.ukuran',  't_varian_produk.warna')
					->where('t_varian_produk.data_of', Fungsi::dataOfCek())
					->where('t_produk.arsip', 0)
					->get();
			});
			$data = [];
			$i = 0;
			$cari = (isset($request->cari)) ? strtolower($request->cari) : "";
			foreach(Fungsi::genArray($produk) as $p){
				if(preg_match("/".$cari."/", strtolower($p->nama_produk))){
					$data[] = (array)$p;
					if(!is_null($p->foto_id)){
						$fotoSrc = json_decode($p->foto_id);
						if(!is_null($fotoSrc->utama) && is_numeric($fotoSrc->utama)){
							$fotoUtama = DB::table('t_foto')->where('id_foto', $fotoSrc->utama)->where('data_of', Fungsi::dataOfCek())->get()->first();
							$data[$i]['foto']["utama"] = asset($fotoUtama->path);
							unset($fotoUtama);
						} else if(!is_null($fotoSrc->utama) && filter_var($fotoSrc->utama, FILTER_VALIDATE_URL)){
							$data[$i]['foto']["utama"] = $fotoSrc->utama;
						}
						if($fotoSrc->lain != ""){
							$fotoLain_list = explode(";", $fotoSrc->lain);
							foreach($fotoLain_list as $iI => $iL){
								if(is_numeric($iL)){
									$fotoLain = DB::table('t_foto')->where('id_foto', $iL)->where('data_of', Fungsi::dataOfCek())->get()->first();
									$data[$i]['foto']["lain"][$iI+1] = asset($fotoLain->path);
									unset($fotoLain);
								} else if(filter_var($iL, FILTER_VALIDATE_URL)){
									$data[$i]['foto']["lain"][$iI+1] = $iL;
								}
							}
						}
					}
					if(!is_null($data[$i]['kategori_produk_id'])){
						$kategori = DB::table('t_kategori_produk')->where('id_kategori_produk', $data[$i]['kategori_produk_id'])->where('data_of', Fungsi::dataOfCek())->get()->first();
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
					if($data[$i]['supplier_id'] == 0 || is_null($data[$i]['supplier_id'])){
						$data[$i]['supplier']['id'] = null;
						$data[$i]['supplier']['nama'] = null;
					} else {
						$supplier = DB::table('t_supplier')->select('nama_supplier')->where('id_supplier', $data[$i]['supplier_id'])->where('data_of', Fungsi::dataOfCek())->get()->first();
						if(isset($supplier)){
							$data[$i]['supplier']['id'] = $data[$i]['supplier_id'];
							$data[$i]['supplier']['nama'] = $supplier->nama_supplier;
						} else {
							$data[$i]['supplier']['id'] = $data[$i]['supplier_id'];
							$data[$i]['supplier']['nama'] = null;
						}
					}
					unset($data[$i]['supplier_id']);
					$hg = DB::table('t_grosir')
						->where('t_grosir.data_of', Fungsi::dataOfCek())
						->where('t_grosir.produk_id', $p->produk_id)
						->get();
					if(count($hg) > 0){
						$data[$i]["harga_grosir"] = 1;
					} else {
						$data[$i]["harga_grosir"] = 0;
					}
					$data[$i] = (object)$data[$i];
					$i++;
				}
			}
			return Fungsi::respon($data, [], "json", $request);
		} else {
			abort(404);
		}
	}
	
    public function getProdukById(Request $request){
		if($request->ajax()){
			if(isset($request->id)){
				$produk = Cache::remember('data_produk_ajax_'.Fungsi::dataOfCek(), 30000, function(){
					return DB::table('t_varian_produk')
						->join('t_produk', 't_produk.id_produk', '=', 't_varian_produk.produk_id')
						->select('t_varian_produk.id_varian', 't_varian_produk.produk_id', 't_varian_produk.diskon_jual', 't_varian_produk.harga_beli',
						't_varian_produk.harga_jual_normal', 't_varian_produk.harga_jual_reseller', 't_produk.ket', 't_produk.berat', 
						't_varian_produk.foto_id', 't_produk.nama_produk', 't_produk.kategori_produk_id', 't_produk.supplier_id', 't_varian_produk.sku',
						't_varian_produk.stok', 't_varian_produk.ukuran',  't_varian_produk.warna')
						->where('t_varian_produk.data_of', Fungsi::dataOfCek())
						->where('t_produk.arsip', 0)
						->get();
				});
				$data = [];
				$i = 0;
				foreach(Fungsi::genArray($produk) as $p){
					if($p->produk_id == $request->id){
						$data[] = (array)$p;
						if(!is_null($p->foto_id)){
							$fotoSrc = json_decode($p->foto_id);
							if(!is_null($fotoSrc->utama) && is_numeric($fotoSrc->utama)){
								$fotoUtama = DB::table('t_foto')->where('id_foto', $fotoSrc->utama)->where('data_of', Fungsi::dataOfCek())->get()->first();
								$data[$i]['foto']["utama"] = asset($fotoUtama->path);
								unset($fotoUtama);
							} else if(!is_null($fotoSrc->utama) && filter_var($fotoSrc->utama, FILTER_VALIDATE_URL)){
								$data[$i]['foto']["utama"] = $fotoSrc->utama;
							}
							if($fotoSrc->lain != ""){
								$fotoLain_list = explode(";", $fotoSrc->lain);
								foreach($fotoLain_list as $iI => $iL){
									if(is_numeric($iL)){
										$fotoLain = DB::table('t_foto')->where('id_foto', $iL)->where('data_of', Fungsi::dataOfCek())->get()->first();
										$data[$i]['foto']["lain"][$iI+1] = asset($fotoLain->path);
										unset($fotoLain);
									} else if(filter_var($iL, FILTER_VALIDATE_URL)){
										$data[$i]['foto']["lain"][$iI+1] = $iL;
									}
								}
							}
						}
						if(!is_null($data[$i]['kategori_produk_id'])){
							$kategori = DB::table('t_kategori_produk')->where('id_kategori_produk', $data[$i]['kategori_produk_id'])->where('data_of', Fungsi::dataOfCek())->get()->first();
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
						if($data[$i]['supplier_id'] == 0 || is_null($data[$i]['supplier_id'])){
							$data[$i]['supplier']['id'] = null;
							$data[$i]['supplier']['nama'] = null;
						} else {
							$supplier = DB::table('t_supplier')->select('nama_supplier')->where('id_supplier', $data[$i]['supplier_id'])->where('data_of', Fungsi::dataOfCek())->get()->first();
							if(isset($supplier)){
								$data[$i]['supplier']['id'] = $data[$i]['supplier_id'];
								$data[$i]['supplier']['nama'] = $supplier->nama_supplier;
							} else {
								$data[$i]['supplier']['id'] = $data[$i]['supplier_id'];
								$data[$i]['supplier']['nama'] = null;
							}
						}
						unset($data[$i]['supplier_id']);
						$hg = DB::table('t_grosir')
							->where('t_grosir.data_of', Fungsi::dataOfCek())
							->where('t_grosir.produk_id', $p->produk_id)
							->get();
						if(count($hg) > 0){
							$data[$i]["harga_grosir"] = 1;
						} else {
							$data[$i]["harga_grosir"] = 0;
						}
						$data[$i] = (object)$data[$i];
						$i++;
					}
				}
				return Fungsi::respon($data, [], "json", $request);
			} else {
				return Fungsi::respon([], [], "json", $request);
			}
		} else {
			abort(404);
		}
	}

	public function getOffsetProdukAkhirById(Request $request){
		if($request->ajax()){
			if(isset($request->id)){
				$id_produk = strip_tags($request->id);
				$offset_prod = DB::table('t_produk')
					->where('data_of', Fungsi::dataOfCek())
					->where('id_produk', $id_produk)
					->select('produk_offset')
					->orderBy('produk_offset', 'desc')
					->get()->first();
				if(isset($offset_prod)){
					$offset_sku = DB::table('t_varian_produk')
						->where('data_of', Fungsi::dataOfCek())
						->where('produk_id', $id_produk)
						->select('sku_offset')
						->orderBy('sku_offset', 'desc')
						->get()->first();
					$data['offset']['produk'] = $offset_prod->produk_offset;
					$data['offset']['sku'] = $offset_sku->sku_offset;
					return Fungsi::respon($data, [], "json", $request);
				} else {
					return Fungsi::respon([
						'offset' => null
					], [], "json", $request);
				}
			} else {
				return Fungsi::respon([
					'offset' => null
				], [], "json", $request);
			}
		} else {
			abort(404);
		}
	}

	public function getProdukDetail(Request $request){
		if($request->ajax()){
			if(isset($request->id)){
				$p = DB::table('t_varian_produk')
					->join('t_produk', 't_produk.id_produk', '=', 't_varian_produk.produk_id')
					->select('t_varian_produk.*', 't_produk.nama_produk', 't_produk.berat')
					->where('t_varian_produk.data_of', Fungsi::dataOfCek())
					->where('t_varian_produk.id_varian', $request->id)
					->get()
					->first();
				if(isset($p)){
					$data = (array)$p;
					if(!is_null($p->foto_id)){
						$fotoSrc = json_decode($p->foto_id);
						if(!is_null($fotoSrc->utama) && is_numeric($fotoSrc->utama)){
							$fotoUtama = DB::table('t_foto')->where('id_foto', $fotoSrc->utama)->where('data_of', Fungsi::dataOfCek())->get()->first();
							$data['foto']["utama"] = asset($fotoUtama->path);
							unset($fotoUtama);
						} else if(!is_null($fotoSrc->utama) && filter_var($fotoSrc->utama, FILTER_VALIDATE_URL)){
							$data['foto']["utama"] = $fotoSrc->utama;
						}
						if($fotoSrc->lain != ""){
							$fotoLain_list = explode(";", $fotoSrc->lain);
							foreach($fotoLain_list as $iI => $iL){
								if(is_numeric($iL)){
									$fotoLain = DB::table('t_foto')->where('id_foto', $iL)->where('data_of', Fungsi::dataOfCek())->get()->first();
									$data['foto']["lain"][$iI+1] = asset($fotoLain->path);
									unset($fotoLain);
								} else if(filter_var($fotoSrc->utama, FILTER_VALIDATE_URL)){
									$data['foto']["lain"][$iI+1] = $iL;
								}
							}
						}
					}
					unset($data["data_of"]);
					$hg = DB::table('t_grosir')
						->select('t_grosir.rentan', 't_grosir.harga', 't_grosir.id_grosir')
						->where('t_grosir.data_of', Fungsi::dataOfCek())
						->where('t_grosir.produk_id', $data["produk_id"])
						->get();
					if(!empty($hg[0])){
						foreach($hg as $key => $g){
							$data["harga_grosir"][$key] = $g;
						}
					}
					$data = (object)$data;
					return Fungsi::respon($data, [], "json", $request);
				} else {
					return response()->json("kosong");
				}
			} else {
				abort(404);
			}
		} else {
			abort(404);
		}
	}

	
	public function getCustomer(Request $request){
		if($request->ajax()){
			$customerSrc = DB::table('t_customer')
				->join('users', 'users.id', '=', 't_customer.user_id')
				->select('users.name', 't_customer.*')
				->where('t_customer.data_of', Fungsi::dataOfCek())
				->where('users.name', 'like', "%".$request->search."%")
				->get();
			$dataCustomer = [];
			foreach(Fungsi::genArray($customerSrc) as $c){
				array_push($dataCustomer, array('label' => "{$c->name}|{$c->alamat}|{$c->kecamatan}|{$c->kabupaten}|{$c->provinsi}|{$c->kode_pos}|{$c->kategori}", 'value' => $c->user_id));
			}
			return Fungsi::respon($dataCustomer, [], "json", $request);
		} else {
			abort(404);
		}
	}
}