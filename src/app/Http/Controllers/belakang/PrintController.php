<?php

namespace App\Http\Controllers\belakang;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cache;
use Illuminate\Contracts\Encryption\DecryptException;
use App\Http\Controllers\PusatController as Fungsi;


class PrintController extends Controller
{

	public function __construct(){
		$this->middleware('b.auth');
        $this->middleware('xss_protect');
    }

    
    public function index(Request $request, $target = null){
		if(is_null($target) || preg_match("/[^0-9\-]/", $target)){
            return redirect()->route('b.order-index');
        }
        $id_target = $target;
        $target = explode('-', $target);
        $dataCek = $data = [];
        foreach(Fungsi::genArray($target) as $tD){
            $data_order = DB::table('t_order')
                ->where('data_of', Fungsi::dataOfCek())
                ->where('urut_order', $tD)
                ->get()->first();
            if(isset($data_order)){
                $dataCek[] = $data_order;
            } else {
                unset($data);
                return redirect(route('b.order-index'))->with([
                    'msg_error' => 'ID Order '.$tD.' tidak ditemukan!'
                ]);
            }
        }
        $print = Cache::remember('data_print_pengaturan_'.Fungsi::dataOfCek(), 120000, function(){
            $data_print = DB::table('t_print')
                ->where('data_of', Fungsi::dataOfCek())
                ->get()->first();
            if(isset($data_print)){
                $print = new \stdclass();
                $print->ship = json_decode($data_print->ship);
                $print->ship_v2 = json_decode($data_print->ship_v2);
                $print->ship_a6 = json_decode($data_print->ship_a6);
                $print->invoice = json_decode($data_print->invoice);
                $print->invoice_thermal_88mm = json_decode($data_print->invoice_thermal_88mm);
            } else {
                $print = null;
            }
            return $print;
        });
        foreach(Fungsi::genArray($dataCek) as $i_tD => $tD){
            $data[$i_tD]['order'] = new \stdclass();
            $data[$i_tD]['order']->id_order = $tD->id_order;
            $data[$i_tD]['order']->tanggal_order = date('j F Y', strtotime($tD->tanggal_order));
            $data[$i_tD]['order']->produk = $tD->produk;
            $data[$i_tD]['order']->resi = $tD->resi;
            $data[$i_tD]['order']->kurir = $tD->kurir;
            $data[$i_tD]['order']->total_produk = 0;
            foreach(Fungsi::genArray(json_decode($tD->produk)->list) as $lp){
                $data[$i_tD]['order']->total_produk += $lp->jumlah;
            }
            $data[$i_tD]['order']->total_harga = 0;
            $total = json_decode($tD->total);
            $data[$i_tD]['order']->diskonOrder = $total->diskonOrder;
            $data[$i_tD]['order']->biayaLain = $total->biayaLain;
            $data[$i_tD]['order']->diskonProduk = $total->diskonProduk;
            $data[$i_tD]['order']->total_harga += $total->hargaProduk + $total->hargaOngkir;
            if(!is_null($total->biayaLain)){
                foreach(Fungsi::genArray($total->biayaLain) as $bl){
                    $data[$i_tD]['order']->total_harga += $bl->harga;
                }    
            }
            if(!is_null($total->diskonOrder)){
                foreach(Fungsi::genArray($total->diskonOrder) as $do){
                    $data[$i_tD]['order']->total_harga -= $do->harga;
                }    
            }
            $data_admin = DB::table('users')
                ->where('id', $tD->admin_id)
                ->select('name')
                ->get()->first();
            if(isset($data_admin)){
                $data[$i_tD]['order']->nama_admin = $data_admin->name;
            } else {
                $data[$i_tD]['order']->nama_admin = '-';
            }
            $data_pemesan = DB::table('t_customer')
                ->join('users', 'users.id', '=', 't_customer.user_id')
                ->where('data_of', Fungsi::dataOfCek())
                ->where('users.id', $tD->pemesan_id)
                ->select('users.name', 'users.email', 'users.no_telp', 't_customer.kabupaten', 't_customer.kategori', 't_customer.id_customer',
                    't_customer.provinsi', 't_customer.kecamatan', 't_customer.alamat', 't_customer.kode_pos')
                ->get()->first();
            if(isset($data_pemesan)){
                $data[$i_tD]['pemesan'] = $data_pemesan;
            } else {
                $data[$i_tD]['pemesan'] = new \stdclass();
                $data[$i_tD]['pemesan']->name = '[?Terhapus?]';
                $data[$i_tD]['pemesan']->no_telp = '[?Terhapus?]';
                $data[$i_tD]['pemesan']->kabupaten = '[?Terhapus?]';
                $data[$i_tD]['pemesan']->kategori = '[?Terhapus?]';
                $data[$i_tD]['pemesan']->id_customer = '[?Terhapus?]';
                $data[$i_tD]['pemesan']->provinsi = '[?Terhapus?]';
                $data[$i_tD]['pemesan']->kecamatan = '[?Terhapus?]';
                $data[$i_tD]['pemesan']->alamat = '[?Terhapus?]';
                $data[$i_tD]['pemesan']->kode_pos = '[?Terhapus?]';
            }
            $data_tujuan = DB::table('t_customer')
                ->join('users', 'users.id', '=', 't_customer.user_id')
                ->where('data_of', Fungsi::dataOfCek())
                ->where('users.id', $tD->tujuan_kirim_id)
                ->select('users.name', 'users.email', 'users.no_telp', 't_customer.kabupaten', 't_customer.kategori', 't_customer.id_customer',
                    't_customer.provinsi', 't_customer.kecamatan', 't_customer.alamat', 't_customer.kode_pos')
                ->get()->first();
            if(isset($data_tujuan)){
                $data[$i_tD]['tujuan'] = $data_tujuan;
            } else {
                $data[$i_tD]['tujuan'] = new \stdclass();
                $data[$i_tD]['tujuan']->name = '[?Terhapus?]';
                $data[$i_tD]['tujuan']->no_telp = '[?Terhapus?]';
                $data[$i_tD]['tujuan']->kabupaten = '[?Terhapus?]';
                $data[$i_tD]['tujuan']->kategori = '[?Terhapus?]';
                $data[$i_tD]['tujuan']->id_customer = '[?Terhapus?]';
                $data[$i_tD]['tujuan']->provinsi = '[?Terhapus?]';
                $data[$i_tD]['tujuan']->kecamatan = '[?Terhapus?]';
                $data[$i_tD]['tujuan']->alamat = '[?Terhapus?]';
                $data[$i_tD]['tujuan']->kode_pos = '[?Terhapus?]';
            }
            $data_toko = DB::table('t_store')
                ->where('data_of', Fungsi::dataOfCek())
                ->select('nama_toko', 'foto_id', 'deskripsi_toko', 'no_telp_toko', 'alamat_toko')
                ->get()->first();
            $toko = new \stdclass();
            $toko->nama_toko = $data_toko->nama_toko;
            $toko->deskripsi_toko = $data_toko->deskripsi_toko;
            $toko->no_telp_toko = $data_toko->no_telp_toko;
            $toko->alamat_toko = $data_toko->alamat_toko;
            if(isset($data_toko->foto_id)){
                $foto = DB::table('t_foto')
                    ->where('data_of', Fungsi::dataOfCek())
                    ->where('id_foto', $data_toko->foto_id)
                    ->get()->first();
                if(isset($foto)){
                    $foto_path = public_path($foto->path);
                    if(file_exists($foto_path)){
                        // dd('aafff');
                        $toko->foto = asset($foto->path);
                    } else {
                        // dd($foto_path);
                        $toko->foto = asset('photo.png');
                    }
                } else {
                    $toko->foto = asset('photo.png');
                }
            } else {
                $toko->foto = asset('photo.png');
            }
            $data[$i_tD]['toko'] = $toko;
            $data_bayar = DB::table('t_pembayaran')
                ->where('data_of', Fungsi::dataOfCek())
                ->where('order_id', $tD->id_order)
                ->orderBy('tgl_bayar', 'desc')
                ->orderBy('id_bayar', 'desc')
                ->get();
            $sudah_bayar = 0;
            // dd(is_array($data_bayar));
            if(count($data_bayar) > 0){
                foreach(Fungsi::genArray($data_bayar) as $i_ => $db){
                    if($i_ === 0){
                        // dd($db);
                        $data[$i_tD]['terakhir_tgl_bayar'] = $db->tgl_bayar;
                        if($db->via == 'CASH'){
                            $data[$i_tD]['via_bayar'] = 'CASH';
                        } else {
                            $id_via = explode('|', $db->via)[0];
                            $via_bayar = DB::table('t_bank')
                                ->where('data_of', Fungsi::dataOfCek())
                                ->where('id_bank', $id_via)
                                ->select('bank', 'no_rek', 'cabang', 'atas_nama')
                                ->get()->first();
                            if(isset($via_bayar)){
                                $data[$i_tD]['via_bayar'] = $via_bayar;
                            } else {
                                $data[$i_tD]['via_bayar'] = '[?Terhapus?]';
                            }
                        }
                    }
                    $data[$i_tD]['bayar'][$i_] = new \stdclass();
                    $data[$i_tD]['bayar'][$i_]->tgl_bayar = $db->tgl_bayar;
                    $data[$i_tD]['bayar'][$i_]->nominal = $db->nominal;
                    $data[$i_tD]['bayar'][$i_]->via = $db->via;
                    $sudah_bayar += $db->nominal;
                }
                if($data[$i_tD]['order']->total_harga > $sudah_bayar && $sudah_bayar > 0){
                    $data[$i_tD]['tipe_bayar'] = 'cicil';
                } else if($data[$i_tD]['order']->total_harga === 0){
                    $data[$i_tD]['tipe_bayar'] = 'belum';
                } else if($data[$i_tD]['order']->total_harga === $sudah_bayar){
                    $data[$i_tD]['tipe_bayar'] = 'lunas';
                }
            } else {
                $data[$i_tD]['bayar'] = [];
                $data[$i_tD]['tipe_bayar'] = 'belum';
                $data[$i_tD]['via_bayar'] = '-';
                $data[$i_tD]['terakhir_tgl_bayar'] = '-';
            }
            $data[$i_tD]['sudah_bayar'] = $sudah_bayar;
        }
        return Fungsi::respon('belakang.print', compact('data', 'id_target', 'print'), 'html', $request);
    }

    public function simpan(Request $request){
        if($request->ajax()){
            if(isset($request->tipe) && $request->tipe == 'simpan'){
                $data = json_decode(strip_tags($request->data));
                $cekData = DB::table('t_print')
                    ->where('data_of', Fungsi::dataOfCek())
                    ->get()->first();
                // dd($data);
                if(isset($cekData)){
                    $status = DB::table('t_print')->update([
                        'ship' => isset($data->print_ship) ? json_encode($data->print_ship) : null,
                        'ship_v2' => isset($data->print_ship_v2) ? json_encode($data->print_ship_v2) : null,
                        'ship_a6' => isset($data->print_ship_a6) ? json_encode($data->print_ship_a6) : null,
                        'invoice' => isset($data->print_invoice) ? json_encode($data->print_invoice) : null,
                        'invoice_thermal_88mm' => isset($data->print_invoice_thermal_88mm) ? json_encode($data->print_invoice_thermal_88mm) : null
                    ]);
                } else {
                    $status = DB::table('t_print')->insert([
                        'ship' => isset($data->print_ship) ? json_encode($data->print_ship) : null,
                        'ship_v2' => isset($data->print_ship_v2) ? json_encode($data->print_ship_v2) : null,
                        'ship_a6' => isset($data->print_ship_a6) ? json_encode($data->print_ship_a6) : null,
                        'invoice' => isset($data->print_invoice) ? json_encode($data->print_invoice) : null,
                        'invoice_thermal_88mm' => isset($data->print_invoice_thermal_88mm) ? json_encode($data->print_invoice_thermal_88mm) : null,
                        'data_of' => Fungsi::dataOfCek()
                    ]);
                }
                Cache::forget('data_print_pengaturan_'.Fungsi::dataOfCek());
                if($status){
                    return Fungsi::respon([
                        'status' => true,
                        'msg' => 'Berhasil menyimpan pengaturan print!'
                    ], [], 'json', $request);
                } else {
                    return Fungsi::respon([
                        'status' => false,
                        'msg' => 'Gagal menyimpan pengaturan print!'
                    ], [], 'json', $request);
                }
            } else if(isset($request->tipe) && $request->tipe == 'print'){
                $target = strip_tags($request->data);
                $count = count(explode('|', $target));
                $c = 0;
                foreach(Fungsi::genArray(explode('|', $target)) as $t){
                    $update = DB::table('t_order')
                        ->where('data_of', Fungsi::dataOfCek())
                        ->where('id_order', $t)
                        ->update([
                            'print_label' => 1
                        ]);
                    if($update){
                        $c++;
                    }
                }
                if($c === $count){
                    return Fungsi::respon([
                        'status' => true,
                        'msg' => 'Berhasil menyimpan data print!'
                    ], [], 'json', $request);
                } else {
                    return Fungsi::respon([
                        'status' => false,
                        'msg' => 'Gagal menyimpan data print!'
                    ], [], 'json', $request);
                }
            }
        } else {
            abort(404);
        }
    }
}