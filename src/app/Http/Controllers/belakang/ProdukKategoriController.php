<?php
namespace App\Http\Controllers\belakang;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Controllers\PusatController as Fungsi;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;
use App\Events\BelakangLogging;
use \stdClass;


class ProdukKategoriController extends Controller
{
	public function __construct(){
		$this->middleware(['b.auth', 'b.locale', 'xss_protect', 'b.cekDataToko']);
	}
    
    public function produkKategoriIndex(Request $request){
		if($request->ajax()){
			return Fungsi::respon('belakang.produk-kategori', [], "ajax", $request);
		}
		return Fungsi::respon('belakang.produk-kategori', [], "html", $request);
	}
	
    public function prosesProdukKategori(Request $request){
		switch($request->tipe){
			case "tambah":
				$cekKategori = DB::table('t_kategori_produk')
					->where('data_of', Fungsi::dataOfCek())
					->where('nama_kategori_produk', $request->nama_kategori_produk)
					->get()->first();
				if(isset($cekKategori)){
					return response()->json(['sukses' => false, 'msg' => __('produk_kategori.swal.sudah_ada.msg_tambah')]);
				}
				$proses = DB::table('t_kategori_produk')->insert([
					'nama_kategori_produk' => $request->nama_kategori_produk,
					'data_of' => Fungsi::dataOfCek()
				]);
				Cache::forget('data_kategori_produk_lengkap_'.Fungsi::dataOfCek());
				if($proses){
					event(new BelakangLogging(Fungsi::dataOfCek(), 'tambah_kategori_produk', [
						'user_id' => Auth::user()->id,
						'nama_kategori' => ucwords(strtolower($request->nama_kategori_produk))
					]));
					return response()->json(['sukses' => true]);
				} else {
					return response()->json(['sukses' => false, 'msg' => __('produk_kategori.swal.gagal.msg_tambah')]);
				}
				break;
				
			case "edit":
				$cekKategori = DB::table('t_kategori_produk')
					->where('data_of', Fungsi::dataOfCek())
					->where('nama_kategori_produk', $request->nama_kategori_produkE)
					->get()->first();
				if(isset($cekKategori)){
					return response()->json(['sukses' => false, 'msg' => __('produk_kategori.swal.sudah_ada.msg_edit')]);
				}
				$proses = DB::table('t_kategori_produk')->where('id_kategori_produk', $request->id_kategori_produkE)->where('data_of', Fungsi::dataOfCek())->update([
					'nama_kategori_produk' => $request->nama_kategori_produkE
				]);
				Cache::forget('data_kategori_produk_lengkap_'.Fungsi::dataOfCek());
				if($proses){
					event(new BelakangLogging(Fungsi::dataOfCek(), 'edit_kategori_produk', [
						'user_id' => Auth::user()->id,
						'nama_kategori' => ucwords(strtolower($request->nama_kategori_produkE))
					]));
					return response()->json(['sukses' => true]);
				} else {
					return response()->json(['sukses' => false]);
				}
				break;
				
			case "hapus":
                $nama_kategori = DB::table('t_kategori_produk')->where('id_kategori_produk', $request->id_kategori_produkH)->where('data_of', Fungsi::dataOfCek())->select('nama_kategori_produk')->get()->first();
				$proses = DB::table('t_kategori_produk')->where('id_kategori_produk', $request->id_kategori_produkH)->where('data_of', Fungsi::dataOfCek())->delete();
				Cache::forget('data_kategori_produk_lengkap_'.Fungsi::dataOfCek());
				if($proses){
					event(new BelakangLogging(Fungsi::dataOfCek(), 'hapus_kategori_produk', [
						'user_id' => Auth::user()->id,
						'nama_kategori' => ucwords(strtolower($nama_kategori->nama_kategori_produk))
					]));
					return response()->json(['sukses' => true]);
				} else {
					return response()->json(['sukses' => false]);
				}
				break;
				
		}
	}
	
	public function getProdukKategori(Request $request){
		if($request->ajax()){
			$kategori_produk = Cache::remember('data_kategori_produk_lengkap_'.Fungsi::dataOfCek(), 10000, function(){
				return DB::table('t_kategori_produk')->where('data_of', Fungsi::dataOfCek())->get();
			});
			$data = [];
			$i = 0;
			foreach($kategori_produk as $k){
				$data[$i++] = [
					$k->nama_kategori_produk,
					"<input type='hidden' name='valID' value='".$k->id_kategori_produk."'>
					<button type='button' data-target='#modEdit' data-toggle='modal' class='btn btn-warning btn-sm' onClick='$(this).editM()'><i class='fa fa-pencil'></i> ".__("produk_kategori.edit")."</button>
					<button type='button' class='btn btn-danger btn-sm' onClick='$(this).hapusM(tabelData);'><i class='fa fa-trash'></i> ".__("produk_kategori.hapus")."</button>"
				];
			}
			$h['data'] = $data; 
			return Fungsi::respon($h, [], "json", $request);
		}
	}
}