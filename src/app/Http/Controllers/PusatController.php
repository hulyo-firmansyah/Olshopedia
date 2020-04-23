<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use \Exception;

class PusatController 
{
	public static function parseAjax($view, $var = []){
		$data = view($view, $var);
		$h = explode("<!--uiop-->", $data);
		return response()->json(['data' => $h[1]]);
	}

	public static function getContent($path = null){
		if(is_null($path)){
			return false;
		} else {
			return \file_get_contents(base_path('../public/'.$path));
		}
	}
	
	public static function cekPlus($no){
		return trim(str_replace("-", "", str_replace("+", "", $no)));
	}

    public static function time_since($original){
        $chunks = array(
            array(60 * 60 * 24 * 365, 'tahun'),
            array(60 * 60 * 24 * 30, 'bulan'),
            array(60 * 60 * 24 * 7, 'minggu'),
            array(60 * 60 * 24, 'hari'),
            array(60 * 60, 'jam'),
            array(60, 'menit'),
        );

        $today = time();
        $since = $today - $original;

        if($since > 604800){
        	$print = date("M jS", $original);
        	if($since > 31536000){
            	$print .= ", " . date("Y", $original);
        	}
        	return $print;
        }

        for($i = 0, $j = count($chunks); $i < $j; $i++){
			$seconds = $chunks[$i][0];
			$name = $chunks[$i][1];

			if (($count = floor($since / $seconds)) != 0) break;
        }

		if($count == 0){
			return 'Baru saja';
		}
		$print = ($count == 1) ? '1 ' . $name : "$count {$name}";
        return $print . ' yang lalu';
    }


	public static function respon($view, $var = [], $tipe = "html", $request = null){
		if(is_null($request)){
			abort("404");
		} else {
			$accEn = explode(", ", $request->header()["accept-encoding"][0]);
			if(in_array("gzip", $accEn)){
				if($tipe == "html"){
					return response(gzencode(view($view, $var)->render(), 6))
						->header('Content-type', 'text/html; charset=UTF-8')
						->header('Content-Encoding', 'gzip');
				} else if($tipe == "json"){
					return response(gzencode(json_encode($view), 6))
						->header('Content-type', 'application/json; charset=UTF-8')
						->header('Content-Encoding', 'gzip');
				} else if($tipe == "ajax"){
					$data = view($view, $var)->render();
					$h = explode("<!--uiop-->", $data);
					return response(gzencode(json_encode(['data' => $h[1]]), 6))
						->header('Content-type', 'application/json; charset=UTF-8')
						->header('Content-Encoding', 'gzip');
				} else if($tipe == "raw_html"){
					return response(gzencode($view, 6))
						->header('Content-type', 'text/html; charset=UTF-8')
						->header('Content-Encoding', 'gzip');
				}
			} else {
				if($tipe == "html"){
					return view($view, $var);
				} else if($tipe == "json"){
					return response()->json($view);
				} else if($tipe == "ajax"){
					return PusatController::parseAjax($view, $var);
				} else if($tipe == "raw_html"){
					return $view;
				}
			}
		}
	}

	public static function hitungHargaJual($data_order){
		$cekKat = $data_order->pemesan_kategori;
		$hasil = [];
		switch($cekKat){
			case "Dropshipper":
				$kat_customer = json_decode($data_order->kat_customer)->dropshipper;
				break;

			case "Reseller":
				$kat_customer = json_decode($data_order->kat_customer)->reseller;
				break;

			case "Customer":
			default:
				$kat_customer = json_decode($data_order->kat_customer)->customer;
				break;
		}
		foreach(self::genArray(json_decode($data_order->produk)->list) as $iP => $vP){
			$produk = $vP->rawData;
			if($kat_customer->grosir){
				if(isset($produk->harga_grosir)){
					$genGrosir = self::genArray($produk->harga_grosir);
					$ketemu = false;
					foreach($genGrosir as $iG => $vG){
						$genGrosirRentan = self::genArrayFor(explode("-", $vG->rentan)[0], explode("-", $vG->rentan)[1]);
						foreach($genGrosirRentan as $vR){
							if($vR == $vP->jumlah) {
								if($kat_customer->diskon){
									if(!is_null($produk->diskon_jual)){
										$diskonData = explode("|", $produk->diskon_jual);
										if($diskonData[1] == "%"){
											// echo "a ";
											$diskon = self::diskon($vG->harga, $diskonData[0]);
											$hasil[$produk->id_varian] = ($diskon * $vP->jumlah);
											$ketemu = true;
											$genGrosirRentan->send('stop');
										} else {
											// echo "b ";
											$diskon = ($vG->harga - $diskonData[0]);
											$hasil[$produk->id_varian] = ($diskon * $vP->jumlah);
											$ketemu = true;
											$genGrosirRentan->send('stop');
										}
									} else {
										// echo "c ";
										$hasil[$produk->id_varian] = ($vG->harga * $vP->jumlah);
										$ketemu = true;
										$genGrosirRentan->send('stop');
									}
								} else {
									// echo "d ";
									$hasil[$produk->id_varian] = ($vG->harga * $vP->jumlah);
									$ketemu = true;
									$genGrosirRentan->send('stop');
								}
							}
						}
						if($ketemu) $genGrosir->send('stop');
					}
					if(!$ketemu){
						$harga_jual = (is_null($produk->harga_jual_reseller) ? $produk->harga_jual_normal : $produk->harga_jual_reseller);
						if($kat_customer->diskon){
							if(!is_null($produk->diskon_jual)){
								$diskonData = explode("|", $produk->diskon_jual);
								if($diskonData[1] == "%"){
									$diskon = self::diskon($harga_jual, $diskonData[0]);
									if($cekKat == "Reseller"){
										// echo "e ";
										$hasil[$produk->id_varian] = ($diskon * $vP->jumlah);
									} else {
										// echo "f ";
										$hasil[$produk->id_varian] = ($diskon * $vP->jumlah);
									}
								} else {
									$diskon = ($harga_jual - $diskonData[0]);
									if($cekKat == "Reseller"){
										// echo "g ";
										$hasil[$produk->id_varian] = ($diskon * $vP->jumlah);
									} else {
										// echo "h ";
										$hasil[$produk->id_varian] = ($diskon * $vP->jumlah);
									}
								}
							} else {
								if($cekKat == "Reseller"){
									// echo "i ";
									$hasil[$produk->id_varian] = ($harga_jual * $vP->jumlah);
								} else {
									// echo "j ";
									$hasil[$produk->id_varian] = ($produk->harga_jual_normal * $vP->jumlah);
								}
							}
						} else {
							if($cekKat == "Reseller"){
								// echo "k ";
								$hasil[$produk->id_varian] = ($harga_jual * $vP->jumlah);
							} else {
								// echo "l ";
								$hasil[$produk->id_varian] = ($produk->harga_jual_normal * $vP->jumlah);
							}
						}
					}
				} else {
					$harga_jual = (is_null($produk->harga_jual_reseller) ? $produk->harga_jual_normal : $produk->harga_jual_reseller);
					if($kat_customer->diskon){
						if(!is_null($produk->diskon_jual)){
							$diskonData = explode("|", $produk->diskon_jual);
							if($diskonData[1] == "%"){
								$diskon = self::diskon($harga_jual, $diskonData[0]);
								if($cekKat == "Reseller"){
									// echo "o ";
									$hasil[$produk->id_varian] = ($diskon * $vP->jumlah);
								} else {
									// echo "p ";
									$hasil[$produk->id_varian] = ($diskon * $vP->jumlah);
								}
							} else {
								$diskon = ($harga_jual - $diskonData[0]);
								if($cekKat == "Reseller"){
									// echo "q ";
									$hasil[$produk->id_varian] = ($diskon * $vP->jumlah);
								} else {
									// echo "r ";
									$hasil[$produk->id_varian] = ($diskon * $vP->jumlah);
								}
							}
						} else {
							if($cekKat == "Reseller"){
								// echo "s ";
								$hasil[$produk->id_varian] = ($harga_jual * $vP->jumlah);
							} else {
								// echo "t ";
								$hasil[$produk->id_varian] = ($produk->harga_jual_normal * $vP->jumlah);
							}
						}
					} else {
						if($cekKat == "Reseller"){
							// echo "u ";
							$hasil[$produk->id_varian] = ($harga_jual * $vP->jumlah);
						} else {
							// echo "v ";
							$hasil[$produk->id_varian] = ($produk->harga_jual_normal * $vP->jumlah);
						}
					}
				}
			} else {
				if($cekKat == "Reseller"){
					// echo "m ";
					$hasil[$produk->id_varian] = ((is_null($produk->harga_jual_reseller) ? $produk->harga_jual_normal : $produk->harga_jual_reseller) * $vP->jumlah);
				} else {
					// echo "n ";
					$hasil[$produk->id_varian] = ($produk->harga_jual_normal * $vP->jumlah);
				}
			}
		}
		return $hasil;
	}

	public static function dataOfCek($id = null){
		if(is_null($id) || !\is_numeric($id)){
			$id = Auth::user()->id;
		}
		$data_user = DB::table('t_user_meta')->select('role', 'data_of')->where('user_id', $id)->get()->first();
		if(isset($data_user)){
			if($data_user->role == 'Owner' || $data_user->role == 'SuperAdmin'){
				return $id;
			} else if($data_user->role == 'Admin'){
				return $data_user->data_of;
			} else {
				throw new Exception('Data user tersebut tidak boleh mengakses!');
			}
		} else {
			throw new Exception('Data user tersebut tidak ada!');
		}
	}

	public static function dataOfByTokoSlug($toko_slug){
		$toko = DB::table('t_store')
			->where('domain_toko', $toko_slug)
			->get()->first();
		if(isset($toko)){
			return $toko->data_of;
		} else {
			return null;
		}
	}

	public static function dataOfCekUsername($id = null){
		if(is_null($id) || !\is_numeric($id)){
			$id = Auth::user()->id;
		}
		$data_user = DB::table('t_user_meta')->select('role', 'data_of')->where('user_id', $id)->get()->first();
		if(isset($data_user)){
			if($data_user->role == 'Owner' || $data_user->role == 'SuperAdmin'){
				return Auth::user()->username;
			} else if($data_user->role == 'Admin'){
				$data_username = DB::table('users')->select('username')->where('id', $data_user->data_of)->get()->first();
				if(isset($data_username)){
					return $data_username->username;
				} else {
					throw new Exception('Data user tersebut tidak mempunyai username!');
				}
			} else {
				throw new Exception('Data user tersebut tidak boleh mengakses!');
			}
		} else {
			throw new Exception('Data user tersebut tidak ada!');
		}
	}
	
	public static function uangFormat($angka, $rupiah = null){
		return ((is_null($rupiah)) ? "" : "Rp ").number_format($angka, 0, ',', '.');
	}
	
	public static function formatUang($angka, $rupiah = null){
		if($angka >= 0){
			return ((is_null($rupiah)) ? "" : "Rp ").number_format($angka, 0, ',', '.');
		} else {
			$temp = ((is_null($rupiah)) ? "" : "Rp ").number_format($angka, 0, ',', '.');
			$temp = str_replace('-', '', $temp);
			return '- '.$temp;
		}
	}

	public static function diskon($harga, $diskon){
		return ((int)$harga - (((int)$harga * (int)$diskon) / 100));
	}

	public static function acakPass(){
		$string = "abcdefghijkmnopqrstuvwxyzABCDEFGHJKLMNOPQRSTUVWXYZ1234567890";
		$array = str_split($string);
		$batas = 8;
		$hasil = '';
		for($i=0;$i<$batas;$i++){
			$hasil .= $array[mt_rand(0, count($array)-1)];
		}
		return $hasil;
	}
	
	public static function pathShift($data){
		$tAr = str_split($data);
		$tShift = array_shift($tAr);
		return implode("", $tAr);
	}

	
	public static function convertMemory($size){
		$unit=array('b','kb','mb','gb','tb','pb');
		return @round($size/pow(1024,($i=floor(log($size,1024)))),2).' '.$unit[$i];
	}

	public static function cekOngkir($o, $d, $w, $k, $t = "starter"){
		if($t == "starter"){
			$a = "59e4ffe3e3ce2dde5119d1a62246be0f";
			$url = "https://api.rajaongkir.com/".$t."/cost";
			$data = "origin=".$o."&destination=".$d."&weight=".$w."&courier=".$k;
		} else if($t == "pro"){
			$a = "88f3d4deb7a5cb324423ebec7d05c69e";
			$url = "https://pro.rajaongkir.com/api/cost";
			$data = "origin=".$o."&originType=subdistrict&destination=".$d."&destinationType=subdistrict&weight=".$w."&courier=".$k;
		}
		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => $url,
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "POST",
		  CURLOPT_POSTFIELDS => $data,
		  CURLOPT_HTTPHEADER => array( 
			"content-type: application/x-www-form-urlencoded",
			"key: ".$a
		  ),
		));
		
		$response = curl_exec($curl);
		$err = curl_error($curl);
		
		curl_close($curl);
		
		if ($err) {
		  return json_encode(["error" => true, "msg" => $err]);
		} else {
		  return $response;
		}
	}

	public static function genArray($data){
		foreach($data as $i => $c){
			$inject = yield $i => $c;
			if($inject === 'stop')return;
		}
	}

	public static function genArrayFor($min, $max, $step = 1){
		for($i=$min; $i<=$max; $i+=$step){
			$inject = yield $i;
			if($inject === 'stop')return;
		}
	}

	public static function trackResi($w, $k){
		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => "https://pro.rajaongkir.com/api/waybill",
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "POST",
		  CURLOPT_POSTFIELDS => "waybill=".$w."&courier=".$k,
		  CURLOPT_HTTPHEADER => array( 
			"content-type: application/x-www-form-urlencoded",
			"key: 88f3d4deb7a5cb324423ebec7d05c69e"
		  ),
		));
		
		$response = curl_exec($curl);
		$err = curl_error($curl);
		
		curl_close($curl);
		
		if ($err) {
		  return json_encode(["error" => true, "msg" => $err]);
		} else {
		  return $response;
		}
	}
}
