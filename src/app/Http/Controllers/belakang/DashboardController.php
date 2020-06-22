<?php

namespace App\Http\Controllers\belakang;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\PusatController as Fungsi;

class DashboardController extends Controller
{
	public function __construct(){
		$this->middleware('b.auth')->except('locale');
		$this->middleware(['b.locale', 'xss_protect']);
	}


    public function index(Request $request){
        $data_user = \DB::table('t_user_meta')
            ->where('user_id', Auth::user()->id)
            ->select('role', 'ijin')
            ->get()->first();
        if(isset($data_user)){
			if(isset($data_user->ijin)){
				$ijin = json_decode($data_user->ijin);
			} else {
				$ijin = new \stdclass();
				$ijin->melihatOmset = 1;
			}
        } else {
            $ijin = new \stdclass();
            $ijin->melihatOmset = 0;
        }
		$data = $this->getDataStat();
		$store = DB::table('users')
			->join('t_store', 'users.id', '=', 't_store.data_of')
			->where('users.id', Fungsi::dataOfCek())
			->select('users.id', 'users.name', 'users.no_telp', 't_store.nama_toko', 't_store.domain_toko', 't_store.deskripsi_toko', 't_store.no_telp_toko')
			->get()->first();
		$key['dd'] = encrypt('first_setup', false);
		$key['tt'] = base64_encode('first_setup');
		$tgl_now = urlencode(date('d M Y'));
		$url_['order_hari_ini'] = route('b.order-filter').'?f_admin=0&f_bayar=0&f_kirim=0&f_via=0&f_kurir=0&f_orderSource=0&f_print=0&f_tglTipe=order&f_tglDari='.$tgl_now.'&f_tglSampai='.$tgl_now;
		$url_['belum_diproses'] = route('b.order-filter').'?f_id=f_belum_proses&f_admin=0&f_bayar=0&f_kirim=belum_proses&f_via=0&f_kurir=0&f_print=0&f_tglTipe=bayar&f_tglDari=&f_tglSampai=';
		if($request->ajax()){
			return Fungsi::respon('belakang.dashboard', compact('store', 'key', 'url_', 'data', 'data_user', 'ijin'), "ajax", $request);
		}
		return Fungsi::respon('belakang.dashboard', compact('store', 'key', 'url_', 'data', 'data_user', 'ijin'), "html", $request);
	}
	
	// public function optimize(){
	// 	$url = route('b.dashboard');
	// 	\Artisan::call('optimize:clear');
	// 	\Artisan::call('optimize');
	// 	return redirect($url);
	// }

	private function getDataStat(){
		$order_data = DB::table('t_order')
		->where('data_of', Fungsi::dataOfCek())
		->where('canceled', 0)
		->get();
		$data = [];
		$data['chart_gross_profit_bulan_ini'] = $this->hitungGrossProfitBulanIni($order_data);
		$data['order_hari_ini']['data'] = Fungsi::uangFormat($this->hitungOrderHariIni($order_data));
		$data['order_hari_ini']['cek'] = $this->cekOrderHariIni($order_data);
		$data['belum_diproses']['data'] = Fungsi::uangFormat($this->hitungBelumDiProses($order_data));
		$data['chart_order_dan_produk_bulan_ini'] = $this->hitungChartOrderDanProdukBulanIni($order_data);
		$data['produk_terjual']['data'] = Fungsi::uangFormat($this->hitungProdukTerjual($order_data));
		$temp_gross_profit = $this->hitungGrossProfit($order_data);
		if($temp_gross_profit >= 0){
			$data['gross_profit']['data'] = "Rp ".Fungsi::uangFormat($temp_gross_profit);
			$data['gross_profit']['cek'] = 1;
		} else if($temp_gross_profit < 0){
			$temp_gross_profit = str_replace('-', '', (string)$temp_gross_profit);
			$data['gross_profit']['data'] = "- Rp ".Fungsi::uangFormat($temp_gross_profit);
			$data['gross_profit']['cek'] = -1;
		}
		return $data;
	}

	private function hitungGrossProfitBulanIni(&$order_data){
		$today = (int)date('j', strtotime('today'));
		$data_hasil = $temp_hasil = $list_tgl = [];
		foreach(Fungsi::genArray($order_data) as $iU => $vU){
			if($vU->state == "terima"){
				$temp_hasil[] = $vU;
			}
		}
		// dd($temp_hasil);
		foreach(Fungsi::genArrayFor(1, $today) as $i){
			$list_tgl[] = ((string)$i).date(' M Y');
			$total_temp = 0;
			$time = strtotime(((string)$i).date(' M Y'));
			foreach(Fungsi::genArray($temp_hasil) as $iH => $vH){
				$t_tglOrder = strtotime($vH->tanggal_order);
				if($t_tglOrder == $time){
					$kat_customer = json_decode($vH->kat_customer);
					$produk = json_decode($vH->produk);
					$harga_beli = 0;
					foreach(Fungsi::genArray($produk->list) as $iP => $vP){
						$harga_beli += ((int)$vP->rawData->harga_beli * $vP->jumlah);
					}
					$harga_jual = (int)json_decode($vH->total)->hargaProduk;
					$total_temp += ($harga_jual - $harga_beli);
				}
			}
			$data_hasil[] = $total_temp;
		}
		$hasil['data'] = json_encode($data_hasil);
		$hasil['tgl'] = json_encode($list_tgl);
		return $hasil;
	}

	private function hitungChartOrderDanProdukBulanIni(&$order_data){
		$today = (int)date('j', strtotime('today'));
		// $lastDay = (int)date('t', strtotime('today'));
		$data_hasil_order = $data_hasil_produk = $list_tgl = [];
		$temp_order = $temp_produk = 0;
		// foreach(Fungsi::genArrayFor(1, $lastDay) as $i){
		// 	array_push($list_tgl, ((string)$i).date(' M Y'));
		// }
		foreach(Fungsi::genArrayFor(1, $today) as $i){
			$list_tgl[] = ((string)$i).date(' M Y');
			foreach(Fungsi::genArray($order_data) as $iU => $vU){
				$time = strtotime(((string)$i).date(' M Y'));
				$t_tglOrder = strtotime($vU->tanggal_order);
				if($t_tglOrder == $time){
					$temp_order++;
					if($vU->state == "terima"){
						$produk = json_decode($vU->produk);
						foreach(Fungsi::genArray($produk->list) as $iP => $vP){
							$temp_produk += (int)$vP->jumlah;
						}
					}
				}
			}
			$data_hasil_order[] = $temp_order;
			$data_hasil_produk[] = $temp_produk;
			$temp_order = $temp_produk = 0;
		}
		$hasil['order']['data'] = json_encode($data_hasil_order);
		$hasil['produk']['data'] = json_encode($data_hasil_produk);
		$hasil['tgl'] = json_encode($list_tgl);
		return $hasil;
	}

	private function hitungOrderHariIni(&$order_data){
		$data_hasil = [];
		$tgl_now = date('d M Y');
		foreach(Fungsi::genArray($order_data) as $iU => $vU){
			$t_tglDari = strtotime($tgl_now);
			$t_tglSampai = strtotime($tgl_now);
			$t_tglOrder = strtotime($vU->tanggal_order);
			if($t_tglOrder >= $t_tglDari && $t_tglOrder <= $t_tglSampai){
				$data_hasil[] = $vU->id_order;
			}
		}
		return count($data_hasil);
	}

	private function hitungProdukTerjual(&$order_data){
		$data_hasil = 0;
		$temp_hasil = [];
		foreach(Fungsi::genArray($order_data) as $iU => $vU){
			if($vU->state == "terima"){
				$temp_hasil[] = $vU;
			}
		}
		foreach(Fungsi::genArray($temp_hasil) as $iH => $vH){
			$produk = json_decode($vH->produk);
			foreach(Fungsi::genArray($produk->list) as $iP => $vP){
				$data_hasil += (int)$vP->jumlah;
			}
		}
		return $data_hasil;
	}

	private function hitungGrossProfit(&$order_data){
		$data_hasil = 0;
		$temp_hasil = [];
		foreach(Fungsi::genArray($order_data) as $iU => $vU){
			if($vU->state == "terima"){
				$temp_hasil[] = $vU;
			}
		}
		foreach(Fungsi::genArray($temp_hasil) as $iH => $vH){
			$kat_customer = json_decode($vH->kat_customer);
			$produk = json_decode($vH->produk);
			$harga_beli = 0;
			foreach(Fungsi::genArray($produk->list) as $iP => $vP){
				$harga_beli += ((int)$vP->rawData->harga_beli * $vP->jumlah);
			}
			$harga_jual = (int)json_decode($vH->total)->hargaProduk;
			$data_hasil += ($harga_jual - $harga_beli);
		}
		return $data_hasil;
	}

	private function hitungBelumDiProses(&$order_data){
		$data_hasil = [];
		foreach(Fungsi::genArray($order_data) as $iU => $vU){
			if($vU->state == "bayar"){
				$data_hasil[] = $vU->id_order;
			}
		}
		return count($data_hasil);
	}

	private function cekOrderHariIni(&$order_data){
		$data_hasil = [];
		$tgl_now = date('d M Y', strtotime('-1 day'));
		foreach(Fungsi::genArray($order_data) as $iU => $vU){
			$t_tglDari = strtotime($tgl_now);
			$t_tglSampai = strtotime($tgl_now);
			$t_tglOrder = strtotime($vU->tanggal_order);
			if($t_tglOrder >= $t_tglDari && $t_tglOrder <= $t_tglSampai){
				$data_hasil[] = $vU;
			}
		}
		$order_hari_ini = $this->hitungOrderHariIni($order_data);
		$order_kemarin = count($data_hasil);
		if($order_hari_ini > $order_kemarin){
			return 1;
		} else if($order_hari_ini < $order_kemarin){
			return -1;
		}
		return 0;
	}

	public function locale(Request $request){
		$langAv = ['en', 'id'];
		if(!isset($request->lang)){
			$lang = 'id';
		}
		if(!in_array($request->lang, $langAv)){
			$lang = 'id';
		} else {
			$lang = $request->lang;
		}
		
		$request->session()->put('locale', $lang);
		if(filter_var(urldecode($request->next), FILTER_VALIDATE_URL)){
			return redirect(urldecode($request->next));
		} else {
			return redirect('/');
		}
	}
	
}