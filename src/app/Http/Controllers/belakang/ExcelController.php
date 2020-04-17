<?php 
namespace App\Http\Controllers\belakang;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Exports\ExpenseExport;
use App\Exports\CustomerExport;
use App\Exports\OrderExport;
use App\Exports\ProdukExport;
use App\Events\ProdukDataBerubah;
use App\Imports\ProdukImport;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\PusatController as Fungsi;
use Illuminate\Contracts\Encryption\DecryptException;
use Excel;

class ExcelController extends Controller { 

    public function exportExpense(Request $request, $format = null) {
        list($data_user, $ijin) = $this->getIjinUser();
        if(($ijin->downloadExcel === 1 && $data_user->role == 'Admin') || $data_user->role == 'Owner'){
            $formatAv = ['xlsx', 'xls', 'csv'];
            $format = strip_tags($format);
            if(is_null($format) || !in_array($format, $formatAv)){
                return redirect()->route('b.expense-index');
            }
            switch($format){
                case 'xlsx':
                    return Excel::download(new ExpenseExport(Fungsi::dataOfCek()), 'expense_'.date("Y-m-d").'.xlsx', \Maatwebsite\Excel\Excel::XLSX);
                    break;

                case 'xls':
                    return Excel::download(new ExpenseExport(Fungsi::dataOfCek()), 'expense_'.date("Y-m-d").'.xls', \Maatwebsite\Excel\Excel::XLS);
                    break;

                case 'csv':
                    return Excel::download(new ExpenseExport(Fungsi::dataOfCek()), 'expense_'.date("Y-m-d").'.csv', \Maatwebsite\Excel\Excel::CSV, [
                        'Content-Type' => 'text/csv'
                    ]);
                    break;

                default:
                    return redirect()->route('b.expense-index');
                    break;
            }
        } else {
            return redirect()->route("b.expense-index");
        }
    }

    public function exportCustomer(Request $request, $format = null) {
        list($data_user, $ijin) = $this->getIjinUser();
        if(($ijin->downloadExcel === 1 && $data_user->role == 'Admin') || $data_user->role == 'Owner'){
            $formatAv = ['xlsx', 'xls', 'csv'];
            $format = strip_tags($format);
            if(is_null($format) || !in_array($format, $formatAv)){
                return redirect()->route('b.customer-index');
            }
            switch($format){
                case 'xlsx':
                    return Excel::download(new CustomerExport(Fungsi::dataOfCek()), 'customer_'.date("Y-m-d").'.xlsx', \Maatwebsite\Excel\Excel::XLSX);
                    break;

                case 'xls':
                    return Excel::download(new CustomerExport(Fungsi::dataOfCek()), 'customer_'.date("Y-m-d").'.xls', \Maatwebsite\Excel\Excel::XLS);
                    break;

                case 'csv':
                    return Excel::download(new CustomerExport(Fungsi::dataOfCek()), 'customer_'.date("Y-m-d").'.csv', \Maatwebsite\Excel\Excel::CSV, [
                        'Content-Type' => 'text/csv'
                    ]);
                    break;

                default:
                    return redirect()->route('b.customer-index');
                    break;
            }
        } else {
            return redirect()->route("b.customer-index");
        }
    }

    public function exportOrder(Request $request, $format = null) {
        list($data_user, $ijin) = $this->getIjinUser();
        if(($ijin->downloadExcel === 1 && $data_user->role == 'Admin') || $data_user->role == 'Owner'){
            $formatAv = ['xlsx', 'xls', 'csv'];
            $format = strip_tags($format);
            if(is_null($format) || !in_array($format, $formatAv)){
                return redirect()->route('b.order-index');
            }
            $filter['dari'] = strip_tags($request->dari);
            $filter['sampai'] = strip_tags($request->sampai);
            switch($format){
                case 'xlsx':
                    return Excel::download(new OrderExport(Fungsi::dataOfCek(), $filter), 'order_'.date("Y-m-d").'.xlsx', \Maatwebsite\Excel\Excel::XLSX);
                    break;

                case 'xls':
                    return Excel::download(new OrderExport(Fungsi::dataOfCek(), $filter), 'order_'.date("Y-m-d").'.xls', \Maatwebsite\Excel\Excel::XLS);
                    break;

                case 'csv':
                    return Excel::download(new OrderExport(Fungsi::dataOfCek(), $filter), 'order_'.date("Y-m-d").'.csv', \Maatwebsite\Excel\Excel::CSV, [
                        'Content-Type' => 'text/csv'
                    ]);
                    break;

                default:
                    return redirect()->route('b.order-index');
                    break;
            }
        } else {
            return redirect()->route("b.order-index");
        }
    }

    public function exportProduk(Request $request, $format = null) {
        list($data_user, $ijin) = $this->getIjinUser();
        if(($ijin->downloadExcel === 1 && $data_user->role == 'Admin') || $data_user->role == 'Owner'){
            $formatAv = ['xlsx', 'xls', 'csv'];
            $format = strip_tags($format);
            if(is_null($format) || !in_array($format, $formatAv)){
                return redirect()->route('b.order-index');
            }
            $tipe = strip_tags($request->tipe);
            $tipe = $tipe == 'arsip' ? 'arsip' : 'semua';
            switch($format){
                case 'xlsx':
                    return Excel::download(new ProdukExport(Fungsi::dataOfCek(), $tipe), $tipe.'_produk_'.date("Y-m-d").'.xlsx', \Maatwebsite\Excel\Excel::XLSX);
                    break;

                case 'xls':
                    return Excel::download(new ProdukExport(Fungsi::dataOfCek(), $tipe), $tipe.'_produk_'.date("Y-m-d").'.xls', \Maatwebsite\Excel\Excel::XLS);
                    break;

                case 'csv':
                    return Excel::download(new ProdukExport(Fungsi::dataOfCek(), $tipe), $tipe.'_produk_'.date("Y-m-d").'.csv', \Maatwebsite\Excel\Excel::CSV, [
                        'Content-Type' => 'text/csv'
                    ]);
                    break;

                default:
                    return redirect()->route('b.order-index');
                    break;
            }
        } else {
            return redirect()->route("b.produk-index");
        }
    }

    public function importProduk(Request $request){
        list($data_user, $ijin) = $this->getIjinUser();
        if(($ijin->uploadProdukExcel === 1 && $data_user->role == 'Admin') || $data_user->role == 'Owner'){
            $this->validate($request, [
                'fileUpload' => 'required|mimes:xls,xlsx'
            ]);
            $file = $request->file('fileUpload');
            $objImport = new ProdukImport;
            Excel::import($objImport, $file);
            Cache::forget('data_import_produk_'.Fungsi::dataOfCek());
            $data = Cache::rememberForever('data_import_produk_'.Fungsi::dataOfCek(), function() use($objImport) {
                return encrypt($objImport->getHasil());
            });
            $hasil = $this->cekDataImport($data);
            // dd($hasil);
            return Fungsi::respon('belakang.produk.preview-import', [
                'data' => $hasil,
                'namaFile' => $file->getClientOriginalName()
            ], "html", $request);
        } else {
            return redirect()->route("b.produk-index");
        }
		// Session::flash('msg_success','Data Berhasil Diimport!');

    }

    public function importProdukProses(Request $request){
        $data = json_decode(strip_tags($request->data));
        $data_cache_raw = Cache::get('data_import_produk_'.Fungsi::dataOfCek());
        
        $data_cache = json_decode($this->cekDataImport($data_cache_raw, true));
        $masihError = 0;
        foreach(Fungsi::genArray($data) as $i => $v){
            $masihError += $this->cekErrorById($data_cache, $v->id_untuk_validasi);
        }
        if($masihError > 0){
            return redirect()->route('b.produk-index')->with(['msg_error' => "Gagal mengimport data!"]);
        } else {
            $hasilDb = $this->importToDb($data);
            event(new ProdukDataBerubah(Fungsi::dataOfCek()));
            Cache::forget('data_import_produk_'.Fungsi::dataOfCek());
            if($hasilDb){
                return redirect()->route('b.produk-index')->with(['msg_success' => "Berhasil mengimport data!"]);
            } else {
                return redirect()->route('b.produk-index')->with(['msg_error' => "Gagal mengimport data!"]);
            }
        }
    }

    private function importToDb(&$data){
        $list_prod = [];
        foreach(Fungsi::genArray($data) as $row) {
            $nama_produk = strip_tags($row->nama_produk);
            $ukuran = strip_tags($row->ukuran);
            $warna = strip_tags($row->warna);
            $ket = strip_tags($row->keterangan);
            $sku = strip_tags($row->sku);
            $supplier = strip_tags($row->supplier);
            $gambar = strip_tags($row->link_gambar);
            $harga_beli = strip_tags($row->harga_beli);
            $harga_jual = strip_tags($row->harga_jual);
            $harga_reseller = strip_tags($row->harga_reseller);
            $berat = strip_tags($row->berat_gram);
            $jumlah_stok = strip_tags($row->jumlah_stok);
            $kategori_produk = strip_tags($row->kategori_produk);

            $cekProdukDB = DB::table('t_produk')
                ->where("nama_produk", $nama_produk)
                ->where("data_of", Fungsi::dataOfCek())
                ->get()->first();

            // dd($cekProdukDB);
            
            if(isset($cekProdukDB)){
                    
                if($cekProdukDB->supplier_id !== 0){
                    $adaSupplier = true;
                } else {
                    $adaSupplier = true;
                }

                $svVarian['produk_id'] = $cekProdukDB->id_produk;
				$offsetSku_akhir = DB::table('t_varian_produk')
					->where('data_of', Fungsi::dataOfCek())
					->where('produk_id', $cekProdukDB->id_produk)
					->select('sku_offset')
					->orderBy('sku_offset', 'desc')
					->get()->first();
                if(isset($offsetSku_akhir)){
                    $svVarian['sku_offset'] = $offsetSku_akhir->sku_offset+1;
                } else {
                    $svVarian['sku_offset'] = 1;
                }
                if($sku == ''){
                    $sku = 'P'.$cekProdukDB->produk_offset.'V'.$svVarian['sku_offset'];
                } else {
                    $cekSku = DB::table('t_varian_produk')
                        ->where("sku", $sku)
                        ->where("data_of", Fungsi::dataOfCek())
                        ->get()->first();
                        
                    if(isset($cekSku)){
                        $sku = 'P'.$cekProdukDB->produk_offset.'V'.$svVarian['sku_offset'];
                    }
                }
                $svVarian['sku'] = $sku;

                if($cekProdukDB->supplier_id === 0){
                    $stok = is_numeric($jumlah_stok) ? $jumlah_stok : 0;
                    $svVarian['stok'] = $stok."|sendiri";
                } else {
                    $stok = is_numeric($jumlah_stok) ? $jumlah_stok : 0;
                    $svVarian['stok'] = $stok."|lain";
                }

                $svVarian['harga_beli'] = $harga_beli;
                $svVarian['harga_jual_normal'] = $harga_jual;
                $svVarian['harga_jual_reseller'] = $harga_reseller == '' ? null : $harga_jual;
                $svVarian['ukuran'] = $ukuran == '' ? null : trim($ukuran);
                $svVarian['warna'] = $warna == '' ? null : trim($warna);

                $list_gambar = explode(';', $gambar);
                $gambar_utama = null;
                $gambar_lain = [];
                foreach(Fungsi::genArray($list_gambar) as $l){
                    if(is_null($gambar_utama)){
                        $gambar_utama = $l;
                    } else {
                        $gambar_lain[] = $l;
                    }
                }
                $svVarian['foto_id'] = json_encode([
                    "utama" => $gambar_utama,
                    "lain" => implode(";", $gambar_lain)
                ]);
                
                $svVarian['data_of'] = Fungsi::dataOfCek();
                $proses_id_varian = DB::table('t_varian_produk')->insertGetId($svVarian);
                $riwayatStok_varian = DB::table('t_riwayat_stok')->insert([
                    "varian_id" => $proses_id_varian,
                    "tgl" => date("Y-m-d H:i:s"),
                    "ket" => "Stok Awal",
                    "jumlah" => (int)$stok,
                    "tipe" => "masuk",
                    "data_of" => Fungsi::dataOfCek()
                ]);

            } else {

                if(in_array($nama_produk, $list_prod)){
                        
                    $adaSupplier = false;
    
                    $svVarian['produk_id'] = array_search($nama_produk, $list_prod);
					$offsetSku_akhir = DB::table('t_varian_produk')
						->where('data_of', Fungsi::dataOfCek())
						->where('produk_id', $svVarian['produk_id'])
						->select('sku_offset')
						->orderBy('sku_offset', 'desc')
						->get()->first();
					if(isset($offsetSku_akhir)){
						$svVarian['sku_offset'] = $offsetSku_akhir->sku_offset+1;
					} else {
						$svVarian['sku_offset'] = 1;
					}
                    if($sku == ''){
                        $sku = 'P'.$cekProdukDB->produk_offset.'V'.$svVarian['sku_offset'];
                    } else {
                        $cekSku = DB::table('t_varian_produk')
                            ->where("sku", $sku)
                            ->where("data_of", Fungsi::dataOfCek())
                            ->get()->first();
                            
                        if(isset($cekSku)){
                            $sku = 'P'.$cekProdukDB->produk_offset.'V'.$svVarian['sku_offset'];
                        }
                    }
                    $svVarian['sku'] = $sku;
    
                    if($svProduk['supplier_id'] == 0){
                        $stok = is_numeric($jumlah_stok) ? $jumlah_stok : 0;
                        $svVarian['stok'] = $stok."|sendiri";
                    } else {
                        $stok = is_numeric($jumlah_stok) ? $jumlah_stok : 0;
                        $svVarian['stok'] = $stok."|lain";
                    }
    
                    $svVarian['harga_beli'] = $harga_beli;
                    $svVarian['harga_jual_normal'] = $harga_jual;
                    $svVarian['harga_jual_reseller'] = $harga_reseller == '' ? null : $harga_jual;
                    $svVarian['ukuran'] = $ukuran == '' ? null : trim($ukuran);
                    $svVarian['warna'] = $warna == '' ? null : trim($warna);
    
                    $list_gambar = explode(';', $gambar);
                    $gambar_utama = null;
                    $gambar_lain = [];
                    foreach(Fungsi::genArray($list_gambar) as $l){
                        if(is_null($gambar_utama)){
                            $gambar_utama = $l;
                        } else {
                            $gambar_lain[] = $l;
                        }
                    }
                    $svVarian['foto_id'] = json_encode([
                        "utama" => $gambar_utama,
                        "lain" => implode(";", $gambar_lain)
                    ]);
                    
                    $svVarian['data_of'] = Fungsi::dataOfCek();
                    $proses_id_varian = DB::table('t_varian_produk')->insertGetId($svVarian);
                    $riwayatStok_varian = DB::table('t_riwayat_stok')->insert([
                        "varian_id" => $proses_id_varian,
                        "tgl" => date("Y-m-d H:i:s"),
                        "ket" => "Stok Awal",
                        "jumlah" => (int)$stok,
                        "tipe" => "masuk",
                        "data_of" => Fungsi::dataOfCek()
                    ]);
    
    
                } else {
                    $cekProdukNama = DB::table('t_produk')
                        ->select("nama_produk")
                        ->where("nama_produk", 'like', $nama_produk.'%')
                        ->where("data_of", Fungsi::dataOfCek())
                        ->get();
                    
                    if(count($cekProdukNama) > 0){
                        $svProduk['nama_produk'] = $nama_produk." #".(string)(count($cekProdukNama)+1);
                    } else {
                        $svProduk['nama_produk'] = $nama_produk;
                    }
    
                    $adaSupplier = false;
    
                    if($kategori_produk == ''){
                        $svProduk['kategori_produk_id'] = null;
                    } else {
                        $cekKategoriProduk = DB::table('t_kategori_produk')
                            ->where("nama_kategori_produk", $kategori_produk)
                            ->where("data_of", Fungsi::dataOfCek())
                            ->get()->first();
                        if(isset($cekKategoriProduk)){
                            $svProduk['kategori_produk_id'] = $cekKategoriProduk->id_kategori_produk;
                        } else {
                            $lastId_kategori_produk = DB::table('t_kategori_produk')->insertGetId([
                                'nama_kategori_produk' => $kategori_produk,
                                'data_of' => Fungsi::dataOfCek()
                            ]);
                            $svProduk['kategori_produk_id'] = $lastId_kategori_produk;
                        }
                    }
    
                    if($supplier == ''){
                        $svProduk['supplier_id'] = 0;
                    } else {
                        $cekSupplier = DB::table('t_supplier')
                            ->where("nama_supplier", $supplier)
                            ->where("data_of", Fungsi::dataOfCek())
                            ->get()->first();
                        if(isset($cekSupplier)){
                            $adaSupplier = true;
                            $svProduk['supplier_id'] = $cekSupplier->id_supplier;
                        } else {
                            $svProduk['supplier_id'] = 0;
                        }
                    }
                    $svProduk['berat'] = $berat;
                    $svProduk['ket'] = $ket == '' ? null : $ket;
                    $svProduk['data_of'] = Fungsi::dataOfCek();
                    $offsetProduk_akhir = DB::table('t_produk')
                        ->where('data_of', Fungsi::dataOfCek())
                        ->select('produk_offset')
                        ->orderBy('produk_offset', 'desc')
                        ->get()->first();
                    if(isset($offsetProduk_akhir)){
                        $svProduk['produk_offset'] = $offsetProduk_akhir->produk_offset+1;
                    } else {
                        $svProduk['produk_offset'] = 1;
                    }
                    $lastID_produk = DB::table('t_produk')->insertGetId($svProduk);
                    $list_prod[$lastID_produk] = $nama_produk;
    
                    $svVarian['produk_id'] = $lastID_produk;
					$offsetSku_akhir = DB::table('t_varian_produk')
						->where('data_of', Fungsi::dataOfCek())
						->where('produk_id', $svVarian['produk_id'])
						->select('sku_offset')
						->orderBy('sku_offset', 'desc')
						->get()->first();
					if(isset($offsetSku_akhir)){
						$svVarian['sku_offset'] = $offsetSku_akhir->sku_offset+1;
					} else {
						$svVarian['sku_offset'] = 1;
					}
                    if($sku == ''){
                        $sku = 'P'.$cekProdukDB->produk_offset.'V'.$svVarian['sku_offset'];
                    } else {
                        $cekSku = DB::table('t_varian_produk')
                            ->where("sku", $sku)
                            ->where("data_of", Fungsi::dataOfCek())
                            ->get()->first();
                            
                        if(isset($cekSku)){
                            $sku = 'P'.$cekProdukDB->produk_offset.'V'.$svVarian['sku_offset'];
                        }
                    }
                    $svVarian['sku'] = $sku;
    
                    if($svProduk['supplier_id'] == 0){
                        $stok = is_numeric($jumlah_stok) ? $jumlah_stok : 0;
                        $svVarian['stok'] = $stok."|sendiri";
                    } else {
                        $stok = is_numeric($jumlah_stok) ? $jumlah_stok : 0;
                        $svVarian['stok'] = $stok."|lain";
                    }
    
                    $svVarian['harga_beli'] = $harga_beli;
                    $svVarian['harga_jual_normal'] = $harga_jual;
                    $svVarian['harga_jual_reseller'] = $harga_reseller == '' ? null : $harga_jual;
                    $svVarian['ukuran'] = $ukuran == '' ? null : $ukuran;
                    $svVarian['warna'] = $warna == '' ? null : $warna;
    
                    $list_gambar = explode(';', $gambar);
                    $gambar_utama = null;
                    $gambar_lain = [];
                    foreach(Fungsi::genArray($list_gambar) as $l){
                        if(is_null($gambar_utama)){
                            $gambar_utama = $this->sanit_url($l);
                        } else {
                            $gambar_lain[] = $this->sanit_url($l);
                        }
                    }
                    $svVarian['foto_id'] = json_encode([
                        "utama" => $gambar_utama,
                        "lain" => implode(";", $gambar_lain)
                    ]);
                    $svVarian['data_of'] = Fungsi::dataOfCek();
                    $proses_id_varian = DB::table('t_varian_produk')->insertGetId($svVarian);
                    $riwayatStok_varian = DB::table('t_riwayat_stok')->insert([
                        "varian_id" => $proses_id_varian,
                        "tgl" => date("Y-m-d H:i:s"),
                        "ket" => "Stok Awal",
                        "jumlah" => (int)$stok,
                        "tipe" => "masuk",
                        "data_of" => Fungsi::dataOfCek()
                    ]);
                }
            }
            
        }
        Cache::forget('data_kategori_produk_lengkap_'.Fungsi::dataOfCek());
        return true;
    }

    private function cekErrorById(&$data, $cari){
        $genData = Fungsi::genArray($data);
        foreach($genData as $i => $v){
            if($v->id_untuk_validasi === $cari){
                return $v->ada_error;
            }
        }
        return 0;
    }

    private function cekDataImport($data_raw, $setelahCek = false){
        try {
            $data = decrypt($data_raw);
        } catch (DecryptException $e) {
            Cache::forget('data_import_produk_'.Fungsi::dataOfCek());
            if(!$setelahCek){
                return [
                    'json' => false
                ];
            } else {
                return redirect()->route('b.produk-index')->with(['msg_error' => "Gagal mengimport data!"]);
            }
        }
        $batas_harga = 1000000;
        // dd($data);
        $varian = [];
        $t_data = [];
        $temp_sku = [];
        $jumlah_data = 0;
        foreach(Fungsi::genArray($data) as $d_ => $d){
            $temp_sku[] = $d['sku'] ?? '';
            $dataProdukLama = 0;
            $t_data[] = $d->toArray();
            // $t_data[$d_]['id_untuk_validasi'] = ($d_+1);
            $t_data[$d_]['ada_error'] = 0;
            if(!is_null($d['nama_produk']) || $d['nama_produk'] != ''){
                $t_nama = $d['nama_produk'];
                $cekProdukLama = DB::table('t_produk')
                    ->where('data_of', Fungsi::dataOfCek())
                    ->where('nama_produk', $t_nama)
                    ->get()->first();
                if(isset($cekProdukLama)){
                    $dataProdukLama = 1;
                }
            } else {
                $t_nama = 'kosongLoorrrr';
            }
            $id_varianCek = preg_replace('/[^0-9a-zA-Z]/', '_', $t_nama);
            if(is_null($d['keterangan']) || $d['keterangan'] == ''){
                $ketCek = '';
            } else {
                $ketCek = (string)$d['keterangan'];    
            }
            if(is_null($d['berat_gram']) || $d['berat_gram'] == ''){
                $beratCek = '';
            } else {
                $beratCek = $d['berat_gram'];    
            }
            if(is_null($d['kategori_produk']) || $d['kategori_produk'] == ''){
                $kategoriProdukCek = '';
            } else {
                $kategoriProdukCek = $d['kategori_produk'];    
            }
            if(isset($varian[$id_varianCek])){
                $varian[$id_varianCek]['jumlah']++;
                $varian[$id_varianCek]['ket'][] = $ketCek;
                $varian[$id_varianCek]['berat'][] = $beratCek;
                $varian[$id_varianCek]['kategori_produk'][] = $kategoriProdukCek;
            } else {
                $varian[$id_varianCek] = [
                    'nama' => $d['nama_produk'],
                    'ket' => [$ketCek],
                    'berat' => [$beratCek],
                    'kategori_produk' => [$kategoriProdukCek],
                    'data_lama' => $dataProdukLama,
                    'jumlah' => 1
                ];
            }
            $jumlah_data++;
        }
        unset($data);
        // dd($t_data);
        $hasil = '';
        $dataSudahCek = 0;
        $adaError = 0;
        $t_data2 = [];
        foreach(Fungsi::genArray($t_data) as $i => $d){
            $sudahCek = 0;
            $listError = [];
            $dataLamaCek = 0;

            $t_data2[] = $d;

            $hasil .= '<tr id="tr-'.$d['id_untuk_validasi'].'">';

            $hasil .= '<td><input type="checkbox" class="pilihCheck bisaCek" id="pilihCheck-'.$d['id_untuk_validasi'].'"></td>';
            $hasil .= '<td>'.(is_null($d['no']) ? '' : $d['no']).'</td>';

            if(is_null($d['link_gambar']) || $d['link_gambar'] == ''){
                $kolomGambar = '';
                $sudahCek++;
            } else {
                $linkGambar = explode(';', strip_tags($d['link_gambar']));
                $cekValidGambar = 0;
                $t_linkGambar = [];
                foreach(Fungsi::genArray($linkGambar) as $l){
                    $t_linkGambar[] = $this->sanit_url($l);
                }
                foreach(Fungsi::genArray($t_linkGambar) as $l){
                    if($this->is_url($l)){
                        $cekValidGambar++;
                    }
                }
                if(count($t_linkGambar) === $cekValidGambar){
                    $kolomGambar = '<button type="button" class="btn btn-info btn-xs btnLihatGambar">Lihat Gambar</button><textarea id="gambar-'.$d['id_untuk_validasi'].'" class="hidden">'.implode(';', $t_linkGambar).'</textarea>';
                    $sudahCek++;
                } else {
                    $adaError++;
                    $t_data2[$i]['ada_error']++;
                    $listError[] = 'Link Gambar tidak valid';
                    $kolomGambar = '<div class="alert alert-danger">'.$d['link_gambar'].'</div>';
                }
            }
            $hasil .= '<td>'.$kolomGambar.'</td>';

            if(is_null($d['nama_produk']) || $d['nama_produk'] == ''){
                $id_varianCek = 'kosongLoorrrr';
                $adaError++;
                $t_data2[$i]['ada_error']++;
                $listError[] = 'Nama Produk kosong';
                $kolomProduk = '<td><div class="alert alert-danger"><br><small style="color:#888;">'.$varian[$id_varianCek]['ket'][0].'</small></div></td>';
            } else {
                if((is_null($d['ukuran']) || $d['ukuran'] == '') && (is_null($d['warna']) || $d['warna'] == '')){
                    $tampil_varianData = '';
                } else if((!is_null($d['ukuran']) || $d['ukuran'] != '') && (is_null($d['warna']) || $d['warna'] == '')){
                    $tampil_varianData = '('.trim($d['ukuran']).')';
                } else if((is_null($d['ukuran']) || $d['ukuran'] == '') && (!is_null($d['warna']) || $d['warna'] != '')){
                    $tampil_varianData = '('.trim($d['warna']).')';
                } else if((!is_null($d['ukuran']) || $d['ukuran'] != '') && (!is_null($d['warna']) || $d['warna'] != '')){
                    $tampil_varianData = '('.trim($d['warna']).' '.trim($d['ukuran']).')';
                }
                $id_varianCek = preg_replace('/[^0-9a-zA-Z]/', '_', $d['nama_produk']);
                if($varian[$id_varianCek]['jumlah'] > 1){
                    if(count(array_unique($varian[$id_varianCek]['ket'])) === 1){
                        $kolomProduk = '<td>'.$varian[$id_varianCek]['nama'].' '.$tampil_varianData.'<br><small style="color:#888;">'.$varian[$id_varianCek]['ket'][0].'</small></td>';
                    } else {
                        $kolomProduk = '<td>'.$varian[$id_varianCek]['nama'].' '.$tampil_varianData.'<br></td>';
                    }
                } else {
                    $kolomProduk = '<td>'.$varian[$id_varianCek]['nama'].' '.$tampil_varianData.'<br><small style="color:#888;">'.$varian[$id_varianCek]['ket'][0].'</small></td>';
                }
                $dataLamaCek = $varian[$id_varianCek]['data_lama'];
                $sudahCek++;
            }
            $hasil .= $kolomProduk;

            $cekErrorSkuKategori = 0;
            if(is_null($d['sku']) || $d['sku'] == ''){
                $adaError++;
                $t_data2[$i]['ada_error']++;
                $listError[] = 'SKU kosong';
                $hasilCekSku = '';
                $cekErrorSkuKategori++;
            } else {
                $cekSKU = DB::table('t_varian_produk')
                    ->where('data_of', Fungsi::dataOfCek())
                    ->where('sku', $d['sku'])
                    ->get()->first();
                    // dd($temp_sku);
                    $cekJumlahTempSku = array_count_values($temp_sku);
                if(
                    (
                        (
                            isset($cekSKU) || (
                                in_array($d['sku'], $temp_sku) && $cekJumlahTempSku[$d['sku']] > 1
                            )
                        ) && $dataLamaCek === 0
                    ) || (
                            in_array($d['sku'], $temp_sku) && $cekJumlahTempSku[$d['sku']] > 1 && $dataLamaCek === 1
                    )
                ){
                    $adaError++;
                    $t_data2[$i]['ada_error']++;
                    $listError[] = 'SKU sudah terpakai';
                    $hasilCekSku = $d['sku'];
                    $cekErrorSkuKategori++;
                } else {
                    $hasilCekSku = $d['sku'];
                    $sudahCek++;
                }
                $temp_sku[] = $d['sku'];
            }
            if(is_null($d['kategori_produk']) || $d['kategori_produk'] == ''){
                $hasilCekKategori= '';
                $sudahCek++;
            } else {
                $id_varianCek = preg_replace('/[^0-9a-zA-Z]/', '_', $d['nama_produk']);
                if($varian[$id_varianCek]['jumlah'] > 1){
                    if(count(array_unique($varian[$id_varianCek]['kategori_produk'])) === 1){
                        $hasilCekKategori = $d['kategori_produk'];
                        $sudahCek++;
                    } else {
                        $adaError++;
                        $t_data2[$i]['ada_error']++;
                        $cekErrorSkuKategori++;
                        $listError[] = 'Kategori Produk harus sama';
                        $hasilCekKategori = $d['kategori_produk'];
                    }
                } else {
                    $hasilCekKategori = $d['kategori_produk'];
                    $sudahCek++;
                }
            }
            if($cekErrorSkuKategori > 0){
                $kolomSkuKategori = '<td><div class="alert alert-danger">'.$hasilCekSku.'<br>'.$hasilCekKategori.'</div></td>';
            } else {
                $kolomSkuKategori = '<td>'.$hasilCekSku.'<br>'.$hasilCekKategori.'</td>';
            }
            $hasil .= $kolomSkuKategori;

            if(is_null($d['supplier']) || $d['supplier'] == ''){
                $sudahCek++;
                $kolomSupplier = '<td></td>';
            } else {
                $cekSupplier = DB::table('t_supplier')
                    ->where('data_of', Fungsi::dataOfCek())
                    ->where('nama_supplier', $d['supplier'])
                    ->get()->first();
                if(isset($cekSupplier)){
                    $sudahCek++;
                    $kolomSupplier = '<td>'.ucwords(strtolower($d['supplier'])).'</td>';
                } else {
                    $adaError++;
                    $t_data2[$i]['ada_error']++;
                    $listError[] = 'Supplier dengan nama tersebut tidak ditemukan';
                    $kolomSupplier = '<td><div class="alert alert-danger">'.ucwords(strtolower($d['supplier'])).'</div></td>';
                }
            }
            $hasil .= $kolomSupplier;

            if(is_null($d['harga_beli']) || $d['harga_beli'] == ''){
                $adaError++;
                $t_data2[$i]['ada_error']++;
                $listError[] = 'Harga Beli kosong';
                $kolomHargaBeli = '<td><div class="alert alert-danger"></div></td>';
            } else {
                $harga_beli = preg_replace('/[^0-9]/', '', $d['harga_beli']);
                $harga_beli = (int)$harga_beli;
                if($harga_beli > $batas_harga){
                    $adaError++;
                    $t_data2[$i]['ada_error']++;
                    $listError[] = 'Harga Beli tidak boleh lebih dari 1,000,000';
                    $kolomHargaBeli = '<td><div class="alert alert-danger">'.Fungsi::uangFormat($harga_beli, true).'</div></td>';
                } else {
                    $kolomHargaBeli = '<td>'.Fungsi::uangFormat($harga_beli, true).'</td>';
                    $sudahCek++;
                }
            }
            $hasil .= $kolomHargaBeli;

            if(is_null($d['harga_jual']) || $d['harga_jual'] == ''){
                $adaError++;
                $t_data2[$i]['ada_error']++;
                $listError[] = 'Harga Jual kosong';
                $kolomHargaJual = '<td><div class="alert alert-danger"></div></td>';
            } else {
                $harga_jual = preg_replace('/[^0-9]/', '', $d['harga_jual']);
                $harga_jual = (int)$harga_jual;
                if($harga_jual > $batas_harga){
                    $adaError++;
                    $t_data2[$i]['ada_error']++;
                    $listError[] = 'Harga Jual tidak boleh lebih dari 1,000,000';
                    $kolomHargaJual = '<td><div class="alert alert-danger">'.Fungsi::uangFormat($harga_jual, true).'</div></td>';
                } else {
                    $kolomHargaJual = '<td>'.Fungsi::uangFormat($harga_jual, true).'</td>';
                    $sudahCek++;
                }
            }
            $hasil .= $kolomHargaJual;

            if(is_null($d['harga_reseller']) || $d['harga_reseller'] == ''){
                if(is_null($d['harga_jual']) || $d['harga_jual'] == ''){
                    $adaError++;
                    $t_data2[$i]['ada_error']++;
                    $kolomHargaReseller = '<td><div class="alert alert-danger"></div></td>';
                } else {
                    $harga_jual = preg_replace('/[^0-9]/', '', $d['harga_jual']);
                    $harga_jual = (int)$harga_jual;
                    $kolomHargaReseller = '<td>'.Fungsi::uangFormat($harga_jual, true).'</td>';
                }
                $sudahCek++;
            } else {
                $harga_reseller = preg_replace('/[^0-9]/', '', $d['harga_reseller']);
                $harga_reseller = (int)$harga_reseller;
                if($harga_reseller > $batas_harga){
                    $adaError++;
                    $t_data2[$i]['ada_error']++;
                    $listError[] = 'Harga Reseller tidak boleh lebih dari 1,000,000';
                    $kolomHargaReseller = '<td><div class="alert alert-danger">'.Fungsi::uangFormat($harga_reseller, true).'</div></td>';
                } else {
                    $kolomHargaReseller = '<td>'.Fungsi::uangFormat($harga_reseller, true).'</td>';
                    $sudahCek++;
                }
            }
            $hasil .= $kolomHargaReseller;

            if(is_null($d['berat_gram']) || $d['berat_gram'] == ''){
                $adaError++;
                $t_data2[$i]['ada_error']++;
                $listError[] = 'Berat kosong';
                $kolomBerat = '<td><div class="alert alert-danger"></div></td>';
            } else {
                $id_varianCek = preg_replace('/[^0-9a-zA-Z]/', '_', $d['nama_produk']);
                if($varian[$id_varianCek]['jumlah'] > 1){
                    if(count(array_unique($varian[$id_varianCek]['berat'])) === 1){
                        if(is_numeric($varian[$id_varianCek]['berat'][0])){
                            $kolomBerat = '<td>'.Fungsi::uangFormat($varian[$id_varianCek]['berat'][0]).'</td>';
                            $sudahCek++;
                        } else {
                            $adaError++;
                            $t_data2[$i]['ada_error']++;
                            $listError[] = 'Berat harus angka';
                            $kolomBerat = '<td><div class="alert alert-danger">'.$d['berat_gram'].'</div></td>';
                        }
                    } else {
                        if(is_numeric($d['berat_gram'])){
                            $adaError++;
                            $t_data2[$i]['ada_error']++;
                            $listError[] = 'Berat harus sama';
                            $kolomBerat = '<td><div class="alert alert-danger">'.Fungsi::uangFormat($d['berat_gram']).'</div></td>';
                        } else {
                            $adaError++;
                            $t_data2[$i]['ada_error']++;
                            $listError[] = 'Berat harus angka';
                            $kolomBerat = '<td><div class="alert alert-danger">'.$d['berat_gram'].'</div></td>';
                        }
                    }
                } else {
                    if(is_numeric($varian[$id_varianCek]['berat'][0])){
                        $kolomBerat = '<td>'.Fungsi::uangFormat($varian[$id_varianCek]['berat'][0]).'</td>';
                        $sudahCek++;
                    } else {
                        $adaError++;
                        $t_data2[$i]['ada_error']++;
                        $listError[] = 'Berat harus angka';
                        $kolomBerat = '<td><div class="alert alert-danger">'.$d['berat_gram'].'</div></td>';
                    }
                }
            }
            $hasil .= $kolomBerat;
            
            if(is_null($d['jumlah_stok']) || $d['jumlah_stok'] == ''){
                $adaError++;
                $t_data2[$i]['ada_error']++;
                $listError[] = 'Jumlah Stok kosong';
                $kolomStok = '<td><div class="alert alert-danger"></div></td>';
            } else {
                if(is_numeric($d['jumlah_stok'])){
                    $kolomStok = '<td>'.Fungsi::uangFormat((float)$d['jumlah_stok']).'</td>';
                    $sudahCek++;
                } else {
                    $adaError++;
                    $t_data2[$i]['ada_error']++;
                    $listError[] = "Jumlah Stok harus angka";
                    $kolomStok = '<td><div class="alert alert-danger">'.((string)$d['jumlah_stok']).'</div></td>';
                }
            }
            $hasil .= $kolomStok;

            if(count($listError) > 0){
                $tampil_error = '<ul><li>'.implode('</li><li>', $listError).'</li></ul>';
                $hasil .= '<td><div class="alert alert-danger">'.$tampil_error.'</div></td>';
            } else {
                if($dataLamaCek === 0){
                    $hasil .= '<td><div class="alert alert-success">Data baru (Data bisa ditambahkan)</div></td>';
                } else {
                    $hasil .= '<td><div class="alert alert-warning">Data sudah ada (Data akan ditambah di varian)</div></td>';
                }
            }

            $hasil .= '</tr>';
            if($sudahCek === 10){
                $dataSudahCek++;
            }
        }
        unset($t_data);
        // dd($t_data2);
        if(!$setelahCek){
            $returnHasil['data'] = $hasil;
            $returnHasil['error'] = $adaError;
            $returnHasil['json'] = json_encode($t_data2);
            if($dataSudahCek === $jumlah_data && $adaError === 0){
                $returnHasil['cek'] = 1;
            } else {
                $returnHasil['cek'] = 0;
            }
        } else {
            $returnHasil = json_encode($t_data2);
        }
        return $returnHasil;
    }

    private function is_url($uri){
        if(filter_var($uri, FILTER_VALIDATE_URL) === false){
            return false;
        } else{
            return true;
        }
    }

    private function sanit_url($uri){
        return filter_var($uri, FILTER_SANITIZE_URL);
    }
    
    public function templateProduk(Request $request){
        $file = base_path('../public/excel/template_produk.xlsx');
        return response()->download($file);
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
				$ijin->uploadProdukExcel = 1;
			}
        } else {
            $ijin = new \stdclass();
            $ijin->uploadProdukExcel = 0;
        }
        return [$data_user, $ijin];
    }
}