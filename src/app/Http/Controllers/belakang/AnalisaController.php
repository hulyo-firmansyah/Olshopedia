<?php

namespace App\Http\Controllers\belakang;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\PusatController as Fungsi;

class AnalisaController extends Controller
{
    
	public function __construct(){
		$this->middleware(['b.auth', 'b.locale', 'xss_protect', 'b.ijin-melihatAnalisa', 'b.cekDataToko']);
    }
    
    public function bestProdukIndex(Request $request){
        $filter['dari'] = strip_tags($request->dari);
        $filter['sampai'] = strip_tags($request->sampai);
        $filter['by'] = strip_tags($request->by);
        $data_order = Cache::remember('data_order_lengkap_'.Fungsi::dataOfCek(), 10000, function(){
            return DB::table('t_order')
                ->where('data_of', Fungsi::dataOfCek())
                ->where('canceled', 0)
                ->get();
        });
        $data = $this->hitungBestProdukLengkap($data_order, $filter);
        // dd($data);
        if($request->ajax()){
            return Fungsi::respon('belakang.analisa.best-produk', compact('data', 'filter'), "ajax", $request);
        }
        return Fungsi::respon('belakang.analisa.best-produk', compact('data', 'filter'), "html", $request);
    }

    private function hitungBestProdukLengkap(&$data_src, &$filter){
        if(($filter['dari'] != '' && $filter['sampai'] != '') && (strtotime($filter['dari']) <= strtotime($filter['sampai']))){
            $cekTanggal = true;
        } else {
            $cekTanggal = false;
        }
        $temp_hasil = $data_hasil = [];
        // $testData = Fungsi::hitungHargaJual($data_src[0]);
        // echo "<pre>".print_r($testData, true)."</pre>";
        // dd($data_src);
        foreach(Fungsi::genArray($data_src) as $iO => $vO){
            if($vO->state == "terima"){
                $net_sales = Fungsi::hitungHargaJual($vO);
                // echo "<pre>".print_r($net_sales, true)."</pre>";
                if($cekTanggal){
                    $t_tglDari = strtotime($filter['dari']);
                    $t_tglSampai = strtotime($filter['sampai']);
                    $t_tglOrder = strtotime($vO->tanggal_order);
                    if($t_tglOrder >= $t_tglDari && $t_tglOrder <= $t_tglSampai){
                        $produk = json_decode($vO->produk);
                        foreach(Fungsi::genArray($produk->list) as $iP => $vP){
                            $varian = $vP->rawData;
                            if($filter["by"] == "sku" || $filter["by"] == ""){
                                if(isset($temp_hasil[$varian->id_varian])){
                                    $temp_hasil[$varian->id_varian]['jumlah']++;
                                    $temp_hasil[$varian->id_varian]['data']->net_sales += $net_sales[$varian->id_varian];
                                } else {
                                    $temp_hasil[$varian->id_varian]['jumlah'] = 1;
                                    $temp_hasil[$varian->id_varian]['data'] = new \stdclass();
                                    $temp_hasil[$varian->id_varian]['data']->nama_produk = ucwords(strtolower($varian->nama_produk));
                                    $temp_hasil[$varian->id_varian]['data']->sku = $varian->sku;
                                    $temp_hasil[$varian->id_varian]['data']->net_sales = $net_sales[$varian->id_varian];
                                    $temp_hasil[$varian->id_varian]['order'] = "sku";
                                    if(is_null($varian->foto_id)){
                                        $temp_hasil[$varian->id_varian]['data']->foto = asset("photo.png");
                                    } else {
                                        $data_foto = json_decode($varian->foto_id);
                                        if(is_null($data_foto)){
                                            $temp_hasil[$varian->id_varian]['data']->foto = asset("photo.png");
                                        } else {
                                            $fotoCek = DB::table('t_foto')->where('id_foto', $data_foto->utama)->where('data_of', Fungsi::dataOfCek())->get()->first();
                                            if(isset($fotoCek)){
                                                $temp_hasil[$varian->id_varian]['data']->foto = asset($fotoCek->path);
                                            } else {
                                                $temp_hasil[$varian->id_varian]['data']->foto = asset("photo.png");
                                            }
                                        }
                                    }
                                }
                            } else if($filter["by"] == "produk"){
                                if(isset($temp_hasil[$varian->produk_id])){
                                    $temp_hasil[$varian->produk_id]['jumlah']++;
                                    if(isset($temp_hasil[$varian->produk_id]['data']['varian'][$varian->id_varian])){
                                        $temp_hasil[$varian->produk_id]['data']['varian'][$varian->id_varian]['jumlah']++;
                                        $temp_hasil[$varian->produk_id]['data']['varian'][$varian->id_varian]['net_sales'] += $net_sales[$varian->id_varian];
                                    } else {
                                        $temp_hasil[$varian->produk_id]['data']['varian'][$varian->id_varian]['jumlah'] = 1;
                                        $temp_hasil[$varian->produk_id]['data']['varian'][$varian->id_varian]['ukuran'] = $varian->ukuran;
                                        $temp_hasil[$varian->produk_id]['data']['varian'][$varian->id_varian]['warna'] = $varian->warna;
                                        $temp_hasil[$varian->produk_id]['data']['varian'][$varian->id_varian]['net_sales'] = $net_sales[$varian->id_varian];
                                    }
                                } else {
                                    $temp_hasil[$varian->produk_id]['jumlah'] = 1;
                                    $temp_hasil[$varian->produk_id]['data']['nama_produk'] = ucwords(strtolower($varian->nama_produk));
                                    $temp_hasil[$varian->produk_id]['data']['varian'][$varian->id_varian]['jumlah'] = 1;
                                    $temp_hasil[$varian->produk_id]['data']['varian'][$varian->id_varian]['ukuran'] = $varian->ukuran;
                                    $temp_hasil[$varian->produk_id]['data']['varian'][$varian->id_varian]['warna'] = $varian->warna;
                                    $temp_hasil[$varian->produk_id]['data']['varian'][$varian->id_varian]['net_sales'] = $net_sales[$varian->id_varian];
                                    $temp_hasil[$varian->produk_id]['order'] = "produk";
                                    if(is_null($varian->foto_id)){
                                        $temp_hasil[$varian->produk_id]['data']['foto'] = asset("photo.png");
                                    } else {
                                        $data_foto = json_decode($varian->foto_id);
                                        if(is_null($data_foto)){
                                            $temp_hasil[$varian->produk_id]['data']['foto'] = asset("photo.png");
                                        } else {
                                            $fotoCek = DB::table('t_foto')->where('id_foto', $data_foto->utama)->where('data_of', Fungsi::dataOfCek())->get()->first();
                                            if(isset($fotoCek)){
                                                $temp_hasil[$varian->produk_id]['data']['foto'] = asset($fotoCek->path);
                                            } else {
                                                $temp_hasil[$varian->produk_id]['data']['foto'] = asset("photo.png");
                                            }
                                        }
                                    }
                                }
                            } else if($filter["by"] == "kategori_produk"){
                                $cekKat = DB::table('t_produk')
                                    ->join('t_kategori_produk', 't_kategori_produk.id_kategori_produk', '=', 't_produk.kategori_produk_id')
                                    ->select('t_kategori_produk.id_kategori_produk', 't_kategori_produk.nama_kategori_produk')
                                    ->where('t_produk.data_of', Fungsi::dataOfCek())
                                    ->where('t_produk.id_produk', $varian->produk_id)
                                    ->get()->first();
                                if(isset($cekKat)){
                                    if(isset($temp_hasil[$cekKat->id_kategori_produk])){
                                        $temp_hasil[$cekKat->id_kategori_produk]['jumlah']++;
                                        $temp_hasil[$cekKat->id_kategori_produk]['data']->net_sales += $net_sales[$varian->id_varian];
                                    } else {
                                        $temp_hasil[$cekKat->id_kategori_produk]['jumlah'] = 1;
                                        $temp_hasil[$cekKat->id_kategori_produk]['data'] = new \stdclass();
                                        $temp_hasil[$cekKat->id_kategori_produk]['data']->nama = $cekKat->nama_kategori_produk;
                                        $temp_hasil[$cekKat->id_kategori_produk]['data']->net_sales = $net_sales[$varian->id_varian];
                                        $temp_hasil[$cekKat->id_kategori_produk]['order'] = "kategori_produk";
                                    }
                                } else {
                                    if(isset($temp_hasil["kosong"])){
                                        $temp_hasil["kosong"]['jumlah']++;
                                        $temp_hasil["kosong"]['data']->net_sales += $net_sales[$varian->id_varian];
                                    } else {
                                        $temp_hasil["kosong"]['jumlah'] = 1;
                                        $temp_hasil["kosong"]['data'] = new \stdclass();
                                        $temp_hasil["kosong"]['data']->nama = "Tidak Berkategori";
                                        $temp_hasil["kosong"]['data']->net_sales = $net_sales[$varian->id_varian];
                                        $temp_hasil["kosong"]['order'] = "kategori_produk";
                                    }
                                }
                            }
                        }
                    }
                } else {
                    $produk = json_decode($vO->produk);
                    foreach(Fungsi::genArray($produk->list) as $iP => $vP){
                        $varian = $vP->rawData;
                        if($filter["by"] == "sku" || $filter["by"] == ""){
                            if(isset($temp_hasil[$varian->id_varian])){
                                $temp_hasil[$varian->id_varian]['jumlah']++;
                                $temp_hasil[$varian->id_varian]['data']->net_sales += $net_sales[$varian->id_varian];
                            } else {
                                $temp_hasil[$varian->id_varian]['jumlah'] = 1;
                                $temp_hasil[$varian->id_varian]['data'] = new \stdclass();
                                $temp_hasil[$varian->id_varian]['data']->nama_produk = ucwords(strtolower($varian->nama_produk));
                                $temp_hasil[$varian->id_varian]['data']->sku = $varian->sku;
                                $temp_hasil[$varian->id_varian]['data']->net_sales = $net_sales[$varian->id_varian];
                                $temp_hasil[$varian->id_varian]['order'] = "sku";
                                if(is_null($varian->foto_id)){
                                    $temp_hasil[$varian->id_varian]['data']->foto = asset("photo.png");
                                } else {
                                    $data_foto = json_decode($varian->foto_id);
                                    if(is_null($data_foto)){
                                        $temp_hasil[$varian->id_varian]['data']->foto = asset("photo.png");
                                    } else {
                                        $fotoCek = DB::table('t_foto')->where('id_foto', $data_foto->utama)->where('data_of', Fungsi::dataOfCek())->get()->first();
                                        if(isset($fotoCek)){
                                            $temp_hasil[$varian->id_varian]['data']->foto = asset($fotoCek->path);
                                        } else {
                                            $temp_hasil[$varian->id_varian]['data']->foto = asset("photo.png");
                                        }
                                    }
                                }
                            }
                        } else if($filter["by"] == "produk"){
                            if(isset($temp_hasil[$varian->produk_id])){
                                $temp_hasil[$varian->produk_id]['jumlah']++;
                                if(isset($temp_hasil[$varian->produk_id]['data']['varian'][$varian->id_varian])){
                                    $temp_hasil[$varian->produk_id]['data']['varian'][$varian->id_varian]['jumlah']++;
                                    $temp_hasil[$varian->produk_id]['data']['varian'][$varian->id_varian]['net_sales'] += $net_sales[$varian->id_varian];
                                } else {
                                    $temp_hasil[$varian->produk_id]['data']['varian'][$varian->id_varian]['jumlah'] = 1;
                                    $temp_hasil[$varian->produk_id]['data']['varian'][$varian->id_varian]['ukuran'] = $varian->ukuran;
                                    $temp_hasil[$varian->produk_id]['data']['varian'][$varian->id_varian]['warna'] = $varian->warna;
                                    $temp_hasil[$varian->produk_id]['data']['varian'][$varian->id_varian]['net_sales'] = $net_sales[$varian->id_varian];
                                }
                            } else {
                                $temp_hasil[$varian->produk_id]['jumlah'] = 1;
                                $temp_hasil[$varian->produk_id]['data']['nama_produk'] = ucwords(strtolower($varian->nama_produk));
                                $temp_hasil[$varian->produk_id]['data']['varian'][$varian->id_varian]['jumlah'] = 1;
                                $temp_hasil[$varian->produk_id]['data']['varian'][$varian->id_varian]['ukuran'] = $varian->ukuran;
                                $temp_hasil[$varian->produk_id]['data']['varian'][$varian->id_varian]['warna'] = $varian->warna;
                                $temp_hasil[$varian->produk_id]['data']['varian'][$varian->id_varian]['net_sales'] = $net_sales[$varian->id_varian];
                                $temp_hasil[$varian->produk_id]['order'] = "produk";
                                if(is_null($varian->foto_id)){
                                    $temp_hasil[$varian->produk_id]['data']['foto'] = asset("photo.png");
                                } else {
                                    $data_foto = json_decode($varian->foto_id);
                                    if(is_null($data_foto)){
                                        $temp_hasil[$varian->produk_id]['data']['foto'] = asset("photo.png");
                                    } else {
                                        $fotoCek = DB::table('t_foto')->where('id_foto', $data_foto->utama)->where('data_of', Fungsi::dataOfCek())->get()->first();
                                        if(isset($fotoCek)){
                                            $temp_hasil[$varian->produk_id]['data']['foto'] = asset($fotoCek->path);
                                        } else {
                                            $temp_hasil[$varian->produk_id]['data']['foto'] = asset("photo.png");
                                        }
                                    }
                                }
                            }
                        } else if($filter["by"] == "kategori_produk"){
                            $cekKat = DB::table('t_produk')
                                ->join('t_kategori_produk', 't_kategori_produk.id_kategori_produk', '=', 't_produk.kategori_produk_id')
                                ->select('t_kategori_produk.id_kategori_produk', 't_kategori_produk.nama_kategori_produk')
                                ->where('t_produk.data_of', Fungsi::dataOfCek())
                                ->where('t_produk.id_produk', $varian->produk_id)
                                ->get()->first();
                            if(isset($cekKat)){
                                if(isset($temp_hasil[$cekKat->id_kategori_produk])){
                                    $temp_hasil[$cekKat->id_kategori_produk]['jumlah']++;
                                    $temp_hasil[$cekKat->id_kategori_produk]['data']->net_sales += $net_sales[$varian->id_varian];
                                } else {
                                    $temp_hasil[$cekKat->id_kategori_produk]['jumlah'] = 1;
                                    $temp_hasil[$cekKat->id_kategori_produk]['data'] = new \stdclass();
                                    $temp_hasil[$cekKat->id_kategori_produk]['data']->nama = $cekKat->nama_kategori_produk;
                                    $temp_hasil[$cekKat->id_kategori_produk]['data']->net_sales = $net_sales[$varian->id_varian];
                                    $temp_hasil[$cekKat->id_kategori_produk]['order'] = "kategori_produk";
                                }
                            } else {
                                if(isset($temp_hasil["kosong"])){
                                    $temp_hasil["kosong"]['jumlah']++;
                                    $temp_hasil["kosong"]['data']->net_sales += $net_sales[$varian->id_varian];
                                } else {
                                    $temp_hasil["kosong"]['jumlah'] = 1;
                                    $temp_hasil["kosong"]['data'] = new \stdclass();
                                    $temp_hasil["kosong"]['data']->nama = "Tidak Berkategori";
                                    $temp_hasil["kosong"]['data']->net_sales = $net_sales[$varian->id_varian];
                                    $temp_hasil["kosong"]['order'] = "kategori_produk";
                                }
                            }
                        }
                    }
                }
            }
        }
        foreach(Fungsi::genArray($temp_hasil) as $iH => $vH){
            if($filter["by"] == "sku" || $filter["by"] == "" || $filter["by"] == "kategori_produk"){
                $data_hasil[] = $vH;
            } else if($filter["by"] == "produk"){
                $temp__ = $vH;
                $temp__['data']["varian"] = [];
                foreach(Fungsi::genArray($vH['data']["varian"]) as $iV => $vV){
                    $temp__['data']["varian"][] = $vV;
                }
                $data_hasil[] = $temp__;
            }
        }
        usort($data_hasil, function($a, $b){
            if ($a['jumlah'] == $b['jumlah']) {
                return 0;
            }
            return ($a['jumlah'] > $b['jumlah']) ? -1 : 1;
        });
        unset($temp_hasil);
        return $data_hasil;
    }

    public function customerLokasiIndex(Request $request){
        $tanggal['dari'] = strip_tags($request->dari);
        $tanggal['sampai'] = strip_tags($request->sampai);
        $data = $this->hitungCustomerLokasiLengkap($tanggal);
        // dd($data);
        if($request->ajax()){
            return Fungsi::respon('belakang.analisa.customer-lokasi', compact('data', 'tanggal'), "ajax", $request);
        }
        return Fungsi::respon('belakang.analisa.customer-lokasi', compact('data', 'tanggal'), "html", $request);
    }

    private function hitungCustomerLokasiLengkap(&$tanggal){
        $data_order = Cache::remember('data_order_lengkap_'.Fungsi::dataOfCek(), 10000, function(){
            return DB::table('t_order')
                ->where('data_of', Fungsi::dataOfCek())
                ->where('canceled', 0)
                ->get();
        });
        $data_customer = Cache::remember('data_customer_analisa_'.Fungsi::dataOfCek(), 10000, function(){
            return DB::table('t_customer')
                ->join('users', 't_customer.user_id', '=', 'users.id')
                ->select('t_customer.kategori', 'users.name', 't_customer.kabupaten', 'users.id', 't_customer.provinsi')
                ->where('t_customer.data_of', Fungsi::dataOfCek())
                ->get();
        });
        return $this->hitungLokasiCustomer($data_order, $data_customer, $tanggal, null);
    }

    public function bestCustomerIndex(Request $request){
        list($data_user, $ijin) = $this->getIjinUser();
        $filter['tanggal_dari'] = strip_tags($request->dari);
        $filter['tanggal_sampai'] = strip_tags($request->sampai);
        $filter['tampil'] = strip_tags($request->tampil);
        $filter['tipe'] = strip_tags($request->tipe);
        if(!in_array($filter['tampil'], ['jumlah_order', 'jumlah_produk', 'gross_sales', 'net_sales'])){
            $filter['tampil'] = 'jumlah_order';
        }
        if(!(($ijin->melihatOmset === 1 && $data_user->role == 'Admin') || $data_user->role == 'Owner')){
            if($filter['tampil'] == 'net_sales'){
                $filter['tampil'] = 'jumlah_order';
            }
        }
        // dd($filter);
        $data_order = Cache::remember('data_order_lengkap_'.Fungsi::dataOfCek(), 10000, function(){
            return DB::table('t_order')
                ->where('data_of', Fungsi::dataOfCek())
                ->where('canceled', 0)
                ->get();
        });
        $data_customer = Cache::remember('data_customer_analisa_'.Fungsi::dataOfCek(), 10000, function(){
            return DB::table('t_customer')
                ->join('users', 't_customer.user_id', '=', 'users.id')
                ->select('t_customer.kategori', 'users.name', 't_customer.kabupaten', 'users.id', 't_customer.provinsi')
                ->where('t_customer.data_of', Fungsi::dataOfCek())
                ->get();
        });
        $data['list_best_customer'] = $this->hitungBestCustomerLengkap($data_order, $data_customer, $filter);
        $data['chart_best_customer'] = $this->hitungBestCustomerLengkapChart($data_order, $data_customer, $filter);
        // dd($data);
        if($request->ajax()){
            return Fungsi::respon('belakang.analisa.best-customer', compact('data', 'filter', 'data_user', 'ijin'), "ajax", $request);
        }
        return Fungsi::respon('belakang.analisa.best-customer', compact('data', 'filter', 'data_user', 'ijin'), "html", $request);
    }

    private function hitungBestCustomerLengkap(&$data_src, &$data_customer, $filter){
        if(($filter['tanggal_dari'] != '' && $filter['tanggal_sampai'] != '') && (strtotime($filter['tanggal_dari']) <= strtotime($filter['tanggal_sampai']))){
            $cekTanggal = true;
        } else {
            $cekTanggal = false;
        }
        // dd($data_src);
        $temp_hasil = $data_hasil = $hasil = []; 
        foreach(Fungsi::genArray($data_src) as $iO => $vO){
            if($vO->state == 'terima'){
                if($cekTanggal){
                    $t_tglDari = strtotime($filter['tanggal_dari']);
                    $t_tglSampai = strtotime($filter['tanggal_sampai']);
                    $t_tglOrder = strtotime($vO->tanggal_order);
                    if($t_tglOrder >= $t_tglDari && $t_tglOrder <= $t_tglSampai){
                        $genCust = Fungsi::genArray($data_customer);
                        foreach($genCust as $iC => $vC){
                            if($vO->pemesan_id === $vC->id){
                                if($filter['tipe'] == "0" || $filter['tipe'] == $vC->kategori || $filter['tipe'] == ""){
                                    if(isset($temp_hasil[$vC->id])){
                                        if($filter['tampil'] == "jumlah_order" || $filter['tampil'] == ""){
                                            $temp_hasil[$vC->id]['jumlah']++;
                                        } else if($filter['tampil'] == "jumlah_produk" || $filter['tampil'] == ""){
                                            $produk = json_decode($vO->produk)->list;
                                            $total_temp_prod = 0;
                                            foreach(Fungsi::genArray($produk) as $iP => $vP){
                                                $total_temp_prod += $vP->jumlah;
                                            }
                                            $temp_hasil[$vC->id]['jumlah'] += $total_temp_prod;
                                        } else if($filter['tampil'] == "gross_sales" || $filter['tampil'] == ""){
                                            $total_data = json_decode($vO->total);
                                            $total_temp = $total_data->hargaProduk + $total_data->hargaOngkir;
                                            if(!is_null($total_data->biayaLain)){
                                                foreach(Fungsi::genArray($total_data->biayaLain) as $iB => $vB){
                                                    $total_temp += $vB->harga;
                                                }
                                            }
                                            if(!is_null($total_data->diskonOrder)){
                                                foreach(Fungsi::genArray($total_data->diskonOrder) as $iD => $vD){
                                                    $total_temp -= $vD->harga;
                                                }
                                            }
                                            $temp_hasil[$vC->id]['jumlah'] += $total_temp;
                                        } else if($filter['tampil'] == "net_sales" || $filter['tampil'] == ""){
                                            $total_data = json_decode($vO->total);
                                            $total_tt = $total_data->hargaProduk;
                                            if(!is_null($total_data->diskonOrder)){
                                                foreach(Fungsi::genArray($total_data->diskonOrder) as $iD => $vD){
                                                    $total_tt -= $vD->harga;
                                                }
                                            }
                                            $temp_hasil[$vC->id]['jumlah'] += $total_tt;
                                        }
                                    } else {
                                        if($filter['tampil'] == "jumlah_order" || $filter['tampil'] == ""){
                                            $temp_hasil[$vC->id] = [
                                                'data' => $vC,
                                                'jumlah' => 1
                                            ];
                                        } else if($filter['tampil'] == "jumlah_produk" || $filter['tampil'] == ""){
                                            $produk = json_decode($vO->produk)->list;
                                            $total_temp_prod = 0;
                                            foreach(Fungsi::genArray($produk) as $iP => $vP){
                                                $total_temp_prod += $vP->jumlah;
                                            }
                                            $temp_hasil[$vC->id] = [
                                                'data' => $vC,
                                                'jumlah' => $total_temp_prod
                                            ];
                                        } else if($filter['tampil'] == "gross_sales" || $filter['tampil'] == ""){
                                            $total_data = json_decode($vO->total);
                                            $total_temp = $total_data->hargaProduk + $total_data->hargaOngkir;
                                            if(!is_null($total_data->biayaLain)){
                                                foreach(Fungsi::genArray($total_data->biayaLain) as $iB => $vB){
                                                    $total_temp += $vB->harga;
                                                }
                                            }
                                            if(!is_null($total_data->diskonOrder)){
                                                foreach(Fungsi::genArray($total_data->diskonOrder) as $iD => $vD){
                                                    $total_temp -= $vD->harga;
                                                }
                                            }
                                            $temp_hasil[$vC->id] = [
                                                'data' => $vC,
                                                'jumlah' => $total_temp
                                            ];
                                        } else if($filter['tampil'] == "net_sales" || $filter['tampil'] == ""){
                                            $total_data = json_decode($vO->total);
                                            $total_tt = $total_data->hargaProduk;
                                            if(!is_null($total_data->diskonOrder)){
                                                foreach(Fungsi::genArray($total_data->diskonOrder) as $iD => $vD){
                                                    $total_tt -= $vD->harga;
                                                }
                                            }
                                            $temp_hasil[$vC->id] = [
                                                'data' => $vC,
                                                'jumlah' => $total_tt
                                            ];
                                        }
                                    }
                                }
                                $genCust->send('stop');
                            }
                        }
                    }
                } else {
                    $genCust = Fungsi::genArray($data_customer);
                    foreach($genCust as $iC => $vC){
                        if($vO->pemesan_id === $vC->id){
                            if($filter['tipe'] == "0" || $filter['tipe'] == $vC->kategori || $filter['tipe'] == ""){
                                if(isset($temp_hasil[$vC->id])){
                                    if($filter['tampil'] == "jumlah_order" || $filter['tampil'] == ""){
                                        $temp_hasil[$vC->id]['jumlah']++;
                                    } else if($filter['tampil'] == "jumlah_produk" || $filter['tampil'] == ""){
                                        $produk = json_decode($vO->produk)->list;
                                        $total_temp_prod = 0;
                                        foreach(Fungsi::genArray($produk) as $iP => $vP){
                                            $total_temp_prod += $vP->jumlah;
                                        }
                                        $temp_hasil[$vC->id]['jumlah'] += $total_temp_prod;
                                    } else if($filter['tampil'] == "gross_sales" || $filter['tampil'] == ""){
                                        $total_data = json_decode($vO->total);
                                        $total_temp = $total_data->hargaProduk + $total_data->hargaOngkir;
                                        if(!is_null($total_data->biayaLain)){
                                            foreach(Fungsi::genArray($total_data->biayaLain) as $iB => $vB){
                                                $total_temp += $vB->harga;
                                            }
                                        }
                                        if(!is_null($total_data->diskonOrder)){
                                            foreach(Fungsi::genArray($total_data->diskonOrder) as $iD => $vD){
                                                $total_temp -= $vD->harga;
                                            }
                                        }
                                        $temp_hasil[$vC->id]['jumlah'] += $total_temp;
                                    } else if($filter['tampil'] == "net_sales" || $filter['tampil'] == ""){
                                        $total_data = json_decode($vO->total);
                                        $total_tt = $total_data->hargaProduk;
                                        if(!is_null($total_data->diskonOrder)){
                                            foreach(Fungsi::genArray($total_data->diskonOrder) as $iD => $vD){
                                                $total_tt -= $vD->harga;
                                            }
                                        }
                                        $temp_hasil[$vC->id]['jumlah'] += $total_tt;
                                    }
                                } else {
                                    if($filter['tampil'] == "jumlah_order" || $filter['tampil'] == ""){
                                        $temp_hasil[$vC->id] = [
                                            'data' => $vC,
                                            'jumlah' => 1
                                        ];
                                    } else if($filter['tampil'] == "jumlah_produk" || $filter['tampil'] == ""){
                                        $produk = json_decode($vO->produk)->list;
                                        $total_temp_prod = 0;
                                        foreach(Fungsi::genArray($produk) as $iP => $vP){
                                            $total_temp_prod += $vP->jumlah;
                                        }
                                        $temp_hasil[$vC->id] = [
                                            'data' => $vC,
                                            'jumlah' => $total_temp_prod
                                        ];
                                    } else if($filter['tampil'] == "gross_sales" || $filter['tampil'] == ""){
                                        $total_data = json_decode($vO->total);
                                        $total_temp = $total_data->hargaProduk + $total_data->hargaOngkir;
                                        if(!is_null($total_data->biayaLain)){
                                            foreach(Fungsi::genArray($total_data->biayaLain) as $iB => $vB){
                                                $total_temp += $vB->harga;
                                            }
                                        }
                                        if(!is_null($total_data->diskonOrder)){
                                            foreach(Fungsi::genArray($total_data->diskonOrder) as $iD => $vD){
                                                $total_temp -= $vD->harga;
                                            }
                                        }
                                        $temp_hasil[$vC->id] = [
                                            'data' => $vC,
                                            'jumlah' => $total_temp
                                        ];
                                    } else if($filter['tampil'] == "net_sales" || $filter['tampil'] == ""){
                                        $total_data = json_decode($vO->total);
                                        $total_tt = $total_data->hargaProduk;
                                        if(!is_null($total_data->diskonOrder)){
                                            foreach(Fungsi::genArray($total_data->diskonOrder) as $iD => $vD){
                                                $total_tt -= $vD->harga;
                                            }
                                        }
                                        $temp_hasil[$vC->id] = [
                                            'data' => $vC,
                                            'jumlah' => $total_tt
                                        ];
                                    }
                                }
                            }
                            $genCust->send('stop');
                        }
                    }
                }
            }
        }
        foreach(Fungsi::genArray($temp_hasil) as $iH => $vH){
            $data_hasil[] = $vH;
        }
        unset($temp_hasil);
        usort($data_hasil, function($a, $b){
            if ($a['jumlah'] == $b['jumlah']) {
                return 0;
            }
            return ($a['jumlah'] > $b['jumlah']) ? -1 : 1;
        });
        $i_ = 0;
        foreach(Fungsi::genArray($data_hasil) as $iH => $vH){
            $i_temp = 0;
            $i_cek = false;
            $t_ = $vH;
            $t_['data'] = new \stdclass();
            $t_['data']->kabupaten = $vH['data']->kabupaten;
            $t_['data']->name = ucwords(strtolower($vH['data']->name));
            $t_['data']->provinsi = $vH['data']->provinsi;
            $t_['data']->kategori = $vH['data']->kategori;
            if($i_ <= 4){
                $t_['star'] = '';
                foreach(Fungsi::genArrayFor($i_, 4) as $_i){
                    if(!$i_cek){
                        $i_temp = $_i;
                        $i_cek = true;
                    }
                    $t_['star'] .= '<i class="icon wb-star orange-500"></i>';
                }
                for($t_i=0; $t_i<$i_temp; $t_i++){
                    $t_['star'] .= '<i class="icon wb-star grey-400"></i>';
                }
                $t_['star'] .= '<br>';
            } else {
                $t_['star'] = '';
                foreach(Fungsi::genArrayFor(0, 4) as $_i){
                    $t_['star'] .= '<i class="icon wb-star grey-400"></i>';
                }
                $t_['star'] .= '<br>';
            }
            $hasil[] = $t_;
            $i_++;
        }
        unset($data_hasil);
        return $hasil;
    }

    private function hitungBestCustomerLengkapChart(&$data_src, &$data_customer, &$filter){
        $list_tipe = $list_data = $hasil = $data_hasil = $list_warna = [];
        $temp_total = 0;
        if(($filter['tanggal_dari'] != '' && $filter['tanggal_sampai'] != '') && (strtotime($filter['tanggal_dari']) <= strtotime($filter['tanggal_sampai']))){
            $cekTanggal = true;
        } else {
            $cekTanggal = false;
        }
        foreach(Fungsi::genArray($data_src) as $iO => $vO){
            if($vO->state == "terima"){
                if($cekTanggal){
                    $t_tglDari = strtotime($filter['tanggal_dari']);
                    $t_tglSampai = strtotime($filter['tanggal_sampai']);
                    $t_tglOrder = strtotime($vO->tanggal_order);
                    if($t_tglOrder >= $t_tglDari && $t_tglOrder <= $t_tglSampai){
                        $genCust = Fungsi::genArray($data_customer);
                        foreach($genCust as $iC => $vC){
                            if($vO->pemesan_id === $vC->id){
                                if(in_array($vC->kategori, $list_tipe) && isset($list_data[$vC->kategori])){
                                    if($filter['tipe'] == "0" || $filter['tipe'] == $vC->kategori || $filter['tipe'] == ""){
                                        $list_data[$vC->kategori]['jumlah']++;
                                    }
                                } else {
                                    if($vC->kategori == "Dropshipper" && ($filter['tipe'] == "0" || $filter['tipe'] == "Dropshipper" || $filter['tipe'] == "")){
                                        $list_warna[] = 'rgb(11, 178, 212)';
                                    } else if($vC->kategori == "Reseller" && ($filter['tipe'] == "0" || $filter['tipe'] == "Reseller" || $filter['tipe'] == "")){
                                        $list_warna[] = 'rgb(17, 194, 109)';
                                    } else if($vC->kategori == "Customer" && ($filter['tipe'] == "0" || $filter['tipe'] == "Customer" || $filter['tipe'] == "")){
                                        $list_warna[] = 'rgb(255, 99, 132)';
                                    }
                                    if($filter['tipe'] == "0" || $filter['tipe'] == $vC->kategori || $filter['tipe'] == ""){
                                        $list_tipe[] = $vC->kategori;
                                        $list_data[$vC->kategori] = [
                                            'jumlah' => 1
                                        ];
                                    }
                                }
                                if($filter['tipe'] == "0" || $filter['tipe'] == $vC->kategori || $filter['tipe'] == ""){
                                    $temp_total++;
                                }
                                $genCust->send('stop');
                            }
                        }
                    }
                } else {
                    $genCust = Fungsi::genArray($data_customer);
                    foreach($genCust as $iC => $vC){
                        if($vO->pemesan_id === $vC->id){
                            if(in_array($vC->kategori, $list_tipe) && isset($list_data[$vC->kategori])){
                                if($filter['tipe'] == "0" || $filter['tipe'] == $vC->kategori || $filter['tipe'] == ""){
                                    $list_data[$vC->kategori]['jumlah']++;
                                }
                            } else {
                                if($vC->kategori == "Dropshipper" && ($filter['tipe'] == "0" || $filter['tipe'] == "Dropshipper" || $filter['tipe'] == "")){
                                    $list_warna[] = 'rgb(11, 178, 212)';
                                } else if($vC->kategori == "Reseller" && ($filter['tipe'] == "0" || $filter['tipe'] == "Reseller" || $filter['tipe'] == "")){
                                    $list_warna[] = 'rgb(17, 194, 109)';
                                } else if($vC->kategori == "Customer" && ($filter['tipe'] == "0" || $filter['tipe'] == "Customer" || $filter['tipe'] == "")){
                                    $list_warna[] = 'rgb(255, 99, 132)';
                                }
                                if($filter['tipe'] == "0" || $filter['tipe'] == $vC->kategori || $filter['tipe'] == ""){
                                    $list_tipe[] = $vC->kategori;
                                    $list_data[$vC->kategori] = [
                                        'jumlah' => 1
                                    ];
                                }
                            }
                            if($filter['tipe'] == "0" || $filter['tipe'] == $vC->kategori || $filter['tipe'] == ""){
                                $temp_total++;
                            }
                            $genCust->send('stop');
                        }
                    }
                }
            }
        }
        foreach(Fungsi::genArray($list_data) as $iH => $vH){
            $data_hasil[] = $vH['jumlah'];
        }
        return [
            'label' => json_encode($list_tipe),
            'warna' => json_encode($list_warna),
            'data' => json_encode($data_hasil)
        ];
    }

    public function analisaIndex(Request $request){
        $tanggal['dari'] = strip_tags($request->dari);
        $tanggal['sampai'] = strip_tags($request->sampai);
        $data_order = Cache::remember('data_order_lengkap_'.Fungsi::dataOfCek(), 10000, function(){
            return DB::table('t_order')
                ->where('data_of', Fungsi::dataOfCek())
                ->where('canceled', 0)
                ->get();
        });
        $data_customer = Cache::remember('data_customer_analisa_'.Fungsi::dataOfCek(), 10000, function(){
            return DB::table('t_customer')
                ->join('users', 't_customer.user_id', '=', 'users.id')
                ->select('t_customer.kategori', 'users.name', 't_customer.kabupaten', 'users.id', 't_customer.provinsi')
                ->where('t_customer.data_of', Fungsi::dataOfCek())
                ->get();
        });
        $data['lokasi_customer'] = $this->hitungLokasiCustomer($data_order, $data_customer, $tanggal);
        $data['best_customer'] = $this->hitungBestCustomer($data_order, $data_customer, $tanggal);
        $data['best_penjualan_produk'] = $this->hitungBestPenjualanProduk($data_order, $tanggal);
		$data['chart_lengkap'] = $this->hitungChartLengkap($data_order, $tanggal);
        if($request->ajax()){
            return Fungsi::respon('belakang.analisa.index', compact('data', 'tanggal'), "ajax", $request);
        }
        return Fungsi::respon('belakang.analisa.index', compact('data', 'tanggal'), "html", $request);
    }

	private function hitungChartLengkap(&$order_data, &$tanggal){
		$data_hasil_order = $data_hasil_produk = $list_tgl = [];
		$temp_order = $temp_produk = 0;
        if(($tanggal['dari'] != '' && $tanggal['sampai'] != '') && (strtotime($tanggal['dari']) <= strtotime($tanggal['sampai']))){
            $dari = strtotime($tanggal['dari']);
            $sampai = strtotime($tanggal['sampai']);
            foreach(Fungsi::genArrayFor($dari, $sampai, 86400) as $i){
                $list_tgl[] = date('j M Y', $i);
                foreach(Fungsi::genArray($order_data) as $iU => $vU){
                    $time = $i;
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
        } else {
            $today = (int)date('j', strtotime('today'));
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
        }
		$hasil['order']['data'] = json_encode($data_hasil_order);
		$hasil['produk']['data'] = json_encode($data_hasil_produk);
		$hasil['tgl'] = json_encode($list_tgl);
		return $hasil;
	}

    private function hitungLokasiCustomer(&$data_src, &$data_customer, &$tanggal, $batas = 5){
        if(($tanggal['dari'] != '' && $tanggal['sampai'] != '') && (strtotime($tanggal['dari']) <= strtotime($tanggal['sampai']))){
            $cekTanggal = true;
        } else {
            $cekTanggal = false;
        }
        $temp_hasil = $data_hasil = [];
        $temp_total = 0;
        // dd($data_src);
        foreach(Fungsi::genArray($data_src) as $iO => $vO){
            if($vO->state == "terima"){
                if($cekTanggal){
                    $t_tglDari = strtotime($tanggal['dari']);
                    $t_tglSampai = strtotime($tanggal['sampai']);
                    $t_tglOrder = strtotime($vO->tanggal_order);
                    if($t_tglOrder >= $t_tglDari && $t_tglOrder <= $t_tglSampai){
                        $genCust = Fungsi::genArray($data_customer);
                        foreach($genCust as $iC => $vC){
                            if($vO->tujuan_kirim_id === $vC->id){
                                $index = preg_replace("/[^0-9a-z]/", "", strtolower($vC->provinsi).strtolower($vC->kabupaten));
                                if(isset($temp_hasil[$index])){
                                    $temp_hasil[$index]['jumlah']++;
                                    $temp_hasil[$index]['data']->net_sales += json_decode($vO->total)->hargaProduk;
                                } else {
                                    $temp_hasil[$index] = [
                                        'data' => $vC,
                                        'jumlah' => 1
                                    ];
                                    $temp_hasil[$index]['data']->net_sales = json_decode($vO->total)->hargaProduk;
                                }
                                $temp_total++;
                                $genCust->send('stop');
                            }
                        }
                    }
                } else {
                    $genCust = Fungsi::genArray($data_customer);
                    foreach($genCust as $iC => $vC){
                        if($vO->tujuan_kirim_id === $vC->id){
                            $index = preg_replace("/[^0-9a-z]/", "", strtolower($vC->provinsi).strtolower($vC->kabupaten));
                            if(isset($temp_hasil[$index])){
                                $temp_hasil[$index]['jumlah']++;
                                $temp_hasil[$index]['data']->net_sales += json_decode($vO->total)->hargaProduk;
                            } else {
                                $temp_hasil[$index] = [
                                    'data' => $vC,
                                    'jumlah' => 1
                                ];
                                $temp_hasil[$index]['data']->net_sales = json_decode($vO->total)->hargaProduk;
                            }
                            $temp_total++;
                            $genCust->send('stop');
                        }
                    }
                }
            }
        }
        $aGen_temp_hasil = Fungsi::genArray($temp_hasil);
        foreach($aGen_temp_hasil as $iH => $vH){
            if((count($data_hasil) < $batas && !is_null($batas)) || is_null($batas)) {
                $persen = (((double)$vH['jumlah']) / ((double)$temp_total)) * 100;
                $hasil['data'] = new \stdclass();
                $hasil['data']->kabupaten = $vH['data']->kabupaten;
                $hasil['data']->provinsi = $vH['data']->provinsi;
                $hasil['data']->net_sales = $vH['data']->net_sales;
                $hasil['persen'] = round($persen, 2);
                $hasil['jumlah'] = $vH['jumlah'];
                $data_hasil[] = $hasil;
                if((count($data_hasil) == $batas && !is_null($batas))){
                    $aGen_temp_hasil->send('stop');
                }
            }
        }
        usort($data_hasil, function($a, $b){
            if ($a['jumlah'] == $b['jumlah']) {
                return 0;
            }
            return ($a['jumlah'] > $b['jumlah']) ? -1 : 1;
        });
        unset($temp_hasil);
        return $data_hasil;
    }

    private function hitungBestCustomer(&$data_src, &$data_customer, &$tanggal, $batas = 5){
        if(($tanggal['dari'] != '' && $tanggal['sampai'] != '') && (strtotime($tanggal['dari']) <= strtotime($tanggal['sampai']))){
            $cekTanggal = true;
        } else {
            $cekTanggal = false;
        }
        $temp_hasil = $data_hasil = []; 
        foreach(Fungsi::genArray($data_src) as $iO => $vO){
            if($vO->state == "terima"){
                if($cekTanggal){
                    $t_tglDari = strtotime($tanggal['dari']);
                    $t_tglSampai = strtotime($tanggal['sampai']);
                    $t_tglOrder = strtotime($vO->tanggal_order);
                    if($t_tglOrder >= $t_tglDari && $t_tglOrder <= $t_tglSampai){
                        $genCust = Fungsi::genArray($data_customer);
                        foreach($genCust as $iC => $vC){
                            if($vO->pemesan_id === $vC->id){
                                if(isset($temp_hasil[$vC->id])){
                                    $temp_hasil[$vC->id]['jumlah']++;
                                } else {
                                    $temp_hasil[$vC->id] = [
                                        'data' => $vC,
                                        'jumlah' => 1
                                    ];
                                }
                                $genCust->send('stop');
                            }
                        }
                    }
                } else {
                    $genCust = Fungsi::genArray($data_customer);
                    foreach($genCust as $iC => $vC){
                        if($vO->pemesan_id === $vC->id){
                            if(isset($temp_hasil[$vC->id])){
                                $temp_hasil[$vC->id]['jumlah']++;
                            } else {
                                $temp_hasil[$vC->id] = [
                                    'data' => $vC,
                                    'jumlah' => 1
                                ];
                            }
                            $genCust->send('stop');
                        }
                    }
                }
            }
        }
        foreach(Fungsi::genArray($temp_hasil) as $iH => $vH){
            if(count($data_hasil) < $batas) $data_hasil[] = $vH;
        }
        usort($data_hasil, function($a, $b){
            if ($a['jumlah'] == $b['jumlah']) {
                return 0;
            }
            return ($a['jumlah'] > $b['jumlah']) ? -1 : 1;
        });
        unset($temp_hasil);
        return $data_hasil;
    }

    private function hitungBestPenjualanProduk(&$data_src, &$tanggal, $batas = 5){
        if(($tanggal['dari'] != '' && $tanggal['sampai'] != '') && (strtotime($tanggal['dari']) <= strtotime($tanggal['sampai']))){
            $cekTanggal = true;
        } else {
            $cekTanggal = false;
        }
        $temp_hasil = $data_hasil = [];
        foreach(Fungsi::genArray($data_src) as $iO => $vO){
            if($vO->state == "terima"){
                if($cekTanggal){
                    $t_tglDari = strtotime($tanggal['dari']);
                    $t_tglSampai = strtotime($tanggal['sampai']);
                    $t_tglOrder = strtotime($vO->tanggal_order);
                    if($t_tglOrder >= $t_tglDari && $t_tglOrder <= $t_tglSampai){
                        $produk = json_decode($vO->produk);
                        foreach(Fungsi::genArray($produk->list) as $iP => $vP){
                            $varian = $vP->rawData;
                            if(isset($temp_hasil[$varian->id_varian])){
                                $temp_hasil[$varian->id_varian]['jumlah']++;
                            } else {
                                $temp_hasil[$varian->id_varian]['jumlah'] = 1;
                                $temp_hasil[$varian->id_varian]['data'] = new \stdclass();
                                $temp_hasil[$varian->id_varian]['data']->nama_produk = $varian->nama_produk;
                                if(is_null($varian->foto_id)){
                                    $temp_hasil[$varian->id_varian]['data']->foto = asset("photo.png");
                                } else {
                                    $data_foto = json_decode($varian->foto_id);
                                    if(is_null($data_foto)){
                                        $temp_hasil[$varian->id_varian]['data']->foto = asset("photo.png");
                                    } else {
                                        $fotoCek = DB::table('t_foto')->where('id_foto', $data_foto->utama)->where('data_of', Fungsi::dataOfCek())->get()->first();
                                        if(isset($fotoCek)){
                                            $temp_hasil[$varian->id_varian]['data']->foto = asset($fotoCek->path);
                                        } else {
                                            $temp_hasil[$varian->id_varian]['data']->foto = asset("photo.png");
                                        }
                                    }
                                }
                            }
                        }
                    }
                } else {
                    $produk = json_decode($vO->produk);
                    foreach(Fungsi::genArray($produk->list) as $iP => $vP){
                        $varian = $vP->rawData;
                        if(isset($temp_hasil[$varian->id_varian])){
                            $temp_hasil[$varian->id_varian]['jumlah']++;
                        } else {
                            $temp_hasil[$varian->id_varian]['jumlah'] = 1;
                            $temp_hasil[$varian->id_varian]['data'] = new \stdclass();
                            $temp_hasil[$varian->id_varian]['data']->nama_produk = $varian->nama_produk;
                            if(is_null($varian->foto_id)){
                                $temp_hasil[$varian->id_varian]['data']->foto = asset("photo.png");
                            } else {
                                $data_foto = json_decode($varian->foto_id);
                                if(is_null($data_foto)){
                                    $temp_hasil[$varian->id_varian]['data']->foto = asset("photo.png");
                                } else {
                                    $fotoCek = DB::table('t_foto')->where('id_foto', $data_foto->utama)->where('data_of', Fungsi::dataOfCek())->get()->first();
                                    if(isset($fotoCek)){
                                        $temp_hasil[$varian->id_varian]['data']->foto = asset($fotoCek->path);
                                    } else {
                                        $temp_hasil[$varian->id_varian]['data']->foto = asset("photo.png");
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        foreach(Fungsi::genArray($temp_hasil) as $iH => $vH){
            if(count($data_hasil) < $batas) $data_hasil[] = $vH;
        }
        usort($data_hasil, function($a, $b){
            if ($a['jumlah'] == $b['jumlah']) {
                return 0;
            }
            return ($a['jumlah'] > $b['jumlah']) ? -1 : 1;
        });
        unset($temp_hasil);
        return $data_hasil;
    }
    
    private function getIjinUser(){
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
        return [$data_user, $ijin];
    }

}