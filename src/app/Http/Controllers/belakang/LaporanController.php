<?php

namespace App\Http\Controllers\belakang;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\PusatController as Fungsi;

class LaporanController extends Controller
{
    
	public function __construct(){
        $this->middleware(['b.auth', 'b.locale', 'xss_protect', 'b.cekOwner', 'b.cekDataToko']);
	}

    public function laporanIndex(Request $request){
        $tanggal['dari'] = strip_tags($request->dari) == '' ? '1 '.date('F Y') : strip_tags($request->dari);
        $tanggal['sampai'] = strip_tags($request->sampai) == '' ? date('j F Y') : strip_tags($request->sampai);
        $data_order = Cache::remember('data_order_lengkap_'.Fungsi::dataOfCek(), 10000, function(){
            return DB::table('t_order')
                ->where('data_of', Fungsi::dataOfCek())
                ->where('canceled', 0)
                ->get();
        });
        $data_expense = Cache::remember('data_expense_lengkap_'.Fungsi::dataOfCek(), 10000, function(){
            return DB::table('t_expense')->where('data_of', Fungsi::dataOfCek())->get();
        });
        $data_transaksi = Cache::remember('data_transaksi_lengkap_'.Fungsi::dataOfCek(), 10000, function(){
            return DB::table('t_pembayaran')->where('data_of', Fungsi::dataOfCek())->get();
        });
        $index = str_replace(' ', '_', $tanggal['dari']).str_replace(' ', '_', $tanggal['sampai']);
        if(Cache::has('data_laporan_'.Fungsi::dataOfCek())){
            $data_cache = Cache::get('data_laporan_'.Fungsi::dataOfCek());
            if(isset($data_cache[$index])){
                $data = $data_cache[$index];
            } else {
                $data['chart_expedisi'] = $this->hitungChartExpedisi($data_order, $tanggal);
                $data['gross_sales'] = Fungsi::formatUang($this->hitungGrossSales($data_order, $data_transaksi, $tanggal), true);
                $data['unpaid_gross_sales'] = Fungsi::formatUang($this->hitungUnpaidGrossSales($data_order, $data_transaksi, $tanggal), true);
                $data['net_sales'] = Fungsi::formatUang($this->hitungNetSales($data_order, $data_transaksi, $tanggal), true);
                $data['gross_profit'] = Fungsi::formatUang($this->hitungGrossProfit($data_order, $data_transaksi, $tanggal), true);
                $data['total_harga_beli_produk'] = Fungsi::formatUang($this->hitungTotalHargaBeliProduk($data_order, $tanggal), true);
                $data['order_selesai'] = $this->hitungOrderSelesai($data_order, $tanggal);
                $data['produk_terjual'] = $this->hitungProdukTerjual($data_order, $tanggal);
                $data['expense'] = Fungsi::formatUang($this->hitungExpense($data_expense, $tanggal), true);
                $data['net_profit'] = Fungsi::formatUang($this->hitungNetProfit($data_order, $data_expense, $data_transaksi, $tanggal), true);
                $data['chart_untung'] = $this->hitungChartUntung($data_order, $data_transaksi, $tanggal);
                $data_cache[$index] = $data;
                Cache::put('data_laporan_'.Fungsi::dataOfCek(), $data_cache, 10000);
            }
        } else {
            $data['chart_expedisi'] = $this->hitungChartExpedisi($data_order, $tanggal);
            $data['gross_sales'] = Fungsi::formatUang($this->hitungGrossSales($data_order, $data_transaksi, $tanggal), true);
            $data['unpaid_gross_sales'] = Fungsi::formatUang($this->hitungUnpaidGrossSales($data_order, $data_transaksi, $tanggal), true);
            $data['net_sales'] = Fungsi::formatUang($this->hitungNetSales($data_order, $data_transaksi, $tanggal), true);
            $data['gross_profit'] = Fungsi::formatUang($this->hitungGrossProfit($data_order, $data_transaksi, $tanggal), true);
            $data['total_harga_beli_produk'] = Fungsi::formatUang($this->hitungTotalHargaBeliProduk($data_order, $tanggal), true);
            $data['order_selesai'] = $this->hitungOrderSelesai($data_order, $tanggal);
            $data['produk_terjual'] = $this->hitungProdukTerjual($data_order, $tanggal);
            $data['expense'] = Fungsi::formatUang($this->hitungExpense($data_expense, $tanggal), true);
            $data['net_profit'] = Fungsi::formatUang($this->hitungNetProfit($data_order, $data_expense, $data_transaksi, $tanggal), true);
            $data['chart_untung'] = $this->hitungChartUntung($data_order, $data_transaksi, $tanggal);
            Cache::put('data_laporan_'.Fungsi::dataOfCek(), [
                $index => $data
            ], 10000);
        }
        if($request->ajax()){
            return Fungsi::respon('belakang.laporan.index', compact('tanggal', 'data'), "ajax", $request);
        }
        return Fungsi::respon('belakang.laporan.index', compact('tanggal', 'data'), "html", $request);
    }

    private function hitungChartExpedisi(&$data_src, &$tanggal){
        $hasil = $temp = $temp_exp = $temp_warna = $temp_data = [];
        $t_tglDari = strtotime($tanggal['dari']);
        $t_tglSampai = strtotime($tanggal['sampai']);
        $warna = [
            'rgb(62, 142, 247)',
            'rgb(17, 194, 109)',
            'rgb(255, 76, 82)',
            'rgb(11, 178, 212)',
            'rgb(23, 179, 163)',
            'rgb(255, 205, 23)',
            'rgb(109, 166, 17)',
            'rgb(148, 99, 247)',
            'rgb(247, 69, 132)',
            'rgb(235, 103, 9)',
            'rgb(153, 123, 113)',
            'rgb(114, 49, 245)',
            'rgb(230, 32, 32)',
            'rgb(54, 79, 245)',
            'rgb(0, 125, 150)',
            'rgb(158, 158, 158)',
            'rgb(181, 63, 0)',
            'rgb(195, 232, 135)',
            'rgb(107, 227, 215)',
            'rgb(153, 197, 255)',
            'rgb(207, 184, 176)',
            'rgb(163, 175, 183)',
            'rgb(148, 204, 57)',
            'rgb(255, 133, 137)',
        ];
        foreach(Fungsi::genArray($data_src) as $iO => $vO){
            $t_tglOrder = strtotime($vO->tanggal_order);
            if($t_tglOrder >= $t_tglDari && $t_tglOrder <= $t_tglSampai){
                $kurir = json_decode($vO->kurir);
                switch($kurir->tipe){
                    case 'toko':
                        $index = 'toko';
                        break;
    
                    case 'kurir':
                        $index = 'kurir';
                        break;
    
                    case 'expedisi':
                        $index = explode('|', $kurir->data)[0];
                        break;
                }
                if(isset($temp[$index])){
                    $temp[$index] += 1;
                } else {
                    $temp[$index] = 1;
                    if($index == 'jnt') {
                        $index = 'J&T';
                    } else if($index == 'toko') {
                        $index = 'Ambil Di Toko';
                    } else if($index == 'kurir') {
                        $index = 'Kustom Kurir';
                    } else {
                        $index = strtoupper($index);
                    }
                    $temp_exp[] = $index;
                }
                // shuffle($warna);
                $temp_warna[] = array_shift($warna);
            }
        }
        $hasil['expedisi'] = json_encode($temp_exp);
        $hasil['warna'] = json_encode($temp_warna);
        foreach(Fungsi::genArray($temp) as $t){
            $temp_data[] = $t;
        }
        $hasil['data'] = json_encode($temp_data);
        // dd($hasil);
        return $hasil;
    }

    public function getTransaksiData(Request $request){
        if($request->ajax()){
            $data_transaksi = Cache::remember('data_transaksi_lengkap_'.Fungsi::dataOfCek(), 10000, function(){
                return DB::table('t_pembayaran')->where('data_of', Fungsi::dataOfCek())->get();
            });
            $data_order = Cache::remember('data_order_lengkap_'.Fungsi::dataOfCek(), 10000, function(){
                return DB::table('t_order')
                    ->where('data_of', Fungsi::dataOfCek())
                    ->where('canceled', 0)
                    ->get();
            });
            $data = [];
            $no = 0;
            $temp_ = [];
            $t_tglDari = strtotime($request->dari);
            $t_tglSampai = strtotime($request->sampai);
            foreach(Fungsi::genArray($data_transaksi) as $row) {
                $t_tglBayar = strtotime($row->tgl_bayar);
                if($t_tglBayar >= $t_tglDari && $t_tglBayar <= $t_tglSampai){
                    $genOrder = Fungsi::genArray($data_order);
                    foreach($genOrder as $o){
                        if($o->id_order == $row->order_id){
                            if($row->via == 'CASH'){
                                if(isset($temp_['cash'])){
                                    $temp_['cash']['jumlah'] += (int)$row->nominal;
                                } else {
                                    $temp_['cash']['jumlah'] = (int)$row->nominal;
                                    $temp_['cash']['tipe'] = 'cash';
                                }
                            } else {
                                $id = explode('|', $row->via)[0];
                                if(isset($temp_[$id])){
                                    $temp_[$id]['jumlah'] += (int)$row->nominal;
                                } else {
                                    $temp_[$id]['jumlah'] = (int)$row->nominal;
                                    $temp_[$id]['tipe'] = 'bank';
                                    $data_bank = DB::table('t_bank')->where('data_of', Fungsi::dataOfCek())->where('id_bank', $id)->get()->first();
                                    if(isset($data_bank)){
                                        $temp_[$id]['data'] = [
                                            'bank' => $data_bank->bank,
                                            'no_rek' => $data_bank->no_rek,
                                            'cabang' => $data_bank->cabang,
                                            'atas_nama' => $data_bank->atas_nama,
                                        ];
                                    } else {
                                        $temp_[$id]['data'] = [
                                            'bank' => explode('|', $row->via)[1],
                                            'no_rek' => '[?Terhapus?]',
                                            'cabang' => '[?Terhapus?]',
                                            'atas_nama' => '[?Terhapus?]',
                                        ];
                                    }
                                }
                            }
                            $genOrder->send('stop');
                        }
                    }
                }
            }
            foreach (Fungsi::genArray($temp_) as $r) {
                if($r['tipe'] == 'cash'){
                    $via = 'CASH';
                } else {
                    $via = $r['data']['bank'].' ('.$r['data']['no_rek'].'&nbsp; a/n &nbsp;'.strtoupper($r['data']['atas_nama']).')';
                }
                $total = Fungsi::uangFormat($r['jumlah'], true);
                $data[$no++] = [
                    $via,
                    $total,
                ];
            }
            $result['data'] = $data;
            return Fungsi::respon($result, [], 'json', $request);
        } else {
            abort(404);
        }
    }

    private function hitungChartUntung(&$data_src, &$data_transaksi, &$tanggal){
        $hasil = $data_net_sales = $data_gross_profit = [];
        $dari = strtotime($tanggal['dari']);
        $sampai = strtotime($tanggal['sampai']);
        foreach(Fungsi::genArrayFor($dari, $sampai, 86400) as $i){
            $list_tgl[] = date('j M Y', $i);
            $net_sales_t = $gross_profit_t = 0;
            foreach(Fungsi::genArray($data_src) as $iU => $vU){
                $t_order[0] = $vU;
                $t_tgl['dari'] = date('j M Y', $i);
                $t_tgl['sampai'] = date('j M Y', $i);
                $net_sales_t += $this->hitungNetSales($t_order, $data_transaksi, $t_tgl);
                $gross_profit_t += $this->hitungGrossProfit($t_order, $data_transaksi, $t_tgl);
            }
            $data_net_sales[] = $net_sales_t;
            $data_gross_profit[] = $gross_profit_t;
        }
        $hasil['net_sales'] = json_encode($data_net_sales);
        $hasil['gross_profit'] = json_encode($data_gross_profit);
        $hasil['list_tgl'] = json_encode($list_tgl);
        return $hasil;
    }

    private function hitungGrossSales(&$data_src, &$data_transaksi, &$tanggal){
        $data_hasil = [];
        $hasil = 0;
        $t_tglDari = strtotime($tanggal['dari']);
        $t_tglSampai = strtotime($tanggal['sampai']);
        foreach(Fungsi::genArray($data_src) as $iO => $vO){
            $bayarCek = json_decode($vO->pembayaran);
            $t_tglOrder = strtotime($vO->tanggal_order);
            if($bayarCek->status == 'lunas'){
                if($t_tglOrder >= $t_tglDari && $t_tglOrder <= $t_tglSampai){
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
                    $data_hasil[] = $total_temp;
                }
            } else if($bayarCek->status == 'cicil'){
                if($t_tglOrder >= $t_tglDari && $t_tglOrder <= $t_tglSampai){
                    $total_temp = 0;
                    foreach(Fungsi::genArray($data_transaksi) as $t){
                        if($t->order_id == $vO->id_order){
                            $tgl_bayar = strtotime($t->tgl_bayar);
                            if($tgl_bayar >= $t_tglDari && $tgl_bayar <= $t_tglSampai){
                                $total_temp += $t->nominal;
                            }
                        }
                    }
                    $data_hasil[] = $total_temp;
                }
            }
        }
        foreach(Fungsi::genArray($data_hasil) as $i => $v){
            $hasil += (int)$v;
        }
        return $hasil;
    }

    private function hitungUnpaidGrossSales(&$data_src, &$data_transaksi, &$tanggal){
        $data_hasil = [];
        $hasil = 0;
        $t_tglDari = strtotime($tanggal['dari']);
        $t_tglSampai = strtotime($tanggal['sampai']);
        foreach(Fungsi::genArray($data_src) as $iO => $vO){
            $bayarCek = json_decode($vO->pembayaran);
            $t_tglOrder = strtotime($vO->tanggal_order);
            if($bayarCek->status == 'belum'){
                if($t_tglOrder >= $t_tglDari && $t_tglOrder <= $t_tglSampai){
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
                    $data_hasil[] = $total_temp;
                }
            } else if($bayarCek->status == 'cicil'){
                if($t_tglOrder >= $t_tglDari && $t_tglOrder <= $t_tglSampai){
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
                    foreach(Fungsi::genArray($data_transaksi) as $t){
                        if($t->order_id == $vO->id_order){
                            $tgl_bayar = strtotime($t->tgl_bayar);
                            if($tgl_bayar >= $t_tglDari && $tgl_bayar <= $t_tglSampai){
                                $total_temp -= $t->nominal;
                            }
                        }
                    }
                    $data_hasil[] = $total_temp;
                }
            }
        }
        foreach(Fungsi::genArray($data_hasil) as $i => $v){
            $hasil += (int)$v;
        }
        return $hasil;
    }

    private function hitungNetSales(&$data_src, &$data_transaksi, &$tanggal){
        $data_hasil = [];
        $hasil = 0;
        $t_tglDari = strtotime($tanggal['dari']);
        $t_tglSampai = strtotime($tanggal['sampai']);
        foreach(Fungsi::genArray($data_src) as $iO => $vO){
            $bayarCek = json_decode($vO->pembayaran);
            $t_tglOrder = strtotime($vO->tanggal_order);
            if($bayarCek->status == 'lunas'){
                if($t_tglOrder >= $t_tglDari && $t_tglOrder <= $t_tglSampai){
                    $total_data = json_decode($vO->total);
                    $total_tt = $total_data->hargaProduk;
                    if(!is_null($total_data->diskonOrder)){
                        foreach(Fungsi::genArray($total_data->diskonOrder) as $iD => $vD){
                            $total_tt -= $vD->harga;
                        }
                    }
                    $data_hasil[] = $total_tt;
                }
            } else if($bayarCek->status == 'cicil'){
                if($t_tglOrder >= $t_tglDari && $t_tglOrder <= $t_tglSampai){
                    $total_data = json_decode($vO->total);
                    $temp_total_produk = $total_data->hargaProduk;
                    if(!is_null($total_data->diskonOrder)){
                        foreach(Fungsi::genArray($total_data->diskonOrder) as $iD => $vD){
                            $temp_total_produk -= $vD->harga;
                        }
                    }
                    $total_temp = 0;
                    foreach(Fungsi::genArray($data_transaksi) as $t){
                        if($t->order_id == $vO->id_order){
                            $tgl_bayar = strtotime($t->tgl_bayar);
                            if($tgl_bayar >= $t_tglDari && $tgl_bayar <= $t_tglSampai){
                                $total_temp += $t->nominal;
                            }
                        }
                    }
                    if($total_temp >= $temp_total_produk){
                        $data_hasil[] = $temp_total_produk;
                    } else if($total_temp < $temp_total_produk){
                        $data_hasil[] = $total_temp;
                    }
                }
            }
        }
        foreach(Fungsi::genArray($data_hasil) as $i => $v){
            $hasil += (int)$v;
        }
        return $hasil;
    }

    private function hitungGrossProfit(&$data_src, &$data_transaksi, &$tanggal){
        $data_hasil = [];
        $hasil = 0;
        $t_tglDari = strtotime($tanggal['dari']);
        $t_tglSampai = strtotime($tanggal['sampai']);
        foreach(Fungsi::genArray($data_src) as $iO => $vO){
            $bayarCek = json_decode($vO->pembayaran);
            $t_tglOrder = strtotime($vO->tanggal_order);
            if($bayarCek->status == 'lunas'){
                if($t_tglOrder >= $t_tglDari && $t_tglOrder <= $t_tglSampai){
                    $total_data = json_decode($vO->total);
                    $harga_jual = $total_data->hargaProduk;
                    if(!is_null($total_data->diskonOrder)){
                        foreach(Fungsi::genArray($total_data->diskonOrder) as $iD => $vD){
                            $harga_jual -= $vD->harga;
                        }
                    }
                    $produk = json_decode($vO->produk);
                    $harga_beli = 0;
                    foreach(Fungsi::genArray($produk->list) as $iP => $vP){
                        $harga_beli += ((int)$vP->rawData->harga_beli * $vP->jumlah);
                    }
                    $data_hasil[] = ($harga_jual - $harga_beli);
                }
            } else if($bayarCek->status == 'cicil'){
                if($t_tglOrder >= $t_tglDari && $t_tglOrder <= $t_tglSampai){
                    $total_data = json_decode($vO->total);
                    $harga_jual = $total_data->hargaProduk;
                    if(!is_null($total_data->diskonOrder)){
                        foreach(Fungsi::genArray($total_data->diskonOrder) as $iD => $vD){
                            $harga_jual -= $vD->harga;
                        }
                    }
                    $produk = json_decode($vO->produk);
                    $harga_beli = 0;
                    foreach(Fungsi::genArray($produk->list) as $iP => $vP){
                        $harga_beli += ((int)$vP->rawData->harga_beli * $vP->jumlah);
                    }
                    $total_temp_produk = ($harga_jual - $harga_beli);
                    $total_temp = 0;
                    foreach(Fungsi::genArray($data_transaksi) as $t){
                        if($t->order_id == $vO->id_order){
                            $tgl_bayar = strtotime($t->tgl_bayar);
                            if($tgl_bayar >= $t_tglDari && $tgl_bayar <= $t_tglSampai){
                                $total_temp += $t->nominal;
                            }
                        }
                    }
                    if($total_temp >= $total_temp_produk){
                        $data_hasil[] = $total_temp_produk;
                    } else if($total_temp < $total_temp_produk){
                        $data_hasil[] = $total_temp;
                    }
                }
            }
        }
        foreach(Fungsi::genArray($data_hasil) as $i => $v){
            $hasil += (int)$v;
        }
        return $hasil;
    }

    private function hitungTotalHargaBeliProduk(&$data_src, &$tanggal){
        $data_hasil = [];
        $hasil = 0;
        $t_tglDari = strtotime($tanggal['dari']);
        $t_tglSampai = strtotime($tanggal['sampai']);
        foreach(Fungsi::genArray($data_src) as $iO => $vO){
            $bayarCek = json_decode($vO->pembayaran);
            $t_tglOrder = strtotime($vO->tanggal_order);
            if($bayarCek->status == 'lunas'){
                if($t_tglOrder >= $t_tglDari && $t_tglOrder <= $t_tglSampai){
                    $produk = json_decode($vO->produk);
                    $harga_beli = 0;
                    foreach(Fungsi::genArray($produk->list) as $iP => $vP){
                        $harga_beli += ((int)$vP->rawData->harga_beli * $vP->jumlah);
                    }
                    $data_hasil[] = $harga_beli;
                }
            }
        }
        foreach(Fungsi::genArray($data_hasil) as $i => $v){
            $hasil += (int)$v;
        }
        return $hasil;
    }

    private function hitungProdukTerjual(&$data_src, &$tanggal){
        $hasil = 0;
        foreach(Fungsi::genArray($data_src) as $iO => $vO){
            if($vO->state == 'terima'){
                $t_tglDari = strtotime($tanggal['dari']);
                $t_tglSampai = strtotime($tanggal['sampai']);
                $t_tglOrder = strtotime($vO->tanggal_order);
                if($t_tglOrder >= $t_tglDari && $t_tglOrder <= $t_tglSampai){
                    $produk = json_decode($vO->produk);
                    foreach(Fungsi::genArray($produk->list) as $iP => $vP){
                        $hasil += $vP->jumlah;
                    }
                }
            }
        }
        return $hasil;
    }

    private function hitungOrderSelesai(&$data_src, &$tanggal){
        $data_hasil = [];
        foreach(Fungsi::genArray($data_src) as $iO => $vO){
            if($vO->state == 'terima'){
                $t_tglDari = strtotime($tanggal['dari']);
                $t_tglSampai = strtotime($tanggal['sampai']);
                $t_tglOrder = strtotime($vO->tanggal_order);
                if($t_tglOrder >= $t_tglDari && $t_tglOrder <= $t_tglSampai){
                    $data_hasil[] = $vO->id_order;
                }
            }
        }
        return count($data_hasil);
    }

    private function hitungExpense(&$data_src, &$tanggal){
        $hasil = 0;
        foreach(Fungsi::genArray($data_src) as $iO => $vO){
            $t_tglDari = strtotime($tanggal['dari']);
            $t_tglSampai = strtotime($tanggal['sampai']);
            $t_tgl = strtotime($vO->tanggal);
            if($t_tgl >= $t_tglDari && $t_tgl <= $t_tglSampai){
                $hasil += ($vO->harga * $vO->jumlah);
            }
        }
        return $hasil;
    }

    private function hitungNetProfit(&$data_order, &$data_expense, &$data_transaksi, &$tanggal){
        return ($this->hitungGrossProfit($data_order, $data_transaksi, $tanggal) - $this->hitungExpense($data_expense, $tanggal));
    }

}