<?php

namespace App\Http\Controllers\belakang;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\PusatController as Fungsi;
use App\Imports\ExpenseImport;
use Excel;

class ExpenseController extends Controller
{
	public function __construct(){
		$this->middleware(['b.auth', 'xss_protect', 'b.ijin-menuExpense', 'b.cekDataToko']);
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
				$ijin->hapusProduk = 1;
				$ijin->uploadProdukExcel = 1;
				$ijin->downloadExcel = 1;
			}
        } else {
            $ijin = new \stdclass();
            $ijin->hapusProduk = 0;
            $ijin->uploadProdukExcel = 0;
            $ijin->downloadExcel = 0;
		}
		if($request->ajax()){
			// return Fungsi::parseAjax('belakang.expense');
			return Fungsi::respon('belakang.expense.semua', compact('data_user', 'ijin'), "ajax", $request);
		}
		// return view('belakang.expense');
		return Fungsi::respon('belakang.expense.semua', compact('data_user', 'ijin'), "html", $request);
	}
	
	
    public function prosesExpense(Request $request){
		switch($request->tipe){
			case "tambah":
				$proses = DB::table('t_expense')->insert([
					'tanggal' => $request->tanggal,
					'nama_expense' => $request->nama_p,
					'harga' => $request->harga,
					'jumlah' => $request->jumlah,
					'note' => ($request->note=='') ? '' : $request->note,
					'data_of' => Fungsi::dataOfCek()
				]);
				Cache::forget('data_expense_lengkap_'.Fungsi::dataOfCek());
				Cache::forget('data_laporan_'.Fungsi::dataOfCek());
				if($proses){
					return response()->json(['sukses' => true]);
				} else {
					return response()->json(['sukses' => false, 'msg' => 'Gagal menambahkan data!']);
				}
				break;
				
			case "edit":
				$proses = DB::table('t_expense')->where('id_expense', $request->id_expense)->where('data_of', Fungsi::dataOfCek())->update([
					'tanggal' => $request->tanggal,
					'nama_expense' => $request->nama_p,
					'harga' => $request->harga,
					'jumlah' => $request->jumlah,
					'note' => $request->note
				]);
				Cache::forget('data_expense_lengkap_'.Fungsi::dataOfCek());
				Cache::forget('data_laporan_'.Fungsi::dataOfCek());
				if($proses){
					return response()->json(['sukses' => true]);
				} else {
					return response()->json(['sukses' => false, 'msg' => 'Gagal mengedit data!']);
				}
				break;
				
			case "hapus":
				$proses = DB::table('t_expense')->where('id_expense', $request->id_expense)->where('data_of', Fungsi::dataOfCek())->delete();
				Cache::forget('data_expense_lengkap_'.Fungsi::dataOfCek());
				Cache::forget('data_laporan_'.Fungsi::dataOfCek());
				if($proses){
					return response()->json(['sukses' => true]);
				} else {
					return response()->json(['sukses' => false, 'msg' => 'Gagal menghapus data!']);
				}
				break;
				
		}
	}
	
	public function getExpense(Request $request){
		if($request->ajax()){
			$expense = Cache::remember('data_expense_lengkap_'.Fungsi::dataOfCek(), 10000, function(){
				return DB::table('t_expense')->where('data_of', Fungsi::dataOfCek())->get();
			});
			$data = [];
			$i = 0;
			foreach($expense as $k){
				$sub = $k->harga * $k->jumlah;
				$data[$i++] = [
					$k->tanggal,
					$k->nama_expense."<br><small style='color:#888;'>".$k->note."</small>",
					Fungsi::uangFormat($k->harga, true),
					Fungsi::uangFormat($k->jumlah, true),
					Fungsi::uangFormat($sub, true),
					"<input type='hidden' name='valID' value='".$k->id_expense."'>
					<button type='button' data-target='#modEdit' data-toggle='modal' class='btn btn-warning btn-sm' onClick='$(this).editE()'><i class='fa fa-pencil'></i> Edit</button>
					<button type='button' class='btn btn-danger btn-sm' onClick='$(this).hapusE(tabelData);'><i class='fa fa-trash'></i> Hapus</button>"
				];
			}
			$h['data'] = $data; 
			return Fungsi::respon($h, [], "json", $request);
		}
	}

}
