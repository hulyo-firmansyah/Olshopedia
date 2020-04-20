<?php

namespace App\Http\Controllers\belakang;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use App\Events\BelakangLogging;
use App\Http\Controllers\PusatController as Fungsi;
use Illuminate\Support\Facades\Storage;

class SupplierController extends Controller
{
	public function __construct(){
		$this->middleware('b.auth');
		$this->middleware('xss_protect');
    }
    
    public function index(Request $request, Fungsi $fungsi)
    {
        $wilayah_indonesia = json_decode(Fungsi::getContent('data/wilayah_indonesia.json'));
        if ($request->ajax()) {
            return Fungsi::respon('belakang.supplier.index', compact('wilayah_indonesia'), "ajax", $request);
        }
        return Fungsi::respon('belakang.supplier.index', compact('wilayah_indonesia'), "html", $request);
    }
    
    public function redirectIndex(){
        return redirect()->route("b.supplier-index");
    }

    public function getData(Request $request){
        if($request->ajax()){
            if(isset($request->v)){
                $supplier = DB::table('t_supplier')
                    ->where('id_supplier', $request->v)
                    ->where('t_supplier.data_of', Fungsi::dataOfCek())
                    ->get()->first();
                return Fungsi::respon($supplier, [], 'json', $request);
            }
            $supplier = Cache::remember('data_supplier_pengaturan_'.Fungsi::dataOfCek(), 10000, function(){
                return DB::table('t_supplier')
                    ->where('t_supplier.data_of', Fungsi::dataOfCek())
                    ->get();
            });
            $data = [];
            $no = 0;
            // dd($supplier);
            foreach (Fungsi::genArray($supplier) as $row ) {
                $alamat = $row->kecamatan.", ".$row->kabupaten.", ".$row->provinsi." (".$row->kode_pos.")";
                $data[$no++] = [
                    '',
                    $row->nama_supplier. "<br><small class='text-muted'>" . $row->ket . "</small>",
                    $alamat,
                    $row->no_telp == '' ? '-' : $row->no_telp,
                    $row->jalan,
                    "<input type='hidden' name='getSuppId' id='get-id' value='".$row->id_supplier."'>
                    <button type='button' data-target='#editSupplier' data-toggle='modal' class='btn btn-warning btn-xs' data-id='".$row->id_supplier."' onClick='$(this).editSupplier(tabelDataSupplier)'>Edit</button>
                    <button type='button' class='btn btn-danger btn-xs' data-id='".$row->id_supplier."' onClick='$(this).hapusSupplier(tabelDataSupplier);'>Hapus</button>",
                ];
            }
            $result['data'] = $data;
            return Fungsi::respon($result, [], 'json', $request);
        } else {
            abort(404);
        }
    }

    public function proses(Request $request){
        switch($request->tipe){
            case 'tambah':
                $supplier = DB::table('t_supplier')->insert([
                    'nama_supplier' => strip_tags($request->nama),
                    'provinsi' => strip_tags($request->provinsi),
                    'kabupaten' => strip_tags($request->kabupaten),
                    'kecamatan' => strip_tags($request->kecamatan),
                    'jalan' => strip_tags($request->alamat),
                    'kode_pos' => strip_tags($request->kode_pos),
                    'no_telp' => strip_tags($request->no_telp),
                    'ket' => strip_tags($request->ket),
                    'data_of' => Fungsi::dataOfCek(),
                ]);
                Cache::forget('data_supplier_pengaturan_'.Fungsi::dataOfCek());
                if ($supplier) {
                    return Fungsi::respon(['status' => true], [], 'json', $request);
                } else {
                    return Fungsi::respon(['status' => false, 'msg' => "Gagal Menambahkan Supplier!"], [], 'json', $request);
                }
                break;

            case 'edit':
                $supplier = DB::table('t_supplier')
                    ->where("id_supplier", $request->id)
                    ->where("data_of", Fungsi::dataOfCek())
                    ->update([
                        'nama_supplier' => strip_tags($request->nama),
                        'provinsi' => strip_tags($request->provinsi),
                        'kabupaten' => strip_tags($request->kabupaten),
                        'kecamatan' => strip_tags($request->kecamatan),
                        'jalan' => strip_tags($request->alamat),
                        'kode_pos' => strip_tags($request->kode_pos),
                        'no_telp' => strip_tags($request->no_telp),
                        'ket' => strip_tags($request->ket),
                    ]);
                Cache::forget('data_supplier_pengaturan_'.Fungsi::dataOfCek());
                if ($supplier) {
                    return Fungsi::respon(['status' => true], [], 'json', $request);
                } else {
                    return Fungsi::respon(['status' => false, 'msg' => "Gagal Mengedit Supplier!"], [], 'json', $request);
                }
                break;

            case 'hapus':
                $proses1 = DB::table('t_supplier')
                    ->where('id_supplier', $request->id)
                    ->where('data_of', Fungsi::dataOfCek())
                    ->delete();
                Cache::forget('data_supplier_pengaturan_'.Fungsi::dataOfCek());
                if($proses1){
                    return Fungsi::respon(['sukses' => true], [], 'json', $request);
                } else {
                    return Fungsi::respon(['sukses' => false, 'msg' => 'Gagal menghapus data!'], [], 'json', $request);
                }
                break;

            default:
                return Fungsi::respon(['status' => false, 'msg' => "Salah route!"], [], 'json', $request);
                break;
        }
    }
}