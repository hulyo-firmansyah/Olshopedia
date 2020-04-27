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

class CustomerController extends Controller
{
	public function __construct(){
		$this->middleware('b.auth');
		$this->middleware('xss_protect');
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
				$ijin->downloadExcel = 1;
				$ijin->hapusCustomer = 1;
				$ijin->editCustomer = 1;
			}
        } else {
            $ijin = new \stdclass();
            $ijin->uploadProdukExcel = 0;
            $ijin->downloadExcel = 0;
            $ijin->hapusCustomer = 0;
            $ijin->editCustomer = 0;
        }
        return [$data_user, $ijin];
    }
	
  	public function index(Request $request, Fungsi $fungsi)
  	{
        list($data_user, $ijin) = $this->getIjinUser();
		$pass = Fungsi::acakPass();
		$wilayah_indonesia = json_encode(json_decode(Fungsi::getContent('data/wilayah_indonesia.json')));
		if ($request->ajax()) {
			return Fungsi::respon('belakang.customer.semua', compact('wilayah_indonesia', 'pass', 'data_user', 'ijin'), "ajax", $request);
		}
		return Fungsi::respon('belakang.customer.semua', compact('wilayah_indonesia', 'pass', 'data_user', 'ijin'), "html", $request);
	}
	  
	public function redirectIndex(){
		return redirect()->route("b.customer-index");
	}

	public function historyIndex(Request $request, $id_user = null){
		if(is_null($id_user) || preg_match("/\D/", $id_user)){
            return redirect()->route('b.customer-index');
		}
		$query = strip_tags($id_user);
		$data_cust = DB::table('users')->join("t_customer", "t_customer.user_id", "=", "users.id")->select('name', 'id')->where("users.id", $query)->get();
		// dd($data_cust);
		$objData = DB::table('t_order')->where("data_of", Fungsi::dataOfCek())->where("canceled", 0);
		if(count($data_cust) == 0){
			return redirect()->route('b.customer-index');
		} else {
			$nama = $data_cust[0]->name;
			$tempObj = [];
			foreach(Fungsi::genArray($data_cust) as $i => $c){
				if($i == 0){
					$tempObj[$i] = $objData->where("pemesan_id", $c->id);
					$tempObj[$i] = $objData->orWhere("tujuan_kirim_id", $c->id);
				} else {
					$tempObj[$i] = $tempObj[$i-1]->orWhere("pemesan_id", $c->id);
					$tempObj[$i] = $tempObj[$i-1]->orWhere("tujuan_kirim_id", $c->id);
					unset($tempObj[$i-1]);
				}
			}
			$data_cust_count = count($data_cust);
			unset($data_cust);
			$data_all = $tempObj[$data_cust_count-1]->orderBy("id_order", "asc");
			$data_ordAll = $data_all->get();
			$data_order = $data_all->paginate(10);
			unset($tempObj, $objData);
		}
		$jumlah_prod = 0;
		$order = [];
		foreach(Fungsi::genArray($data_order) as $iO => $vO){
			$order[$iO] = "<tr>";
			$order[$iO] .= "<td>".($iO+1)."</td>";
			$order[$iO] .= "<td>".$vO->tanggal_order."</td>";
			$order[$iO] .= "<td><a style='text-decoration:none;' href='javscript:void(0)' onClick='pageLoad(\"".route('b.order-detail', ['id_order' => $vO->id_order])."\")'>Order #".$vO->urut_order."</a></td>";
			$order[$iO] .= "<td><ul>";
			$prod = json_decode($vO->produk);
			foreach(Fungsi::genArray($prod->list) as $iP => $vP){
				$order[$iO] .= "<li>".$vP->rawData->nama_produk." <span class='text-muted'>x ".$vP->jumlah."</span>";
			}
			$order[$iO] .= "</ul></td>";
			$order[$iO] .= "<td>".Fungsi::uangFormat(json_decode($vO->total)->hargaProduk, true)."</td>";
			$order[$iO] .= "</tr>";
		}
		foreach(Fungsi::genArray($data_ordAll) as $iR => $vR){
			$prod = json_decode($vR->produk);
			foreach(Fungsi::genArray($prod->list) as $iP => $vP){
				$jumlah_prod += (int)$vP->jumlah;
			}
		}
		unset($data_ordAll);
		// return;
		if ($request->ajax()) {
			return Fungsi::respon('belakang.customer.history', compact('data_order', 'nama', 'jumlah_prod', 'order'), "ajax", $request);
		}
		return Fungsi::respon('belakang.customer.history', compact('data_order', 'nama', 'jumlah_prod', 'order'), "html", $request);
	}

  	public function store(Request $request)
  	{
		// return "<pre>".print_r($request->all(), true).' '.((isset($request->emailC))." ".($request->emailC === ''))."</pre>";
		if($request->ajax()){
			if(isset($request->emailC) && $request->emailC !== ''){
				if(!isset($request->passwordC) || $request->passwordC === ''){
					return response()->json(['status' => false, 'msg' => 'Password belum diisi!']);
				} else {
					$cekEmail = DB::table('users')->where("users.email", $request->emailC)->get()->first();
					if(isset($cekEmail)){
						return response()->json(['status' => false, 'msg' => 'Email telah digunakan!']);
					}
					$lastUser_id = DB::table('users')->insertGetId([
						'name' => $request->namaC,
						'email' => $request->emailC,
						'no_telp' => $request->no_telpC,
						'password' => Hash::make($request->passwordC),
					]);
				}
			} else {
				$data_t = 'kosong|'.str_random();
				$lastUser_id = DB::table('users')->insertGetId([
					'name' => $request->namaC,
					'email' => $data_t,
					'no_telp' => $request->no_telpC,
					'password' => Hash::make($data_t),
				]);
			}
			$customer = DB::table('t_customer')->insert([
				'user_id' => $lastUser_id,
				'kategori' => $request->kategoriC,
				'provinsi' => $request->provinsiC,
				'kabupaten' => $request->kabupatenC,
				'kecamatan' => $request->kecamatanC,
				'kode_pos' => $request->kode_posC,
				'alamat' => $request->alamatC,
				'data_of' => Fungsi::dataOfCek()
			]);
			Cache::forget('data_customer_analisa_'.Fungsi::dataOfCek());
			Cache::forget('data_customer_lengkap_'.Fungsi::dataOfCek());
			Cache::forget('data_laporan_'.Fungsi::dataOfCek());
			Cache::forget('data_user_pengaturan_'.Fungsi::dataOfCek());
			if ($customer && $lastUser_id) {
				event(new BelakangLogging(Fungsi::dataOfCek(), 'tambah_customer', [
					'user_id' => Auth::user()->id,
					'kategori' => $request->kategoriC,
					'nama' => $request->namaC,
				]));
				return response()->json(['status' => true]);
			} else {
				return response()->json(['status' => false, 'msg' => 'Gagal Menambahkan Customer!']);
			}
		} else {
			abort(404);
		}
  	}

  	public function edit(Request $request)
  	{
		list($data_user, $ijin) = $this->getIjinUser();
		if(($ijin->editCustomer === 1 && $data_user->role == 'Admin') || $data_user->role == 'Owner'){
			$customer = DB::table('t_customer')
				->join('users', 'users.id', '=', 't_customer.user_id')
				->select('users.id', 'users.name', 'users.email', 'users.no_telp', 't_customer.provinsi', 't_customer.kabupaten', 't_customer.kecamatan', 't_customer.kode_pos', 't_customer.alamat', 't_customer.kategori')
				->where('t_customer.user_id', $request->id)
				->where('t_customer.data_of', Fungsi::dataOfCek())
				->get()->first();
			if ($request->ajax()) {
				return Fungsi::respon($customer, [], "json", $request);
			} else {
				abort(404);
			}
		} else {
			return redirect()->route('b.customer-index');
		}
  	}

  	public function update(Request $request)
  	{
		list($data_user, $ijin) = $this->getIjinUser();
		if(($ijin->editCustomer === 1 && $data_user->role == 'Admin') || $data_user->role == 'Owner'){
			$cekEmail = DB::table('users')
				->where("email", $request->emailC_edit)
				->where("id", '!=', $request->id_cust)
				->get()->first();
			if(isset($cekEmail)){
				return response()->json(['status' => false, 'msg' => 'Email telah digunakan!']);
			}
			$customer = DB::table('t_customer')      
				->where('user_id', $request->id_cust)
				->update([
					'kategori' => $request->kategoriC_edit,
					'provinsi' => $request->provinsiC_edit,
					'kabupaten' => $request->kabupatenC_edit,
					'kecamatan' => $request->kecamatanC_edit,
					'kode_pos' => $request->kode_posC_edit,
					'alamat' => $request->alamatC_edit
				]);
			$user = DB::table('users')
				->where('id', $request->id_cust)
				->update([
					'name' => $request->namaC_edit,
					'email' => $request->emailC_edit,  
					'no_telp' => $request->no_telpC_edit,    
				]);
			Cache::forget('data_customer_analisa_'.Fungsi::dataOfCek());
			Cache::forget('data_customer_lengkap_'.Fungsi::dataOfCek());
			Cache::forget('data_laporan_'.Fungsi::dataOfCek());
			Cache::forget('data_user_pengaturan_'.Fungsi::dataOfCek());
			if ($customer || $user) {
				event(new BelakangLogging(Fungsi::dataOfCek(), 'edit_customer', [
					'user_id' => Auth::user()->id,
					'kategori' => $request->kategoriC_edit,
					'nama' => $request->namaC_edit,
				]));
				return response()->json(['status' => true]);
			} else {
				return response()->json(['status' => false, 'msg' => "Gagal mengedit Customer!"]);
			}
		}
  	}

  	public function destroy(Request $request)
  	{
		list($data_user, $ijin) = $this->getIjinUser();
		if(($ijin->hapusCustomer === 1 && $data_user->role == 'Admin') || $data_user->role == 'Owner'){
			$get_name = DB::table('users')->where('id', $request->id)->select('name')->get()->first();
			$get_kategori = DB::table('t_customer')->where('user_id', $request->id)->select('kategori')->get()->first();
			$proses1 = DB::table('t_customer')->where('user_id', $request->id)->delete();
			$proses2 = DB::table('users')->where('id', $request->id)->delete();
			Cache::forget('data_customer_analisa_'.Fungsi::dataOfCek());
			Cache::forget('data_customer_lengkap_'.Fungsi::dataOfCek());
			Cache::forget('data_laporan_'.Fungsi::dataOfCek());
			Cache::forget('data_user_pengaturan_'.Fungsi::dataOfCek());
			if ($proses1 && $proses2) {
				event(new BelakangLogging(Fungsi::dataOfCek(), 'hapus_customer', [
					'user_id' => Auth::user()->id,
					'kategori' => $get_kategori->kategori,
					'nama' => $get_name->name,
				]));
				return response()->json(['sukses' => true]);
			} else {
				return response()->json(['sukses' => false, 'msg' => 'Gagal menghapus data!']);
			}
		} else {
			return redirect()->route('b.customer-index');
		}
  	}
  
  	public function getCustomer(Request $request)
  	{
		if($request->ajax()){
			list($data_user, $ijin) = $this->getIjinUser();
			$customer = Cache::remember('data_customer_lengkap_'.Fungsi::dataOfCek(), 10000, function(){
				return DB::table('t_customer')
					->join('users', 't_customer.user_id', '=', 'users.id')
					->select('t_customer.*', 'users.*')->where('t_customer.data_of', Fungsi::dataOfCek())
					->get();
			});
			$data = [];
			$no = 0;
			foreach ($customer as $row) {      
				$data[$no] = [
					($no+1),
					$row->name . "<br><span style='color:#888;'>" . $row->email . "</span>",
					$row->kategori,
					$row->no_telp,
					$row->alamat . ", " . $row->kecamatan . ", " . $row->kabupaten . ", " . $row->provinsi . ", "  . $row->kode_pos
				];
				if((($ijin->hapusCustomer === 1 || $ijin->editCustomer === 1) && $data_user->role == 'Admin') || $data_user->role == 'Owner'){
					$tampil_btn = "<input type='hidden' name='valID' value='" . $row->user_id . "'>";
					if($ijin->editCustomer === 1){
						$tampil_btn .= "<button type='button' data-target='#modEdit' data-toggle='modal' id class='btn btn-warning btn-sm' onClick='$(this).editC()'>Edit</button>";
					}
					if($ijin->hapusCustomer === 1){
						$tampil_btn .= "&nbsp;&nbsp;<button type='button' class='btn btn-danger btn-sm' onClick='$(this).hapusC(tabelData);'>Hapus</button>";
					}
					$data[$no][] = $tampil_btn;
				} else {
					$data[$no][] = "<input type='hidden' name='valID' value='" . $row->user_id . "'>";
				}
				$no++;
			}
			$result['data'] = $data;
			return Fungsi::respon($result, [], "json", $request);
		} else {
			abort(404);
		}
  	}

}