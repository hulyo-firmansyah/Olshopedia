<?php

namespace App\Http\Controllers\belakang;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Events\ProdukDataBerubah;
use App\Events\BelakangLogging;
use App\Http\Controllers\PusatController as Fungsi;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;
use \stdClass;

class ProdukController extends Controller
{
	public function __construct(){
		$this->middleware('b.auth');
		$this->middleware('xss_protect');
	}

    public function produkIndex(Request $request){
		$tipe = strip_tags($request->tipe) == "arsip" ? "arsip" : "semua";
		$kategori_produk = Cache::remember('data_kategori_produk_lengkap_'.Fungsi::dataOfCek(), 10000, function(){
			return DB::table('t_kategori_produk')->where('data_of', Fungsi::dataOfCek())->get();
		});
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
			return Fungsi::respon('belakang.produk.semua', compact('kategori_produk', 'tipe', 'data_user', 'ijin'), "ajax", $request);
		}
		return Fungsi::respon('belakang.produk.semua', compact('kategori_produk', 'tipe', 'data_user', 'ijin'), "html", $request);
	}

	public function redirectIndex(){
		return redirect()->route("b.produk-index");
	}
	
    public function tambahProduk(Request $request){
		$supplier = DB::table('t_supplier')
			->where('data_of', Fungsi::dataOfCek())
			->select('id_supplier', 'nama_supplier')
			->get();
		$kategori_produk = Cache::remember('data_kategori_produk_lengkap_'.Fungsi::dataOfCek(), 10000, function(){
			return DB::table('t_kategori_produk')->where('data_of', Fungsi::dataOfCek())->get();
		});
		$offsetProduk_akhir = DB::table('t_produk')
			->where('data_of', Fungsi::dataOfCek())
			->select('produk_offset')
			->orderBy('produk_offset', 'desc')
			->get()->first();
		if(isset($offsetProduk_akhir)){
			$offsetProduk = 'P'.($offsetProduk_akhir->produk_offset+1).'V1';
		} else {
			$offsetProduk = 'P1V1';
		}
		if($error_msg = $request->session()->get('msg_error')){

			$varian_form = "";
			if($request->old("sVarian") == 'on' && old('sVarian', null) != null){
				$tVarian = "";
			} else {
				$tVarian = "display:none";
			}
			if($request->old("sUkuran") == 'on' && old('sUkuran', null) != null){
				$tUkuran = "";
			} else {
				$tUkuran = "display:none";
			}
			if($request->old("sWarna") == 'on' && old('sWarna', null) != null){
				$tWarna = "";
			} else {
				$tWarna = "display:none";
			}
			if($request->old("sDiskon") == 'on' && old('sDiskon', null) != null){
				$tDiskon = "";
			} else {
				$tDiskon = "display:none";
			}
			if($request->old("tDiskon") == 'persen' && old('tDiskon', null) != null){
				$tTipeDiskon = "";
			} else {
				$tTipeDiskon = "display:none";
			}
			if($request->old("sReseller") == 'on' && old('sReseller', null) != null){
				$tReseller = "";
			} else {
				$tReseller = "display:none";
			}
			foreach(Fungsi::genArray($request->old()["produk"]) as $index => $value){
				$value_varian = $request->old()["produk"][$index];
				$stok = "<input type='text' data-rex='number' name='produk[{$index}][stok]' id='stok-{$index}' class='form-control jumlah_stok form-100' style='min-width:230px;max-width:100%;width:100%;position:relative' value='{$value_varian["stok"]}' placeholder='0' /><small id='error_stok-{$index}' class='hidden'></small>";
				if($index == 1){
					$varian_form .= <<<EOT
<tr id='idVarian-1' class='varianDiv_tetap'>
	<td>
		<!-- <input type="file" id="gambar-1" accept='image/*'
				name='produk[1][gambar]'> -->
		<button class="btn btn-success btn-block btn-outline" style='height:100%' data-target="#modTambahFoto-1" data-toggle="modal" type="button"><i class='fa fa-plus'></i> Tambahkan Foto</button>
	</td>
	<td>
		<span class="lbl">SKU</span>
		<input type="text"
			style="min-width:230px;max-width:100%;width:100%;position:relative"
			class="form-control sku form-200" name="produk[1][sku]"
			id='sku-1' value="{$value_varian['sku']}">
		<span class="lbl">Stok</span>
		<div id='stokDiv-1' class='stokDiv'>
			{$stok}
		</div>
	</td>
	<td>
		<span class="lbl">Harga Beli</span>
		<input type="text" data-rex='number' id="harga_beli-1" name='produk[1][harga_beli]'
			class="form-control harga_beli harbel1"
			onKeyDown='$(this).bersihError();errorValidasi = 0'
			onMouseDown='$(this).bersihError();errorValidasi = 0'
			style="min-width:230px;max-width:100%;width:100%;position:relative"  value="{$value_varian['harga_beli']}"/>
		<small id="error_harga_beli-1" class='hidden'></small>
		<div class='diskonDiv' style='{$tDiskon}'>
			<span>Diskon Jual</span>
			<div class="input-group"
				style="min-width:230px;max-width:100%;width:100%;position:relative">
				<input type="text" data-rex='number' class="form-control" placeholder="0"
					name='produk[1][diskon]' id="diskon-1"  value="{$value_varian['diskon']}"/>
				<div class="input-group-append diskonDiv_persen" style='{$tTipeDiskon}'>
					<span class="input-group-text">%</span>
				</div>
			</div>
		</div>
	</td>
	<td>
		<span class="lbl">Harga Jual Normal</span>
		<input type="text" data-rex='number' name='produk[1][harga_jual]' id="harga_jual-1"
			onKeyDown='$(this).bersihError("harga_jual");errorValidasi = 0'
			onMouseDown='$(this).bersihError("harga_jual");errorValidasi = 0'
			style="min-width:230px;max-width:100%;width:100%;position:relative"
			class="form-control rentangCekError" value="{$value_varian['harga_jual']}">
		<small id="error_harga_jual-1" class='hidden'></small>
		<span class="lbl resellerDiv" style='{$tReseller}'>Harga Jual
			Reseller</span>
		<input type="text" data-rex='number' name='produk[1][harga_reseller]'
			id="harga_reseller-1"
			style="min-width:230px;max-width:100%;width:100%;position:relative;{$tReseller}"
			class="form-control resellerDiv" value="{$value_varian['harga_reseller']}"/>
	</td>
	<td class='varianDiv_all' style='{$tVarian}'>
		<span class="lbl size varianDiv_ukuran"
			style='{$tUkuran}'>Ukuran</span>
		<input type="text" pattern="^[a-zA-Z0-9-/+&.() ]+$"
			name='produk[1][ukuran]' id='ukuran-1'
			style="min-width:230px;max-width:100%;width:100%;position:relative;{$tUkuran}"
			class="form-control size form-100 mbtm-10 varianDiv_ukuran"
			maxlength="150"  value="{$value_varian['ukuran']}"/>
		<span class="lbl warna varianDiv_warna"
			style='{$tWarna}'>Warna</span>
		<input type="text" pattern="^[a-zA-Z0-9-/+&.,() ]+$"
			name='produk[1][warna]' id='warna-1'
			style="min-width:230px;max-width:100%;width:100%;position:relative;{$tWarna}"
			class="form-control warna form-100 mbtm-10 varianDiv_warna"
			maxlength="150" value="{$value_varian['warna']}"/>
	</td>
	<td>
		<button
			class="btn btn-danger btn-pure icon fa fa-close varianDiv_all"
			style='{$tVarian}' type="button" id='hVarian-1'
			onClick='$(this).hapusVarian($(this).attr("id"))'>
		</button>
	</td>
</tr>
EOT
;
				} else {
					$varian_form .= <<<EOT
<tr id='idVarian-{$index}' class='varianDiv_hilang'>
	<td>
		<!-- <input type="file" id="gambar-{$index}" name='produk[{$index}][gambar]' accept='image/*'> -->
		<button class="btn btn-success btn-block btn-outline" style='height:100%' data-target="#modTambahFoto-{$index}" data-toggle="modal" type="button"><i class='fa fa-plus'></i> Tambahkan Foto</button>
	</td> 
	<td>
		<span class="lbl">SKU</span>
		<input type="text"  style="width:100%;position:relative" class="form-control sku form-200" name="produk[{$index}][sku]" id="sku-{$index}" value="{$value_varian['sku']}">
		<span class="lbl">Stok</span>
		<div id='stokDiv-{$index}' class='stokDiv'>
			{$stok}
		</div>
	</td>
	<td>
		<span class="lbl">Harga Beli</span>
		<input type="text" data-rex='number' name="produk[{$index}][harga_beli]" id="harga_beli-{$index}" class="form-control harga_beli harbel1" style="min-width:230px;max-width:100%;width:100%;position:relative"  onKeyDown='$(this).bersihError();errorValidasi = 0' onMouseDown='$(this).bersihError();errorValidasi = 0' value="{$value_varian['harga_beli']}"/>
		<small id="error_harga_beli-{$index}" class='hidden'></small>
		<div class='diskonDiv' style='{$tDiskon}'>
			<span>Diskon Jual</span>
			<div class="input-group" style="min-width:230px;max-width:100%;width:100%;position:relative">
				<input type="text" data-rex='number' class="form-control" placeholder="0"  name="produk[{$index}][diskon]" id="diskon-{$index}" value="{$value_varian['diskon']}"/>
				<div class="input-group-append diskonDiv_persen" style='{$tTipeDiskon}'>
					<span class="input-group-text">%</span>
				</div>
			</div>
		</div>
	</td>
	<td class="harga_jual[]">
		<span class="lbl">Harga Jual Normal</span>
		<input type="text" data-rex='number'  name="produk[{$index}][harga_jual]" id="harga_jual-{$index}" style="min-width:230px;max-width:100%;width:100%;position:relative" class="form-control rentangCekError"  onKeyDown='$(this).bersihError("harga_jual");errorValidasi = 0' onMouseDown='$(this).bersihError("harga_jual");errorValidasi = 0' value="{$value_varian['harga_jual']}">
		<small id="error_harga_jual-{$index}" class='hidden'></small>
		<span class="lbl resellerDiv" style='{$tReseller}'>Harga Jual Reseller</span>
		<input type="text" data-rex='number'  name="produk[{$index}][harga_reseller]" id="harga_reseller-{$index}" style="min-width:230px;max-width:100%;width:100%;position:relative;{$tReseller}" class="form-control resellerDiv" value="{$value_varian['harga_reseller']}"/>
	</td>
	<td class='varianDiv_all'>
		<span class="lbl size varianDiv_ukuran" style='{$tUkuran}'>Ukuran</span>
		<input type="text" pattern="^[a-zA-Z0-9-/+&.() ]+$" name='produk[{$index}][ukuran]' id='ukuran-{$index}' style="min-width:230px;max-width:100%;width:100%;position:relative;{$tUkuran}" class="form-control size form-100 mbtm-10 varianDiv_ukuran" maxlength="150" value="{$value_varian['ukuran']}"/>
		<span class="lbl warna varianDiv_warna" style='{$tWarna}'>Warna</span>
		<input type="text" pattern="^[a-zA-Z0-9-/+&.,() ]+$"name='produk[{$index}][warna]' id='warna-{$index}'  style="min-width:230px;max-width:100%;width:100%;position:relative;{$tWarna}" class="form-control warna form-100 mbtm-10 varianDiv_warna" maxlength="150" value="{$value_varian['warna']}"/>
	</td>
	<td>
		<button class="btn btn-danger btn-pure icon fa fa-close"
		type="button" id='hVarian-{$index}' onClick='$(this).hapusVarian($(this).attr("id"))'></button>
	</td>
</tr>
EOT
;
				}
			}
			if($request->ajax()){
				return Fungsi::respon('belakang.produk.tambah', ['offset_prod' => $offsetProduk, 'kategori' => $kategori_produk, 'old_input' => $request->old(), 'varian_form' => $varian_form], "ajax", $request);
			}
			return Fungsi::respon('belakang.produk.tambah', ['offset_prod' => $offsetProduk, 'kategori' => $kategori_produk, 'old_input' => $request->old(), 'varian_form' => $varian_form, 'supplier' => $supplier], "html", $request);
		} else {
			if($request->ajax()){
				return Fungsi::respon('belakang.produk.tambah', ['offset_prod' => $offsetProduk, 'kategori' => $kategori_produk, 'supplier' => $supplier], "ajax", $request);
			}
			return Fungsi::respon('belakang.produk.tambah', ['offset_prod' => $offsetProduk, 'kategori' => $kategori_produk, 'supplier' => $supplier], "html", $request);
		}
	}
	

	public function getProduk(Request $request){
		if($request->ajax()){
			$tipe = strip_tags($request->tipe) == "arsip" ? 1 : 0;
			$produk = Cache::remember('data_produk_lengkap_'.$tipe.'_'.Fungsi::dataOfCek(), 10000, function() use($tipe){
				return DB::table('t_produk')
					->where('data_of', Fungsi::dataOfCek())
					->where('arsip', $tipe)
					->get();
			});
			$data = [];
			$i = 0;
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
				}
			} else {
				$ijin = new \stdclass();
				$ijin->hapusProduk = 1;
			}
			foreach(Fungsi::genArray($produk) as $k){
				$edit_url = route('b.produk-edit', ['id_produk' => $k->id_produk]);
				$detail_url = route('b.produk-detail', ['id_produk' => $k->id_produk]);
				if($k->supplier_id == 0){
					$supplier = 'Stok Sendiri';
				} else {
					$data_supp = DB::table('t_supplier')
						->where('data_of', Fungsi::dataOfCek())
						->where('id_supplier', $k->supplier_id)
						->select('nama_supplier')
						->get()->first();
					if(isset($data_supp)){
						$supplier = ucwords(strtolower($data_supp->nama_supplier));
					} else {
						$supplier = '[?Terhapus?]';
					}
				}
				$varian_data = DB::table('t_varian_produk')->where('produk_id', $k->id_produk)->where('data_of', Fungsi::dataOfCek())->get();
				$grosir = $diskon = $diskon_jual = null;
				$harga_jual_tampil = $stok = "";
				$jumlah_stok = 0;
				$cekDiskonSama = false;
				$harga_jual = $harga_jual_diskon = $temp_idProd = $temp_idProd_diskon = [];
				foreach(Fungsi::genArray($varian_data) as $v){
					if(!is_null($v->diskon_jual)){
						if(isset($temp_idProd_diskon[$v->produk_id])){
							$temp_idProd_diskon[$v->produk_id]++;
						} else {
							$temp_idProd_diskon[$v->produk_id] = 1;
						}
					} else {
						if(isset($temp_idProd[$v->produk_id])){
							$temp_idProd[$v->produk_id]++;
						} else {
							$temp_idProd[$v->produk_id] = 1;
						}
					}
				}
				// dd($temp_idProd, $temp_idProd_diskon);
				foreach(Fungsi::genArray($varian_data) as $v){
					$raw_stok = explode("|", $v->stok);
					$jumlah_stok += $raw_stok[0];
					if(!is_null($v->diskon_jual)){
						$diskon = "<span class='badge badge-danger badge-round' style='cursor:default;font-size:13px'>Diskon</span>";
						$diskon_jual = explode("|", $v->diskon_jual);
						if($diskon_jual[1] == "%"){
							$harga_diskon = Fungsi::diskon($v->harga_jual_normal, $diskon_jual[0]);
							$harga_jual_diskon[] = $harga_diskon;
						} else {
							$harga_diskon = (int)$v->harga_jual_normal - (int)$diskon_jual[0];
							$harga_jual_diskon[] = $harga_diskon;
						}
					} else {
						if(count($temp_idProd) > 0 && count($temp_idProd_diskon) > 0){
							$harga_jual_diskon[] = (int)$v->harga_jual_normal;
						}
					}
					$harga_jual[] = (int)$v->harga_jual_normal;
				}
				// dd($harga_jual, $harga_jual_diskon, count(array_unique($harga_jual, SORT_NUMERIC)) === 1);
				// dd($temp_idProd);
				if($jumlah_stok > 0){
					$stok = "<span style='color:#11C26D'><b>".$jumlah_stok." Stok</b></span>";
				} else {
					$stok = "<span style='color:#F2353C'><b>Stok Habis</b></span>";
				}
				$jumlah_varian = count($varian_data);
				sort($harga_jual, SORT_NUMERIC);
				sort($harga_jual_diskon, SORT_NUMERIC);
				if($jumlah_varian > 1){
					if(!empty($harga_jual_diskon)){
						if(count(array_unique($harga_jual, SORT_NUMERIC)) === 1){
							$harga_jual_tampil .= "<del>".Fungsi::uangFormat($harga_jual[0], true)."</del>";
						} else {
							$harga_jual_tampil .= "<del>".Fungsi::uangFormat($harga_jual[0], true)." &nbsp;&nbsp;--&nbsp;&nbsp; ".Fungsi::uangFormat(end($harga_jual), true)."</del>";
						}
						if(count(array_unique($harga_jual_diskon, SORT_NUMERIC)) === 1){
							$harga_jual_tampil .= "<br>".Fungsi::uangFormat($harga_jual_diskon[0], true);
						} else {
							$harga_jual_tampil .= "<br>".Fungsi::uangFormat($harga_jual_diskon[0], true)." &nbsp;&nbsp;--&nbsp;&nbsp; ".Fungsi::uangFormat(end($harga_jual_diskon), true);
						}
					} else {
						if(count(array_unique($harga_jual, SORT_NUMERIC)) === 1){
							$harga_jual_tampil .= Fungsi::uangFormat($harga_jual[0], true);
						} else {
							$harga_jual_tampil .= Fungsi::uangFormat($harga_jual[0], true)." &nbsp;&nbsp;--&nbsp;&nbsp; ".Fungsi::uangFormat(end($harga_jual), true);
						}
					}
				} else {
					if(!empty($harga_jual_diskon) && !is_null($diskon)){
						$harga_jual_tampil .= "<del>";
					}
					$harga_jual_tampil .= Fungsi::uangFormat(reset($harga_jual), true);
					if(!empty($harga_jual_diskon) && !is_null($diskon)){
						$harga_jual_tampil .= "</del><br>".Fungsi::uangFormat(reset($harga_jual_diskon), true);
					};
				}
				$grosir_data = DB::table('t_grosir')->where('produk_id', $k->id_produk)->get();
				foreach(Fungsi::genArray($grosir_data) as $g){
					if($g->harga != "" && $g->rentan != ""){
						$grosir = "<i class='fa fa-check' style='color:#05A85C'></i>";
						break;
					}
				}
				if(is_null($grosir)){
					$grosir = "<i class='fa fa-close' style='color:#F2353C'></i>";
				}
				if(is_null($k->kategori_produk_id)){
					$tampil_kategori = "-";
				} else {
					$kategori_produk = DB::table('t_kategori_produk')
						->select("nama_kategori_produk")
						->where("id_kategori_produk", $k->kategori_produk_id)
						->where("data_of", Fungsi::dataOfCek())->get()->first();
					if(isset($kategori_produk)){
						$tampil_kategori = $kategori_produk->nama_kategori_produk;
					} else {
						$tampil_kategori = "<span class='text-muted'>[Telah Dihapus]</span>";
					}
				}
				$data[$i] = [
					"<input type='checkbox' id='selectMultiEvent-".$k->id_produk."' class='bisaCek'/>",
					"<span style='font-size:17px'>".$k->nama_produk."</span> ".$diskon,
					"<div class='stokClick' data-id='".$k->id_produk."'>".$stok." dari <span style='color:#0099B8'><b>".$jumlah_varian." Varian</b></span></div>",
					$harga_jual_tampil,
					$grosir,
					$supplier,
					$tampil_kategori
				];
				if(($ijin->hapusProduk === 1 && $data_user->role == 'Admin') || $data_user->role == 'Owner'){
					$data[$i][] = "<input type='hidden' name='valID' value='".$k->id_produk."'>
					<a href='javascript:void(0);' onClick='pageLoad(\"".$detail_url."\");' class='btn btn-info btn-sm'>Detail</a>
					<a href='javascript:void(0);' onClick='pageLoad(\"".$edit_url."\");' class='btn btn-warning btn-sm'>Edit</a>
					<button type='button' class='btn btn-danger btn-sm' onClick='$(this).hapusP(tabelData);'>Hapus</button>";
				} else {
					$data[$i][] = "<input type='hidden' name='valID' value='".$k->id_produk."'>
					<a href='javascript:void(0);' onClick='pageLoad(\"".$detail_url."\");' class='btn btn-info btn-sm'>Detail</a>
					<a href='javascript:void(0);' onClick='pageLoad(\"".$edit_url."\");' class='btn btn-warning btn-sm'>Edit</a>";
				}
				$i++;
			}
			$h['data'] = $data; 
			// dd($data);
			// return htmlspecialchars_decode(json_encode($h));
			return Fungsi::respon($h, [], "json", $request);
		} else {
			abort(404);
		}
	}

	public function tambahModalFoto(Request $request){
		if($request->ajax()){
			$i = $request->i;
			if(isset($request->edit) && $request->edit){
				$tmp_foto = <<<TTT
                <input type='text' class='hidden' name='produk[{$i}][tmp_foto][1]' id='tmp_foto_{$i}-1'>
                <input type='text' class='hidden' name='produk[{$i}][tmp_foto][2]' id='tmp_foto_{$i}-2'>
                <input type='text' class='hidden' name='produk[{$i}][tmp_foto][3]' id='tmp_foto_{$i}-3'>
                <input type='text' class='hidden' name='produk[{$i}][tmp_foto][4]' id='tmp_foto_{$i}-4'>
                <input type='text' class='hidden' name='produk[{$i}][tmp_foto][5]' id='tmp_foto_{$i}-5'>
                <input type='text' class='hidden' name='produk[{$i}][tmp_foto][6]' id='tmp_foto_{$i}-6'>
                <input type='text' class='hidden' name='produk[{$i}][tmp_foto][7]' id='tmp_foto_{$i}-7'>
TTT
;
			} else {
				$tmp_foto = "";
			}
			return Fungsi::respon(<<<EOT
<!-- modal tambah foto {$i} -->
<div class="modal fade" id="modTambahFoto-{$i}" aria-hidden="true" aria-labelledby="exampleModalTitle"
    role="dialog" tabindex="-1">
    <div class="modal-dialog modal-simple modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="exampleModalTabs">Tambah Foto</h4>
            </div>
            <ul class="nav nav-tabs nav-tabs-line" role="tablist">
                <li class="nav-item" role="presentation"><a class="nav-link active" data-toggle="tab" href="#tabFoto_{$i}-utama" aria-controls="tabFoto_{$i}-utama" role="tab">Utama</a></li>
                <li class="nav-item" role="presentation"><a class="nav-link" data-toggle="tab" href="#tabFoto_{$i}-lain" aria-controls="tabFoto_{$i}-lain" role="tab">Lainnya</a></li>
            </ul>
			<div class="modal-body">
				{$tmp_foto}
                <div class="tab-content">
                    <div class="tab-pane active" id="tabFoto_{$i}-utama" role="tabpanel">
                        <center>
                            <input type="file" id="foto_{$i}-1" accept='.jpeg,.jpg,.png,.gif' name='produk[{$i}][foto][1]'>
                        </center>
                    </div>
                    <div class="tab-pane" id="tabFoto_{$i}-lain" role="tabpanel">
                        <center>
							<div class='d-inline-flex'>
								<input type="file" id="foto_{$i}-2" accept='.jpeg,.jpg,.png,.gif' name='produk[{$i}][foto][2]'>
								<input type="file" id="foto_{$i}-3" accept='.jpeg,.jpg,.png,.gif' name='produk[{$i}][foto][3]'>
								<input type="file" id="foto_{$i}-4" accept='.jpeg,.jpg,.png,.gif' name='produk[{$i}][foto][4]'>
							</div>
							<div class='d-inline-flex mt-15'>
								<input type="file" id="foto_{$i}-5" accept='.jpeg,.jpg,.png,.gif' name='produk[{$i}][foto][5]'>
								<input type="file" id="foto_{$i}-6" accept='.jpeg,.jpg,.png,.gif' name='produk[{$i}][foto][6]'>
								<input type="file" id="foto_{$i}-7" accept='.jpeg,.jpg,.png,.gif' name='produk[{$i}][foto][7]'>
							</div>
                        </center>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>
EOT
, [], "raw_html", $request);
		} else {
			abort(404);
		}
	}
	
	public function tambahFormProduk(Request $request){
		if($request->ajax()){
			$i = $request->i;
			$tUkuran = $request->ic_ukuran;
			$tWarna = $request->ic_warna;
			$tDiskon = $request->ic_diskon;
			$tReseller = $request->ic_reseller;
			$tTipeDiskon = $request->ic_tipe_diskon;
			$offsetProd = explode('P', $request->offset_prod)[1];
			$stok = "<input type='text' data-rex='number' name='produk[{$i}][stok]' id='stok-{$i}' class='form-control jumlah_stok form-100' style='min-width:230px;max-width:100%;width:100%;position:relative' placeholder='0' onKeyDown='$(this).bersihError();errorValidasi = 0' onMouseDown='$(this).bersihError();errorValidasi = 0'/>".
				"<small id='error_stok-{$i}' class='hidden'></small>";
			$label_beli = "Harga Beli";
			return Fungsi::respon(<<<EOT
<tr id='idVarian-{$i}' class='varianDiv_hilang'>
	<td>
		<!-- <input type="file" id="gambar-{$i}" name='produk[{$i}][gambar]' accept='image/*'> -->
		<button class="btn btn-success btn-block btn-outline" style='height:100%' data-target="#modTambahFoto-{$i}" data-toggle="modal" type="button"><i class='fa fa-plus'></i> Tambahkan Foto</button>
	</td> 
	<td>
		<span class="lbl">SKU</span>
		<input type="text"  style="width:100%;position:relative" class="form-control sku form-200" name="produk[{$i}][sku]" id="sku-{$i}" value="P{$offsetProd}V{$i}">
		<span class="lbl">Stok</span>
		<div id='stokDiv-{$i}' class='stokDiv'>
			{$stok}
		</div>
	</td>
	<td>
		<span class="label-harga_beli-{$i}">{$label_beli}</span>
		<input type="text" name="produk[{$i}][harga_beli]" data-rex='number' id="harga_beli-{$i}" class="form-control harga_beli harbel1" style="min-width:230px;max-width:100%;width:100%;position:relative"  onKeyDown='$(this).bersihError();errorValidasi = 0' onMouseDown='$(this).bersihError();errorValidasi = 0'/>
		<small id="error_harga_beli-{$i}" class='hidden'></small>
		<div class='diskonDiv' style='{$tDiskon}'>
			<span>Diskon Jual</span>
			<div class="input-group" style="min-width:230px;max-width:100%;width:100%;position:relative">
				<input type="text" class="form-control" placeholder="0" data-rex='number'  name="produk[{$i}][diskon]" id="diskon-{$i}"/>
				<div class="input-group-append diskonDiv_persen" style='{$tTipeDiskon}'>
					<span class="input-group-text">%</span>
				</div>
			</div>
		</div>
	</td>
	<td class="harga_jual[]">
		<span class="lbl">Harga Jual Normal</span>
		<input type="text" data-rex='number' class="form-control rentangCekError" name="produk[{$i}][harga_jual]" id="harga_jual-{$i}" style="min-width:230px;max-width:100%;width:100%;position:relative" onKeyDown='$(this).bersihError("harga_jual");errorValidasi = 0' onMouseDown='$(this).bersihError("harga_jual");errorValidasi = 0'>
		<small id="error_harga_jual-{$i}" class='hidden'></small>
		<div class="lbl resellerDiv" style='{$tReseller}'>Harga Jual Reseller</div>
		<input type="text" data-rex='number'  name="produk[{$i}][harga_reseller]" id="harga_reseller-{$i}" style="min-width:230px;max-width:100%;width:100%;position:relative;{$tReseller}" class="form-control resellerDiv"/>
	</td>
	<td class='varianDiv_all'>
		<span class="lbl size varianDiv_ukuran" style='{$tUkuran}'>Ukuran</span>
		<input type="text" pattern="^[a-zA-Z0-9-/+&.() ]+$" name='produk[{$i}][ukuran]' id='ukuran-{$i}' style="min-width:230px;max-width:100%;width:100%;position:relative;{$tUkuran}" class="form-control size form-100 mbtm-10 varianDiv_ukuran" maxlength="150"/>
		<span class="lbl warna varianDiv_warna" style='{$tWarna}'>Warna</span>
		<input type="text" pattern="^[a-zA-Z0-9-/+&.,() ]+$"name='produk[{$i}][warna]' id='warna-{$i}'  style="min-width:230px;max-width:100%;width:100%;position:relative;{$tWarna}" class="form-control warna form-100 mbtm-10 varianDiv_warna" maxlength="150"/>
	</td>
	<td>
		<button class="btn btn-danger btn-pure icon fa fa-close"
		type="button" id='hVarian-{$i}' onClick='$(this).hapusVarian($(this).attr("id"))'></button>
		<input type='text' class='hidden' name='produk[{$i}][tipeVarianEdit]' value='tambah'>
	</td>
</tr>
EOT
, [], "raw_html", $request);	
		} else {
			abort(404);
		}
	}

	public function getProdukData(Request $request){
		if($request->ajax()){
			if(isset($request->id)){
				$data = DB::table('t_varian_produk')
					->select('ukuran', 'warna', 'sku', 'harga_jual_normal', 'foto_id', 'stok', "id_varian")
					->where('data_of', Fungsi::dataOfCek())
					->where('produk_id', $request->id)
					->get();
				if(count($data) > 0){
					$hasil = [];
					foreach(Fungsi::genArray($data) as $iP => $vP){
						$hasil[$iP] = new stdClass();
						$hasil[$iP]->sku = $vP->sku;
						$hasil[$iP]->harga_jual_normal = $vP->harga_jual_normal;
						$hasil[$iP]->ukuran = $vP->ukuran;
						$hasil[$iP]->warna = $vP->warna;
						$hasil[$iP]->id = $vP->id_varian;
						$hasil[$iP]->stok = explode("|", $vP->stok)[0];
						$hasil[$iP]->supplier = explode("|", $vP->stok)[1];
						if(!is_null($vP->foto_id)){
							$fotoSrc = json_decode($vP->foto_id);
							if(!is_null($fotoSrc->utama)){
								if(is_numeric($fotoSrc->utama)){
									$fotoUtama = DB::table('t_foto')->where('id_foto', $fotoSrc->utama)->where('data_of', Fungsi::dataOfCek())->get()->first();
									$hasil[$iP]->foto = asset($fotoUtama->path);
									unset($fotoUtama);
								} else if(filter_var($fotoSrc->utama, FILTER_VALIDATE_URL)){
									$hasil[$iP]->foto = $fotoSrc->utama;
								} else {
									$hasil[$iP]->foto = asset("photo.png");
								}
							} else {
								$hasil[$iP]->foto = asset("photo.png");
							}
						} else {
							$hasil[$iP]->foto = asset("photo.png");
						}
					}
					return Fungsi::respon($hasil, [], "json", $request);
				} else {
					return response()->json("kosong");
				}
			} else {
				abort(404);
			}
		} else {
			abort(404);
		}
	}
	
	public function prosesProduk(Request $request){
		$support_gambar = ['jpeg', 'jpg', 'png', 'gif'];

		if($request->tipe_kirim_produk == base64_encode("tambah")){

			// return "<pre>".print_r($request->all(), true)."</pre>";
			$data = $request->all();
			if($data['jumlah_varian'] != count($data['produk'])){
				return redirect()->back()->with(['msg_error' => "Anda menambahkan produk dengan cara yang tidak benar!"])->withInput($request->input());
			}

			foreach(Fungsi::genArray($data['produk']) as $vP){
				if(isset($vP['foto'])){
					foreach(Fungsi::genArray($vP['foto']) as $vF){
						$ext = $vF->getClientOriginalExtension();
						if(!in_array(strtolower($ext), $support_gambar)){
							return redirect()->back()->with(['msg_error' => "Gambar hanya support extensi 'jpeg', 'jpg', 'png', dan 'gif' saja!"])->withInput($request->input());
						}
					}
				}
			}

			// produk
			$cekNamaProd = DB::table('t_produk')->select("nama_produk")->where("nama_produk", 'like', $data['nama_produk'].'%')->where("data_of", Fungsi::dataOfCek())->get();
			if(count($cekNamaProd) > 0){
				$svProduk['nama_produk'] = $data['nama_produk']." #".(string)(count($cekNamaProd)+1);
			} else {
				$svProduk['nama_produk'] = $data['nama_produk'];
			}
			$svProduk['kategori_produk_id'] = (isset($data['kategori'])) ? $data['kategori'] : null;
			$svProduk['supplier_id'] = (isset($data['supplier'])) ? $data['supplier'] : 0;
			$svProduk['berat'] = $data['berat'];
			$svProduk['ket'] = $data['keterangan'] == '' ? null : $data['keterangan'];
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

			$cekSKU_allow = true;
			$SKU_tmp = "";
			$stokVarian = [];

			$genProdVarian = Fungsi::genArray($data['produk']);
			foreach($genProdVarian as $vV){

				//varian
				$produk = $vV;
				$svVarian['produk_id'] = $lastID_produk;
				$cekNamaSKU = DB::table('t_varian_produk')->select("sku")->where("sku", $produk['sku'])->where("data_of", Fungsi::dataOfCek())->get();
				if(count($cekNamaSKU) > 0){
					$cekSKU_allow = false;
					$SKU_tmp = $produk['sku'];
					$genProdVarian->send('stop');
					// break;
				} else {
					$svVarian['sku'] = $produk['sku'];
				}
				$stok = (!isset($produk['stok']) || $produk['stok'] == "") ? 0 : $produk['stok'];
				if($data['supplier'] == 0){
					$svVarian['stok'] = $stok."|sendiri";
				} else {
					$svVarian['stok'] = $stok."|lain";
				}
				$svVarian['harga_beli'] = $produk['harga_beli'];
				if(isset($data['sDiskon']) && $data['sDiskon'] == 'on'){
					if($produk['diskon'] == "" || $produk['diskon'] == 0){
						$svVarian['diskon_jual'] = null;
					} else {
						$diskon = $produk['diskon'];
						if($data['tDiskon'] == "persen"){
							if($diskon > 100){
								$diskon = 100;
							}
							$svVarian['diskon_jual'] = $diskon."|%";
						} else {
							$svVarian['diskon_jual'] = $diskon."|*";
						}
					}
				}
				$svVarian['harga_jual_normal'] = $produk['harga_jual'];
				if(isset($data['sReseller']) && $data['sReseller'] == 'on'){
					$svVarian['harga_jual_reseller'] = ($produk['harga_reseller'] == "") ? $produk['harga_jual'] : $produk['harga_reseller'];
				}
				if(isset($data['sUkuran']) && $data['sUkuran'] == 'on'){
					$svVarian['ukuran'] = $produk['ukuran'];
				}
				if(isset($data['sWarna']) && $data['sWarna'] == 'on'){
					$svVarian['warna'] = $produk['warna'];
				}
				//foto_produk
				if(isset($vV['foto'])){
					$id_lain_foto = [];
					$id_utama_foto = null;
					$path = "../data/".base64_encode(base64_encode(Fungsi::dataOfCek())."+".base64_encode(Fungsi::dataOfCekUsername()))."/";
					//pakai base_path untuk move, pakai asset untuk nampilkan.
					if(is_dir(base_path($path))){
						$path_isset = true;
					} else {
						if(mkdir(base_path($path), 0777, true)){
							$path_isset = true;
						} else {
							$path_isset = false;
							// DB::table('t_produk')->where('id_produk', $lastID_produk)->where('data_of', Fungsi::dataOfCek())->delete();
							// return redirect()->back()->with(['msg_error' => "Tidak dapat membuat folder data!"])->withInput($request->input());
						}
					}
					foreach(Fungsi::genArray($vV['foto']) as $i2 => $v2){
						$foto = $v2;
						$filename = base64_encode(mt_rand(1, 99)).base64_encode($foto->getClientOriginalName().mt_rand(1, 999)).".".$foto->getClientOriginalExtension();
						if($path_isset){
							if($foto->move(base_path($path), $filename)){
								$lastID_foto = DB::table('t_foto')->insertGetId([
									'path' => $path.$filename,
									'data_of' => Fungsi::dataOfCek()
								]);
								if($i2 == 1){
									$id_utama_foto = $lastID_foto;
								} else {
									$id_lain_foto[] = $lastID_foto;
								}
								unset($lastID_foto);
							} 
						}
					}
					$svVarian['foto_id'] = json_encode([
						"utama" => $id_utama_foto,
						"lain" => implode(";", $id_lain_foto)
					]);
				} else {
					$svVarian['foto_id'] = null;
				}
				$svVarian['data_of'] = Fungsi::dataOfCek();
				$offsetSku_akhir = DB::table('t_varian_produk')
					->where('data_of', Fungsi::dataOfCek())
					->where('produk_id', $lastID_produk)
					->select('sku_offset')
					->orderBy('sku_offset', 'desc')
					->get()->first();
				if(isset($offsetSku_akhir)){
					$svVarian['sku_offset'] = $offsetSku_akhir->sku_offset+1;
				} else {
					$svVarian['sku_offset'] = 1;
				}
				$proses_id_varian = DB::table('t_varian_produk')->insertGetId($svVarian);
				$stokVarian[$proses_id_varian] = $stok;
			}

			if(!$cekSKU_allow){
				DB::table('t_produk')->where('id_produk', $lastID_produk)->where('data_of', Fungsi::dataOfCek())->delete();
				DB::table('t_varian_produk')->where('produk_id', $lastID_produk)->where('data_of', Fungsi::dataOfCek())->delete();
				return redirect()->back()->with(['msg_error' => "SKU '".$SKU_tmp."' sudah ada!"])->withInput($request->input());
			}

			if(count($stokVarian) > 0){
				foreach(Fungsi::genArray($stokVarian) as $iRv => $vRv){
					$riwayatStok_varian = DB::table('t_riwayat_stok')->insert([
						"varian_id" => $iRv,
						"tgl" => date("Y-m-d H:i:s"),
						"ket" => "Stok Awal",
						"jumlah" => $vRv,
						"tipe" => "masuk",
						"data_of" => Fungsi::dataOfCek()
					]);
				}
			}

			//grosir
			foreach(Fungsi::genArray($data['rentan']) as $grosir){
				if($grosir['min'] != "" && $grosir['max'] != "" && $grosir['harga_grosir'] != ""){
					$svGrosir['produk_id'] = $lastID_produk;
					$svGrosir['rentan'] = $grosir['min']."-".$grosir['max'];
					$svGrosir['harga'] = $grosir['harga_grosir'];
					$svGrosir['data_of'] = Fungsi::dataOfCek();
					$proses_grosir = DB::table('t_grosir')->insert($svGrosir);
				}
			}
			event(new ProdukDataBerubah(Fungsi::dataOfCek()));
			event(new BelakangLogging(Fungsi::dataOfCek(), 'tambah_produk', [
				'user_id' => Auth::user()->id,
				'nama_produk' => ucwords(strtolower($data['nama_produk']))
			]));
			if($data['tData'] == "tambah"){
				return redirect()->route("b.produk-tambah")->with(['msg_success' => 'Produk berhasil ditambahkan!']);
			} else {
				return redirect()->route("b.produk-index")->with(['msg_success' => 'Produk berhasil ditambahkan!']);
			}
		} else if($request->tipe_kirim_produk == base64_encode("edit")){
			// return "<pre>".print_r($request->all(), true)."</pre>";
			
			$data = $request->all();
			
			$id_produk_edit = $data['id_produk_edit'];

			
			// $dataCekSupp = DB::table('t_produk')->where('data_of', Fungsi::dataOfCek())->where('id_produk', $id_produk_edit)->get()->first();
			// dd($data['produk']);
			// dd($dataCekSupp->supplier_id != 0 && isset($data['supplier']) && ((int)$data['supplier']) === 0, $dataCekSupp->supplier_id === 0 && isset($data['supplier']) && ((int)$data['supplier']) !== 0);
			
			if($data['jumlah_varian'] != count($data['produk'])){
				return redirect()->route("b.produk-edit", ["id_produk" => $id_produk_edit])->with(['msg_error' => "Anda menambahkan produk dengan cara yang tidak benar!"]);
			}

			foreach(Fungsi::genArray($data['produk']) as $vP){
				if(isset($vP['foto'])){
					foreach(Fungsi::genArray($vP['foto']) as $vF){
						$ext = $vF->getClientOriginalExtension();
						if(!in_array(strtolower($ext), $support_gambar)){
							return redirect()->route("b.produk-edit", ["id_produk" => $id_produk_edit])->with(['msg_error' => "Gambar hanya support extensi 'jpeg', 'jpg', 'png', dan 'gif' saja!"]);
						}
					}
				}
			}

			// cek sku
			$cekSKU_allow = true;
			$SKU_tmp = "";
			$SKU_prod_tmp = [];
			$genDataProd = Fungsi::genArray($data["produk"]);
			foreach($genDataProd as $iC => $iV){
				$cekNamaSKU = DB::table('t_varian_produk')
					->select("sku")
					->where("sku", $iV['sku'])
					->where("produk_id", "!=", $id_produk_edit)
					->where("data_of", Fungsi::dataOfCek())->get();
				if(count($cekNamaSKU) > 0){
					$cekSKU_allow = false;
					$SKU_tmp = $iV['sku'];
					$genDataProd->send('stop');
					// break;
				} else {
					$SKU_prod_tmp[] = $iV['sku'];
				}
			}
			$SKU_prod_tmp2 = $SKU_prod_tmp;
			$genSKU_temp = Fungsi::genArray($SKU_prod_tmp);
			foreach($genSKU_temp as $tr => $vtr){
				foreach(Fungsi::genArray($SKU_prod_tmp2) as $tr2 => $vtr2){
					if($tr != $tr2){
						if($vtr == $vtr2){
							$cekSKU_allow = false;
							$SKU_tmp = $vtr2;
							$genSKU_temp->send('stop');
							// break 2;
						}
					}
				}
			}
			unset($SKU_prod_tmp2, $genSKU_temp, $SKU_prod_tmp);
			if(!$cekSKU_allow){
				return redirect()->route("b.produk-edit", ["id_produk" => $id_produk_edit])->with(['msg_error' => "SKU '".$SKU_tmp."' sudah ada!"]);
			}

			// produk
			$cekNamaProd = DB::table('t_produk')
				->select("nama_produk")
				->where("nama_produk", 'like', $data['nama_produk'].'%')
				->where("id_produk", "!=", $id_produk_edit)
				->where("data_of", Fungsi::dataOfCek())->get();
			if(count($cekNamaProd) > 0){
				$svProduk['nama_produk'] = $data['nama_produk']." #".(string)(count($cekNamaProd)+1);
			} else {
				$svProduk['nama_produk'] = $data['nama_produk'];
			}
			$svProduk['kategori_produk_id'] = (isset($data['kategori'])) ? $data['kategori'] : null;
			$svProduk['supplier_id'] = (isset($data['supplier'])) ? $data['supplier'] : 0;
			$svProduk['berat'] = $data['berat'];
			$svProduk['ket'] = $data['keterangan'] == '' ? null : $data['keterangan'];
			$svProduk['data_of'] = Fungsi::dataOfCek();
			$edit_produk = DB::table('t_produk')->where('id_produk', $id_produk_edit)->where('data_of', Fungsi::dataOfCek())->update($svProduk);

			

			//grosir
			foreach(Fungsi::genArray($data['rentan']) as $grosir){
				$svGrosir['produk_id'] = $id_produk_edit;
				// echo "<pre>".print_r($grosir, true)."</pre>";
				if($grosir['min'] != "" && $grosir['max'] != "" && $grosir['harga_grosir'] != ""){
					$svGrosir['rentan'] = $grosir['min']."-".$grosir['max'];
					$svGrosir['harga'] = $grosir['harga_grosir'];
					$svGrosir['data_of'] = Fungsi::dataOfCek();
					if($grosir['id_grosir'] != ""){
						$proses_grosir = DB::table('t_grosir')->where('id_grosir', $grosir['id_grosir'])->where('data_of', Fungsi::dataOfCek())->update($svGrosir);
					} else {
						$proses_grosir = DB::table('t_grosir')->insert($svGrosir);
					} 
				} else {
					if($grosir['id_grosir'] != ""){
						$proses_grosir = DB::table('t_grosir')->where('id_grosir', $grosir['id_grosir'])->where('data_of', Fungsi::dataOfCek())->delete();
					}
				}
			}

			// $iJ = $data['jumlah_varian'];
			if($data["hapus_varian"] != "" && $data["hapus_varian"] != "undefined"){
				$ht_varian = explode("|", $data['hapus_varian']);
				foreach(Fungsi::genArray($ht_varian) as $h){
					$fotoSrc = DB::table('t_varian_produk')->where('id_varian', $h)->where('data_of', Fungsi::dataOfCek())->get()->first()->foto_id;
					if(!is_null($fotoSrc)){
						$fotoData = json_decode($fotoSrc);
						if(!is_null($fotoData->utama) && is_numeric($fotoData->utama)){
							$fotoPath = DB::table('t_foto')->select("path")->where('id_foto', $fotoData->utama)->get()->first()->path;
							if(file_exists(base_path($fotoPath))){
								unlink(base_path($fotoPath));
							}
							$hapus_foto_varian = DB::table('t_foto')->where("id_foto", $fotoData->utama)->where('data_of', Fungsi::dataOfCek())->delete();
						}
						if($fotoData->lain != ""){
							$listLain_foto = explode(";", $fotoData->lain);
							foreach(Fungsi::genArray($listLain_foto) as $iF){
								if(is_numeric($iF)){
									$fotoPath = DB::table('t_foto')->select("path")->where('id_foto', $iF)->get()->first()->path;
									if(file_exists(base_path($fotoPath))){
										unlink(base_path($fotoPath));
									}
									$hapus_foto_varian = DB::table('t_foto')->where("id_foto", $iF)->where('data_of', Fungsi::dataOfCek())->delete();
								}
							}
						}
					}
					$hapus_varian_edit = DB::table('t_varian_produk')->where('id_varian', $h)->where('data_of', Fungsi::dataOfCek())->delete(); 
				}
			}
			
			foreach(Fungsi::genArray($data['produk']) as $vV){
				//varian
				$produk = $vV;
				$svVarian['produk_id'] = $id_produk_edit;
				$svVarian['sku'] = $produk['sku'];
				$svVarian['data_of'] = Fungsi::dataOfCek();
				$stok = (!isset($produk['stok']) || $produk['stok'] == "") ? 0 : $produk['stok'];
				if($data['supplier'] == 0){
					$svVarian['stok'] = $stok."|sendiri";
				} else {
					$svVarian['stok'] = $stok."|lain";
				}
				$svVarian['harga_beli'] = $produk['harga_beli'];
				if(isset($data['sDiskon']) && $data['sDiskon'] == 'on'){
					if($produk['diskon'] == "" || $produk['diskon'] == 0){
						$svVarian['diskon_jual'] = null;
					} else {
						$diskon = $produk['diskon'];
						if($data['tDiskon'] == "persen"){
							if($diskon > 100){
								$diskon = 100;
							}
							$svVarian['diskon_jual'] = $diskon."|%";
						} else {
							$svVarian['diskon_jual'] = $diskon."|*";
						}
					}
				}
				$svVarian['harga_jual_normal'] = $produk['harga_jual'];
				if(isset($data['sReseller']) && $data['sReseller'] == 'on'){
					$svVarian['harga_jual_reseller'] = ($produk['harga_reseller'] == "") ? $produk['harga_jual'] : $produk['harga_reseller'];
				}
				if(isset($data['sUkuran']) && $data['sUkuran'] == 'on'){
					$svVarian['ukuran'] = $produk['ukuran'];
				}
				if(isset($data['sWarna']) && $data['sWarna'] == 'on'){
					$svVarian['warna'] = $produk['warna'];
				}

				//foto_produk
				if(count($vV['tmp_foto']) > 0){
					$id_lain_foto = [];
					$id_utama_foto = null;
					$path = "../data/".base64_encode(base64_encode(Fungsi::dataOfCek())."+".base64_encode(Fungsi::dataOfCekUsername()))."/";
					if(is_dir(base_path($path))){
						$path_isset = true;
					} else {
						if(mkdir(base_path($path), 0777, true)){
							$path_isset = true;
						} else {
							$path_isset = false;
							// return redirect()->route("b.produk-edit", ["id_produk" => $id_produk_edit])->with(['msg_error' => "Tidak dapat membuat folder data!"]);
						}
					}
					foreach(Fungsi::genArray($vV['tmp_foto']) as $i2 => $v2){
						// $fotoSrc = $vV['foto'][$i2] ?? null;
						$fotoSrc = $vV['foto'][$i2] ?? null;
						$tmp_fotoSrc = $vV['tmp_foto'][$i2];
						if(isset($fotoSrc)){
							$filename = base64_encode(mt_rand(1, 99)).base64_encode($fotoSrc->getClientOriginalName().mt_rand(1, 999)).".".$fotoSrc->getClientOriginalExtension();
						}
						if($path_isset){
							if($tmp_fotoSrc == ""){
								if(isset($vV['foto'][$i2])){
									if($fotoSrc->move(base_path($path), $filename)){
										$lastID_foto = DB::table('t_foto')->insertGetId([
											'path' => $path.$filename,
											'data_of' => Fungsi::dataOfCek()
										]);
										if($i2 == 1){
											$id_utama_foto = $lastID_foto;
										} else {
											$id_lain_foto[] = $lastID_foto;
										}
										unset($lastID_foto);
									}
								}
							} else if(preg_match("/^hapus\+/", $tmp_fotoSrc)){
								$tmpId_foto = decrypt(explode("hapus+", $tmp_fotoSrc)[1]);
								if(is_numeric($tmpId_foto)){
									$lastPath_foto = DB::table("t_foto")->select("path")->where("id_foto", $tmpId_foto)->where("data_of", Fungsi::dataOfCek())->get()->first()->path;
									if(file_exists(base_path($lastPath_foto))){
										unlink(base_path($lastPath_foto));
										$hapusFoto = DB::table('t_foto')->where('id_foto', $tmpId_foto)->where('data_of', Fungsi::dataOfCek())->delete();
									}
								}
								if(isset($vV['foto'][$i2])){
									if($fotoSrc->move(base_path($path), $filename)){
										$lastID_foto = DB::table('t_foto')->insertGetId([
											'path' => $path.$filename,
											'data_of' => Fungsi::dataOfCek()
										]);
										if($i2 == 1){
											$id_utama_foto = $lastID_foto;
										} else {
											$id_lain_foto[] = $lastID_foto;
										}
										unset($lastID_foto);
									}
								} 
							} else {
								$tmpId_foto = decrypt($tmp_fotoSrc);
								if(isset($vV['foto'][$i2])){
									if(is_numeric($tmpId_foto)){
										$lastPath_foto = DB::table("t_foto")->select("path")->where("id_foto", $tmpId_foto)->where("data_of", Fungsi::dataOfCek())->get()->first()->path;
										if(file_exists(base_path($lastPath_foto))){
											unlink(base_path($lastPath_foto));
											$hapusFoto = DB::table('t_foto')->where('id_foto', $tmpId_foto)->where('data_of', Fungsi::dataOfCek())->delete();
										}
									}
									if($fotoSrc->move(base_path($path), $filename)){
										$lastID_foto = DB::table('t_foto')->insertGetId([
											'path' => $path.$filename,
											'data_of' => Fungsi::dataOfCek()
										]);
										if($i2 == 1){
											$id_utama_foto = $lastID_foto;
										} else {
											$id_lain_foto[] = $lastID_foto;
										}
										unset($lastID_foto);
									}
								} else {
									if($i2 == 1){
										$id_utama_foto = $tmpId_foto;
									} else {
										$id_lain_foto[] =  $tmpId_foto;
									}
								}
							}
						}
					}
					$svVarian['foto_id'] = json_encode([
						"utama" => $id_utama_foto,
						"lain" => implode(";", $id_lain_foto)
					]);
				}
				if($produk["tipeVarianEdit"] == "edit"){
					$cekStokLawas = DB::table('t_varian_produk')
						->where('data_of', Fungsi::dataOfCek())
						->where('id_varian', $vV['id_varian'])
						->select('stok')
						->get()->first();
					if(isset($cekStokLawas)){
						$t_stokLawas = (int)explode('|', $cekStokLawas->stok)[0];
						$t_stokBaru = (int)$vV['stok'];
						if($t_stokLawas > $t_stokBaru){
							$stok_t = $t_stokLawas - $t_stokBaru;
							$riwayatStok_varian = DB::table('t_riwayat_stok')->insert([
								"varian_id" => $vV['id_varian'],
								"tgl" => date("Y-m-d H:i:s"),
								"ket" => "Edit Produk",
								"jumlah" => $stok_t,
								"tipe" => "keluar",
								"data_of" => Fungsi::dataOfCek()
							]);
						} else if($t_stokLawas < $t_stokBaru){
							$stok_t = $t_stokBaru - $t_stokLawas;
							$riwayatStok_varian = DB::table('t_riwayat_stok')->insert([
								"varian_id" => $vV['id_varian'],
								"tgl" => date("Y-m-d H:i:s"),
								"ket" => "Edit Produk",
								"jumlah" => $stok_t,
								"tipe" => "masuk",
								"data_of" => Fungsi::dataOfCek()
							]);
						}
					}

					$proses_varian = DB::table('t_varian_produk')->where("id_varian", $produk["id_varian"])->where("data_of", Fungsi::dataOfCek())->update($svVarian);

				} else if($produk["tipeVarianEdit"] == "tambah"){
					$offsetSku_akhir = DB::table('t_varian_produk')
						->where('data_of', Fungsi::dataOfCek())
						->where('produk_id', $id_produk_edit)
						->select('sku_offset')
						->orderBy('sku_offset', 'desc')
						->get()->first();
					if(isset($offsetSku_akhir)){
						$svVarian['sku_offset'] = $offsetSku_akhir->sku_offset+1;
					} else {
						$svVarian['sku_offset'] = 1;
					}
					$proses_varian_id = DB::table('t_varian_produk')->insertGetId($svVarian);

					$riwayatStok_varian = DB::table('t_riwayat_stok')->insert([
						"varian_id" => $proses_varian_id,
						"tgl" => date("Y-m-d H:i:s"),
						"ket" => "Stok Awal",
						"jumlah" => $vV['stok'],
						"tipe" => "masuk",
						"data_of" => Fungsi::dataOfCek()
					]);
				}

			}
			
			event(new ProdukDataBerubah(Fungsi::dataOfCek()));
			event(new BelakangLogging(Fungsi::dataOfCek(), 'edit_produk', [
				'user_id' => Auth::user()->id,
				'nama_produk' => ucwords(strtolower($svProduk['nama_produk']))
			]));
			return redirect()->route("b.produk-edit", ["id_produk" => $id_produk_edit])->with(['msg_success' => 'Produk berhasil diedit!']);
		} else if($request->tipe_kirim_produk == base64_encode("hapus")){

			// return "<pre>".print_r($request->all(), true)."</pre>";
			if($request->ajax()){
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
					}
				} else {
					$ijin = new \stdclass();
					$ijin->hapusProduk = 1;
				}
				if(($ijin->hapusProduk === 1 && $data_user->role == 'Admin') || $data_user->role == 'Owner'){
					$data_cek_hapus = 0;
					$data_hapus = $request->id_produkH;
					foreach(Fungsi::genArray($data_hapus) as $hapus_id){
		
						// $hapus_id = $request->id_produkH;
						$varian_stok_t = DB::table('t_varian_produk')->select('id_varian')->where('produk_id', $hapus_id)->where('data_of', Fungsi::dataOfCek())->get();
						foreach(Fungsi::genArray($varian_stok_t) as $idH){
							$hapus_riwayat = DB::table('t_riwayat_stok')->where('varian_id', $idH->id_varian)->where('data_of', Fungsi::dataOfCek())->delete();
						}
						$nama_produk = DB::table('t_produk')->where('id_produk', $hapus_id)->where('data_of', Fungsi::dataOfCek())->select('nama_produk')->get()->first();
						if(isset($nama_produk)){
							$list_produk[] = ucwords(strtolower($nama_produk->nama_produk));
						}
						$proses = DB::table('t_produk')->where('id_produk', $hapus_id)->where('data_of', Fungsi::dataOfCek())->delete();
						$grosir = DB::table('t_grosir')->where('produk_id', $hapus_id)->where('data_of', Fungsi::dataOfCek())->get();
						if(isset($grosir[0])){
							$proses2 = DB::table('t_grosir')->where('produk_id', $hapus_id)->where('data_of', Fungsi::dataOfCek())->delete();
						}
						$varian = DB::table('t_varian_produk')->where('produk_id', $hapus_id)->where('data_of', Fungsi::dataOfCek())->get();
						if(isset($varian[0])){
							$foto_id = [];
							foreach(Fungsi::genArray($varian) as $v){
								if(!is_null($v->foto_id)){
									$foto_temp = json_decode($v->foto_id);
									if(!is_null($foto_temp->utama)){
										$foto_id[] = $foto_temp->utama;
									}
									if($foto_temp->lain != ""){
										$tval = explode(";", $foto_temp->lain);
										foreach(Fungsi::genArray($tval) as $val){
											$foto_id[] = $val;
										}
									}
								}
							}
							
							if(count($foto_id) > 0){
								foreach(Fungsi::genArray($foto_id) as $f){
									if(is_numeric($f)){
										$foto = DB::table('t_foto')->where('id_foto', $f)->where('data_of', Fungsi::dataOfCek())->get()->first();
										unlink(base_path($foto->path));
										$hapusFoto = DB::table('t_foto')->where('id_foto', $f)->where('data_of', Fungsi::dataOfCek())->delete();
									}
								}
							}
							$proses2 = DB::table('t_varian_produk')->where('produk_id', $hapus_id)->where('data_of', Fungsi::dataOfCek())->delete();
						}
						if($proses){
							$data_cek_hapus++;
						}
					}
					event(new ProdukDataBerubah(Fungsi::dataOfCek()));
					if($data_cek_hapus > 0){
						event(new BelakangLogging(Fungsi::dataOfCek(), 'hapus_produk', [
							'user_id' => Auth::user()->id,
							'nama_produk' => $list_produk
						]));
						return response()->json(['sukses' => true]);
					} else {
						return response()->json(['sukses' => false]);
					}
				} else {
					return response()->json(['sukses' => false]);
				}
			} else {
				abort(404);
			}
		} else {
			abort(404);
		}
	}

	public function editLangsungProduk(Request $request){
		if($request->ajax()){
			switch($request->tipe_kirim_produk){
				case base64_encode("ubah_kategori"):
					$id_produk = $request->id_produk;
					$kategori = $request->kategori;
					if(count($id_produk) < 1){
						return response()->json(['sukses' => false, 'msg' => 'Belum memilih produk!']);
					}
					if(($kategori != "kosong" && is_numeric($kategori)) || $kategori == "kosong"){
						if($kategori == "kosong"){
							$berubah = 0;
							foreach(Fungsi::genArray($id_produk) as $id){
								$edit_prod = DB::table("t_produk")
									->where("data_of", Fungsi::dataOfCek())
									->where('id_produk', $id)
									->update([
										'kategori_produk_id' => null
									]);
								if($edit_prod) $berubah++;
							}
							event(new ProdukDataBerubah(Fungsi::dataOfCek()));
							if($berubah > 0){
								return response()->json(['sukses' => true]);
							} else {
								return response()->json(['sukses' => false, 'msg' => 'Kategori Produk tidak berubah!']);
							}
						} else {
							$id_kat = DB::table('t_kategori_produk')
								->where('data_of', Fungsi::dataOfCek())
								->where("id_kategori_produk", $kategori)
								->select("id_kategori_produk")
								->get()->first();
							if(isset($id_kat)){
								$berubah = 0;
								foreach(Fungsi::genArray($id_produk) as $id){
									$edit_prod = DB::table("t_produk")
										->where("data_of", Fungsi::dataOfCek())
										->where('id_produk', $id)
										->update([
											'kategori_produk_id' => $id_kat->id_kategori_produk
										]);
									if($edit_prod) $berubah++;
								}
								event(new ProdukDataBerubah(Fungsi::dataOfCek()));
								if($berubah > 0){
									return response()->json(['sukses' => true]);
								} else {
									return response()->json(['sukses' => false, 'msg' => 'Kategori Produk tidak berubah!']);
								}
							} else {
								return response()->json(['sukses' => false, 'msg' => 'Kategori Produk tidak ditemukan!']);
							}
						}
					} else {
						return response()->json(['sukses' => false, 'msg' => 'Kategori Produk tidak ditemukan!']);
					}
					break;

				case base64_encode("arsip"):
					$id_produk = $request->id_produk;
					$tipe = ($request->tipe == "arsip") ? 0 : 1;
					if(count($id_produk) < 1){
						return response()->json(['sukses' => false, 'msg' => 'Belum memilih produk!']);
					}
					$berubah = 0;
					foreach(Fungsi::genArray($id_produk) as $id){
						$edit_prod = DB::table("t_produk")
							->where("data_of", Fungsi::dataOfCek())
							->where('id_produk', $id)
							->update([
								'arsip' => $tipe
							]);
						if($edit_prod) $berubah++;
					}
					event(new ProdukDataBerubah(Fungsi::dataOfCek()));
					if($berubah > 0){
						return response()->json(['sukses' => true]);
					} else {
						return response()->json(['sukses' => false, 'msg' => 'Arsip Produk tidak berubah!']);
					}
					break;

				default:
					abort(404);
					break;
			}
		} else {
			abort(404);	
		}
	}

	public function editProduk(Request $request, $id_produk = null){
		if(is_null($id_produk) || preg_match("/\D/", $id_produk)){
			return redirect()->route("b.produk-index");
		}
		$produk = DB::table('t_produk')->where('id_produk', $id_produk)->where('data_of', Fungsi::dataOfCek())->get()->first();
		if(empty($produk)){
			return redirect()->route("b.produk-index")->with(['msg_warning' => 'Produk tidak ditemukan!']);
		}
		$offset_prod = 'P'.DB::table('t_produk')
			->where('data_of', Fungsi::dataOfCek())
			->where('id_produk', $id_produk)
			->select('produk_offset')
			->orderBy('produk_offset', 'desc')
			->get()->first()->produk_offset;
		$varian = DB::table('t_varian_produk')->where('produk_id', $id_produk)->where('data_of', Fungsi::dataOfCek())->get();
		$grosir = DB::table('t_grosir')->where('produk_id', $id_produk)->where('data_of', Fungsi::dataOfCek())->get();
		if($produk->supplier_id == 0){
			$supplier = "Stok Sendiri";
			$_v = 0;
			foreach(Fungsi::genArray($varian) as $v){
				$_v_ = (int)explode('|', $v->stok)[0];
				$_v += $_v_;
			}
			if($_v === 0){
				$cekPicker = 'dari_sendiri_bisa_ubah';
			} else {
				$cekPicker = 'dari_sendiri_tidak_bisa_ubah';
			}
			unset($_v, $_v_);
		} else {
			$cekPicker = 'dari_supplier';
			$sTemp = DB::table('t_supplier')->where('id_supplier',$produk->supplier_id)->where('data_of', Fungsi::dataOfCek())->get()->first();
			if(empty($sTemp)){
				$supplier = "Tidak ditemukan";
			} else {
				$supplier = $sTemp->nama_supplier;
			}
		}
		if(is_null($produk->kategori_produk_id)){
			$kategori = "";
		} else {
			$kTemp = DB::table('t_kategori_produk')->where('id_kategori_produk',$produk->kategori_produk_id)->where('data_of', Fungsi::dataOfCek())->get()->first();
			if(empty($kTemp)){
				$kategori = "";
			} else {
				$kategori = $kTemp->nama_kategori_produk;
			}
		}
		$list_kategori = DB::table('t_kategori_produk')->where('data_of', Fungsi::dataOfCek())->get();
		$jumlah_varian = count($varian);
		
		$ukuranCek = $warnaCek = $resellerCek = $diskonCek = $grosirCek = "";
		foreach($varian as $i => $v){
			if($v->ukuran != ""){
				$ukuranCek = "checked";
			}
			if($v->warna != ""){
				$warnaCek = "checked";
			}
			if($v->harga_jual_reseller != ""){
				$resellerCek = "checked";
			}
			if($v->diskon_jual != ""){
				$diskonCek = "checked";
				$diskon = explode("|", $v->diskon_jual);
				$tipe_diskon2 = ($diskon[1] == "*") ? "checked" : "";
				$tipe_diskon1 = ($diskon[1] == "%") ? "checked" : "";
			} else {
				$tipe_diskon1 = "";
				$tipe_diskon2 = "";
			}
		}
		if($tipe_diskon1 == "" && $tipe_diskon2 == ""){
			$tipe_diskon1 = "checked";
		}
		foreach($grosir as $i => $g){
			if($g->harga != "" && $g->rentan != ""){
				$grosirCek = "checked";
			}
		}
		
		$renMinMax = [
			"min" => "",
			"max" => ""
		];
		$rentan = [
			1 => $renMinMax,
			2 => $renMinMax,
			3 => $renMinMax,
			4 => $renMinMax,
			5 => $renMinMax
		];
		if($grosirCek != ''){
			$grosirCount = count($grosir);
			foreach(Fungsi::genArray($grosir) as $i => $g){
				$r = explode("-", $g->rentan);
				$rentan[$i+1]['min'] = $r[0];
				$rentan[$i+1]['max'] = $r[1];
			}
			$kurangGrosir = 5 - $grosirCount;
			for($i=0; $i<$kurangGrosir; $i++){
				$grosir[$i+($grosirCount)] = new StdClass();
				$grosir[$i+($grosirCount)]->harga = "";
				$grosir[$i+($grosirCount)]->id_grosir = "";
			}
		} else {
			$grosir = [];
			$grosir[0] = new StdClass();
			$grosir[0]->harga = "";
			$grosir[0]->id_grosir = "";
			$grosir[1] = new StdClass();
			$grosir[1]->harga = "";
			$grosir[1]->id_grosir = "";
			$grosir[2] = new StdClass();
			$grosir[2]->harga = "";
			$grosir[2]->id_grosir = "";
			$grosir[3] = new StdClass();
			$grosir[3]->harga = "";
			$grosir[3]->id_grosir = "";
			$grosir[4] = new StdClass();
			$grosir[4]->harga = "";
			$grosir[4]->id_grosir = "";
		}
		$supplier = DB::table('t_supplier')
			->where('data_of', Fungsi::dataOfCek())
			->select('id_supplier', 'nama_supplier')
			->get();
		if($request->ajax()){
			// return Fungsi::parseAjax('belakang.produk-edit', compact('produk', 'varian', 'grosir', 'kategori', 'list_kategori', 
			// 'jumlah_varian', 'ukuranCek', 'warnaCek', 'resellerCek', 'diskonCek', 'grosirCek', 'tipe_diskon1', 'tipe_diskon2', 'rentan'));
			return Fungsi::respon('belakang.produk.edit', compact('cekPicker', 'offset_prod', 'produk', 'varian', 'grosir', 'kategori', 'list_kategori', 
			'jumlah_varian', 'ukuranCek', 'warnaCek', 'resellerCek', 'diskonCek', 'grosirCek', 'tipe_diskon1', 'tipe_diskon2', 'rentan', 'supplier'), "ajax", $request);
		}

		// return view('belakang.produk-edit', compact('produk', 'varian', 'grosir', 'kategori', 'list_kategori', 
		// 'jumlah_varian', 'ukuranCek', 'warnaCek', 'resellerCek', 'diskonCek', 'grosirCek', 'tipe_diskon1', 'tipe_diskon2', 'rentan'));
		return Fungsi::respon('belakang.produk.edit', compact('cekPicker', 'offset_prod', 'produk', 'varian', 'grosir', 'kategori', 'list_kategori', 
		'jumlah_varian', 'ukuranCek', 'warnaCek', 'resellerCek', 'diskonCek', 'grosirCek', 'tipe_diskon1', 'tipe_diskon2', 'rentan', 'supplier'), "html", $request);
	}

	public function detailIndex(Request $request, $id_produk = null){
		if(is_null($id_produk) || preg_match("/\D/", $id_produk)){
            return redirect()->route('b.produk-index');
		}
		$produk = DB::table('t_produk')->where('id_produk', $id_produk)->where('data_of', Fungsi::dataOfCek())->get()->first();
		if(empty($produk)){
			return redirect()->route("b.produk-index")->with(['msg_warning' => 'Produk tidak ditemukan!']);
		}
		unset($produk->data_of);
		$varian = DB::table('t_varian_produk')->where('produk_id', $id_produk)->where('data_of', Fungsi::dataOfCek())->get();
		$grosir = DB::table('t_grosir')->where('produk_id', $id_produk)->where('data_of', Fungsi::dataOfCek())->get();
		$produk->varian = $varian;
		$produk->grosir = $grosir;
		unset($varian);
		unset($grosir);
		$data = new StdClass();
		$data->id_produk = $produk->id_produk;
		$data->nama = $produk->nama_produk;
		$data->supplier = $produk->supplier_id;
		if($produk->kategori_produk_id != ""){
			$kategori = DB::table('t_kategori_produk')->select("nama_kategori_produk")->where('id_kategori_produk', $produk->kategori_produk_id)->get()->first();
			if(isset($kategori)){
				$data->kategori = $kategori->nama_kategori_produk;
			} else {
				$data->kategori = "[?Terhapus?]";
			}
		} else {
			$data->kategori = "-";
		}
		$data->supplier = $produk->supplier_id;
		$data->ket = $produk->ket;
		$data->berat = $produk->berat;
		$data->varian = [];
		$tmp_diskon = $tmp_stok = 0;
		foreach(Fungsi::genArray($produk->varian) as $iP => $vP){
			$data->varian[$iP]["id_varian"] = $vP->id_varian;
			$data->varian[$iP]["sku"] = $vP->sku;
			$data->varian[$iP]["stok"]["nilai"] = "<a style='text-decoration:none;font-weight:bold' id='stokRiwayat-".$vP->id_varian."' href='".route('b.produk-riwayatStok', ["id_varian" => $vP->id_varian])."'>".Fungsi::uangFormat(explode("|", $vP->stok)[0])."</a>";
			$tmp_stok += (int)explode("|", $vP->stok)[0];
			$data->varian[$iP]["stok"]["tipe"] = explode("|", $vP->stok)[1];
			$data->varian[$iP]["harga_beli"] = Fungsi::uangFormat($vP->harga_beli, true);
			if($vP->diskon_jual != ""){
				$tmp_diskon++;
				$tipeDiskon = explode("|", $vP->diskon_jual)[1];
				$diskon = explode("|", $vP->diskon_jual)[0];
				$hargaAwal_normal = $vP->harga_jual_normal;
				$hargaAwal_reseller = $vP->harga_jual_reseller;
				if($tipeDiskon == "%"){
					$hargaDiskon_normal = round(((int)$diskon * (int)$hargaAwal_normal) / 100);
					$hargaDiskon_reseller = round(((int)$diskon * (int)$hargaAwal_reseller) / 100);
					$hargaAkhir_normal = $hargaAwal_normal - $hargaDiskon_normal;
					$hargaAkhir_reseller = $hargaAwal_reseller - $hargaDiskon_reseller;
					$data->varian[$iP]["harga_jual_normal"] = "<s class='text-muted'>".Fungsi::uangFormat($vP->harga_jual_normal, true)."</s><br>".Fungsi::uangFormat($hargaAkhir_normal, true);
					if($vP->harga_jual_reseller != ""){
						$data->varian[$iP]["harga_jual_reseller"] = "<s class='text-muted'>".Fungsi::uangFormat($vP->harga_jual_reseller, true)."</s><br>".Fungsi::uangFormat($hargaAkhir_reseller, true);
					} else {
						$data->varian[$iP]["harga_jual_reseller"] = "<s class='text-muted'>".Fungsi::uangFormat($vP->harga_jual_normal, true)."</s><br>".Fungsi::uangFormat($hargaAkhir_normal, true);
					}
				} else if($tipeDiskon == "*"){
					$hargaAkhir_normal = $hargaAwal_normal - (int)$diskon;
					$hargaAkhir_reseller = $hargaAwal_reseller - (int)$diskon;
					$data->varian[$iP]["harga_jual_normal"] = "<s class='text-muted'>".Fungsi::uangFormat($vP->harga_jual_normal, true)."</s><br>".Fungsi::uangFormat($hargaAkhir_normal, true);
					if($vP->harga_jual_reseller != ""){
						$data->varian[$iP]["harga_jual_reseller"] = "<s class='text-muted'>".Fungsi::uangFormat($vP->harga_jual_reseller, true)."</s><br>".Fungsi::uangFormat($hargaAkhir_reseller, true);
					} else {
						$data->varian[$iP]["harga_jual_reseller"] = "<s class='text-muted'>".Fungsi::uangFormat($vP->harga_jual_normal, true)."</s><br>".Fungsi::uangFormat($hargaAkhir_normal, true);
					}
				}
			} else {
				$data->varian[$iP]["harga_jual_normal"] = Fungsi::uangFormat($vP->harga_jual_normal, true);
				$data->varian[$iP]["harga_jual_reseller"] = ($vP->harga_jual_reseller != "") ? Fungsi::uangFormat($vP->harga_jual_reseller, true) : Fungsi::uangFormat($vP->harga_jual_normal, true);	
			}
			$data->varian[$iP]["ukuran"] = $vP->ukuran;
			$data->varian[$iP]["warna"] = $vP->warna;
			if(!is_null($vP->foto_id)){
				$fotoSrc = json_decode($vP->foto_id);
				if(is_null($fotoSrc)){
					$data->varian[$iP]["foto"] = asset("photo.png");
				} else {
					if(is_numeric($fotoSrc->utama)){
						$foto = DB::table('t_foto')->select("path")->where('id_foto', $fotoSrc->utama)->get()->first();
						if(isset($foto)){
							$data->varian[$iP]["foto"] = asset($foto->path);
						} else {
							$data->varian[$iP]["foto"] = asset("photo.png");
						}
					} else if(filter_var($fotoSrc->utama, FILTER_VALIDATE_URL)){
						$data->varian[$iP]["foto"] = $fotoSrc->utama;
					} else {
						$data->varian[$iP]["foto"] = asset("photo.png");
					}
				}
			} else {
				$data->varian[$iP]["foto"] = asset("photo.png");
			}
		}
		$data->grosir = [];
		foreach(Fungsi::genArray($produk->grosir) as $iG => $vG){
			$data->grosir[$iG]["id_grosir"] = $vG->id_grosir;
			$data->grosir[$iG]["rentan"]["min"] = explode("-", $vG->rentan)[0];
			$data->grosir[$iG]["rentan"]["max"] = explode("-", $vG->rentan)[1];
			$data->grosir[$iG]["harga"] = Fungsi::uangFormat($vG->harga, true);
		}
		// unset($produk);
		$data->cek = [];
		if($tmp_diskon > 0){
			$data->cek["diskon"] = 1;
		} else {
			$data->cek["diskon"] = 0;
		}
		$data->total_stok = $tmp_stok;
		unset($tmp_stok);
		unset($tmp_diskon);
		// echo "<pre>".print_r($produk, true)."</pre>";
		// return;
		if($request->ajax()){
			return Fungsi::respon('belakang.produk.detail', compact("data"), "ajax", $request);
		}
		return Fungsi::respon('belakang.produk.detail', compact("data"), "html", $request);
	}

	public function riwayatStokIndex(Request $request, $id_varian = null){
		if(is_null($id_varian) || preg_match("/\D/", $id_varian)){
            return redirect()->route('b.produk-index');
		}
		$varian = DB::table('t_varian_produk')
			->join("t_produk", "t_produk.id_produk", "=", "t_varian_produk.produk_id")
			->select("t_produk.nama_produk", "t_produk.id_produk", "t_varian_produk.sku")
			->where('t_varian_produk.id_varian', $id_varian)
			->where('t_varian_produk.data_of', Fungsi::dataOfCek())->get()->first();
		if(empty($varian)){
			return redirect()->route("b.produk-index")->with(['msg_warning' => 'Varian produk tidak ditemukan!']);
		}
		if($request->ajax()){
			return Fungsi::respon('belakang.produk.riwayat-stok', compact("varian", "id_varian"), "ajax", $request);
		}
		return Fungsi::respon('belakang.produk.riwayat-stok', compact("varian", "id_varian"), "html", $request);
	}

	public function getRiwayatStok(Request $request){
		if($request->ajax()){
			if(!is_null($request->id)){
				$riwayatStok = DB::table('t_riwayat_stok')
					->where('data_of', Fungsi::dataOfCek())
					->where("varian_id", $request->id)
					->orderBy('tgl', 'asc')
					->get();
				$data = [];
				$i = 0;
				$total = 0;
				foreach(Fungsi::genArray($riwayatStok) as $iRs => $vRs){
					$tgl = date("l, d F Y (H:i:s)", strtotime($vRs->tgl));
					if(preg_match('/Order #/', $vRs->ket)){
						$pls = explode('#', $vRs->ket);
						$data_order = DB::table('t_order')
							->where('data_of', Fungsi::dataOfCek())
							->where('urut_order', $pls[1])
							->get()->first();
						if(isset($data_order)){
							$ket = "<a style='text-decoration:none;' href='".route('b.order-detail', ["id_order" => $data_order->id_order])."'>".$vRs->ket."</a>";
						} else {
							$ket = $vRs->ket;
						}
					} else if(preg_match('/Pembelian Produk \[/', $vRs->ket)){
						$ket = $vRs->ket;
					} else {
						$ket = $vRs->ket;
					}
					if($vRs->tipe == "masuk"){
						$total += (int)$vRs->jumlah;
						$masuk_tampil = "<span class='text-success' style='font-weight:bold'>".$vRs->jumlah."</span>";
						$keluar_tampil = "-";
					} else if($vRs->tipe == "keluar"){
						$total -= (int)$vRs->jumlah;
						$keluar_tampil = "<span class='text-danger' style='font-weight:bold'>".$vRs->jumlah."</span>";
						$masuk_tampil = "-";
					}
					$sisa = "<span style='font-weight:bold'>".$total."</span>";
					$data[$i] = [
						($i+1),
						$tgl,
						$ket,
						$masuk_tampil,
						$keluar_tampil,
						$sisa
					];
					$i++;
				}
				$hasil['data'] = $data; 
				return Fungsi::respon($hasil, [], "json", $request);
			} else {
				$hasil['data'] = []; 
				return Fungsi::respon($hasil, [], "json", $request);
			}
		} else {
			abort(404);
		}
	}

    public function beliProdukIndex(Request $request){
		if($request->ajax()){
			return Fungsi::respon('belakang.produk.beli', [], "ajax", $request);
		}
		return Fungsi::respon('belakang.produk.beli', [], "html", $request);
	}

	public function beliProsesProduk(Request $request){
		if($request->ajax()){
			// return "<pre>".print_r($request->all(), true)."</pre>";
			switch($request->tipe){
				case 'tambah':
					$data = $request->data;
					$nota = strip_tags($request->nota);
					$data_lama = DB::table('t_pembelian_produk')
						->where('data_of', Fungsi::dataOfCek())
						->where('no_nota', $nota)
						->get()->first();
					if(isset($data_lama)){
						return Fungsi::respon([
							'status' => false,
							'msg' => 'Nomer Nota sudah ada!',
						], [], "json", $request);
					}
					$tgl = strip_tags($request->tgl);
					$error = 0;
					$genData = Fungsi::genArray($data);
					$dataVarian = [];
					foreach($genData as $d){
						if(!isset($d['id_varian'])){
							$error++;
							$errorMsg = 'Sepertinya ada yang salah?';
							$genData->stop();
						}
						if(!isset($d['jumlah'])){
							$error++;
							$errorMsg = 'Sepertinya ada yang salah?';
							$genData->stop();
						}
						$data_varian = DB::table('t_varian_produk')
							->where('data_of', Fungsi::dataOfCek())
							->where('id_varian', $d['id_varian'])
							->select('stok')
							->get()->first();
						if(!isset($data_varian)){
							$error++;
							$errorMsg = 'Data Produk Varian tersebut tidak ditemukan!';
							$genData->stop();
						} else {
							$dataVarian[$d['id_varian']] = $data_varian;
						}
					}
					unset($genData);
					if($error > 0){
						return Fungsi::respon([
							'status' => false,
							'msg' => $errorMsg,
						], [], "json", $request);
					} else {
						$genData = Fungsi::genArray($data);
						$berhasil = 0;
						$simpanBeli = DB::table('t_pembelian_produk')->insertGetId([
							'data_of' => Fungsi::dataOfCek(),
							'no_nota' => $nota,
							'tgl_beli' => date("Y-m-d", strtotime($tgl)),
							'tgl_dibuat' => date("Y-m-d H:i:s"),
							'data' => json_encode($data),
							'admin_id' => Auth::user()->id
						]);
						foreach($genData as $d){
							$stok = explode('|', $dataVarian[$d['id_varian']]->stok);
							$stok_baru = (int)$stok[0] + (int)$d['jumlah'];
							$stok[0] = $stok_baru;
							$simpanDataVarian_baru = DB::table('t_varian_produk')
								->where('data_of', Fungsi::dataOfCek())
								->where('id_varian', $d['id_varian'])
								->update([
									'stok' => implode('|', $stok)
								]);
							$riwayatStok_varian = DB::table('t_riwayat_stok')->insert([
								"varian_id" => $d['id_varian'],
								"tgl" => date("Y-m-d H:i:s"),
								"ket" => "Pembelian Produk [".$nota."]",
								"jumlah" => $d['jumlah'],
								"tipe" => "masuk",
								"data_of" => Fungsi::dataOfCek()
							]);
							if($riwayatStok_varian && $simpanDataVarian_baru && $simpanBeli){
								$berhasil++;
							}
						}
						if($berhasil === count($data) && $error === 0){
							event(new ProdukDataBerubah(Fungsi::dataOfCek()));
							Cache::forget('data_beli_produk_lengkap_'.Fungsi::dataOfCek());
							return Fungsi::respon([
								'status' => true,
								'msg' => 'Berhasil menyimpan data pembelian!',
								'id' => $simpanBeli
							], [], "json", $request);
						} else {
							return Fungsi::respon([
								'status' => false,
								'msg' => 'Gagal menyimpan data pembelian!',
							], [], "json", $request);
						}
					}
					break;

				case 'hapus':
					if(isset($request->id)){
						$data_lama = DB::table('t_pembelian_produk')
							->where('data_of', Fungsi::dataOfCek())
							->where('id_pembelian_produk', $request->id)
							->get()->first();
						if(isset($data_lama)){
							$data = json_decode($data_lama->data);
							foreach(Fungsi::genArray($data) as $d){
								$data_produk = DB::table('t_varian_produk')
									->where('data_of', Fungsi::dataOfCek())
									->where('id_varian', $d->id_varian)
									->select('stok')
									->get()->first();
								if(isset($data_produk)){
									$stok = explode('|', $data_produk->stok);
									if((int)$stok[0] > 0){
										$stok_baru = (int)$stok[0] - (int)$d->jumlah;
										$stok[0] = $stok_baru;
										$simpanDataVarian_baru = DB::table('t_varian_produk')
											->where('data_of', Fungsi::dataOfCek())
											->where('id_varian', $d->id_varian)
											->update([
												'stok' => implode('|', $stok)
											]);
									}
								}
								$data_riwayat = DB::table('t_riwayat_stok')
									->where('data_of', Fungsi::dataOfCek())
									->where('varian_id', $d->id_varian)
									->where('ket', 'Pembelian Produk ['.$data_lama->no_nota.']')
									->delete();
							}
							$hapused = DB::table('t_pembelian_produk')
								->where('data_of', Fungsi::dataOfCek())
								->where('id_pembelian_produk', $request->id)
								->delete();
							if($hapused){
								Cache::forget('data_beli_produk_lengkap_'.Fungsi::dataOfCek());
								Cache::forget('data_beli_produk_setiap_'.Fungsi::dataOfCek());
								return Fungsi::respon([
									'status' => true,
									'msg' => 'Berhasil menghapus data pembelian produk!',
								], [], "json", $request);
							} else {
								return Fungsi::respon([
									'status' => false,
									'msg' => 'Gagal menghapus data pembelian produk!',
								], [], "json", $request);
							}
						} else {
							return Fungsi::respon([
								'status' => false,
								'msg' => 'Data pembelian tersebut sudah terhapus!',
							], [], "json", $request);
						}
					} else {
						return Fungsi::respon([
							'status' => false,
							'msg' => 'ID tidak ditemukan!',
						], [], "json", $request);
					}
					break;

				case 'edit':
					dd($request->all());
					break;

				default:
					return Fungsi::respon([
						'status' => false,
						'msg' => 'Salah route!',
					], [], "json", $request);
					break;
			}
		} else {
			abort(404);
		}
	}

    public function dataBeliProdukIndex(Request $request){
		if($request->ajax()){
			return Fungsi::respon('belakang.produk.data-beli.index', [], "ajax", $request);
		}
		return Fungsi::respon('belakang.produk.data-beli.index', [], "html", $request);
	}

    public function dataBeliProdukPrint(Request $request, $target = null){
		if(is_null($target) || preg_match("/[^0-9\-]/", $target)){
            return redirect()->route('b.produk-dataBeli');
		}
		$id = strip_tags($target);
		$data_beli = DB::table('t_pembelian_produk')
			->where('data_of', Fungsi::dataOfCek())
			->where('id_pembelian_produk', $id)
			->get()->first();
		// dd($data_beli);
		if(isset($data_beli)){
			$data = [];
			foreach(Fungsi::genArray(json_decode($data_beli->data)) as $db){
				// dd($db);
				$getData = DB::table('t_varian_produk')
					->join('t_produk', 't_produk.id_produk', '=', 't_varian_produk.produk_id')
					->select('t_varian_produk.ukuran', 't_varian_produk.warna', 't_varian_produk.sku', 't_varian_produk.harga_beli',
						 't_produk.nama_produk', 't_varian_produk.id_varian', 't_produk.supplier_id')
					->where('t_varian_produk.data_of', Fungsi::dataOfCek())
					->get()->first();
				$hasil = new stdClass();
				$hasil->id_varian = $db->id_varian;
				$hasil->jumlah = (int)$db->jumlah;
				$hasil->harga_beli = (int)$db->harga_satuan;
				if(isset($getData)){
					$hasil->nama_produk = $getData->nama_produk;
					if(($getData->ukuran != null && $getData->ukuran != "") && ($getData->warna != null && $getData->warna != "")){
						$hasil->nama_produk .= " (".$getData->ukuran." "+$getData->warna.") ";
					} else if(($getData->ukuran != null && $getData->ukuran != "") && ($getData->warna == null || $getData->warna == "")){
						$hasil->nama_produk .= " (".$getData->ukuran.") ";
					} else if(($getData->ukuran == null || $getData->ukuran == "") && ($getData->warna != null && $getData->warna != "")){
						$hasil->nama_produk .= " (".$getData->warna.") ";
					}
					if($getData->supplier_id === 0){
						$hasil->supplier = 'Stok Sendiri';
					} else {
						$supplier = DB::table('t_supplier')
							->where('data_of', Fungsi::dataOfCek())
							->where('id_supplier', $getData->supplier_id)
							->select('nama_supplier')
							->get()->first();
						if(isset($supplier)){
							$hasil->supplier = ucwords(strtolower($supplier->nama_supplier));
						} else {
							$hasil->supplier = '[?Terhapus?]';
						}
					}
					
				} else {
					$hasil->nama_produk = '[?Terhapus?]';
					$hasil->supplier = '[?Terhapus?]';
				}
				$data[] = $hasil;
			}
		} else {
			return redirect(route('b.produk-dataBeli'))->with([
				'msg_error' => 'ID Pembelian Produk '.$id.' tidak ditemukan!'
			]);
		}
		$toko = DB::table('t_store')
			->where('data_of', Fungsi::dataOfCek())
			->select('nama_toko', 'deskripsi_toko', 'no_telp_toko', 'alamat_toko')
			->get()->first();
		$admin = DB::table('users')
			->where('id', $data_beli->admin_id)
			->select('name')
			->get()->first();
		if(isset($admin)){
			$nama_admin = $admin->name;
		} else {
			$nama_admin = '[?Terhapus?]';
		}
		// dd($data_beli, $toko, $nama_admin, $data);
		return Fungsi::respon('belakang.produk.data-beli.print', compact('data_beli', 'toko', 'nama_admin', 'data'), "html", $request);
	}

	public function dataBeliProdukEdit(Request $request, $target = null){
		if(is_null($target) || preg_match("/[^0-9\-]/", $target)){
            return redirect()->route('b.produk-dataBeli');
		}
		$target = strip_tags($target);
		$data_beli = DB::table('t_pembelian_produk')
			->where('data_of', Fungsi::dataOfCek())
			->where('id_pembelian_produk', $target)
			->get()->first();
		if(isset($data_beli)){
			$list_data = json_decode($data_beli->data);
			$list_id = [];
			foreach(Fungsi::genArray($list_data) as $l){
				$list_id[] = (int)$l->id_varian;
			}
			$data_produk = $this->getProdukTanpaAjax($list_id);
		} else {
			return redirect(route('b.produk-dataBeli'))->with([
				'msg_error' => 'ID Pembelian Produk '.$target.' tidak ditemukan!'
			]);
		}
		if($request->ajax()){
			return Fungsi::respon('belakang.produk.data-beli.edit', compact('data_beli', 'list_id', 'data_produk', 'list_data', 'target'), "ajax", $request);
		}
		return Fungsi::respon('belakang.produk.data-beli.edit', compact('data_beli', 'list_id', 'data_produk', 'list_data', 'target'), "html", $request);
	}

	public function getProdukBeli(Request $request){
		if($request->ajax()){
			$beli_produk = Cache::remember('data_beli_produk_lengkap_'.Fungsi::dataOfCek(), 15000, function(){
				return DB::table('t_pembelian_produk')
					->where('data_of', Fungsi::dataOfCek())
					->get();
			});
			$i = 0;
			// dd($beli_produk);
			$data = [];
			foreach(Fungsi::genArray($beli_produk) as $bp){
				$data_s = json_decode($bp->data);
				$total = 0;
				foreach(Fungsi::genArray($data_s) as $d){
					$total += (int)$d->harga_satuan * (int)$d->jumlah;
				}
				$admin = DB::table('users')
					->where('id', $bp->admin_id)
					->select('name')
					->get()->first();
				if(isset($admin)){
					$nama_admin = $admin->name;
				} else {
					$nama_admin = '[?Terhapus?]';
				}
				$data[$i++] = [
					$bp->no_nota,
					date('j F Y', strtotime($bp->tgl_beli)),
					Fungsi::formatUang($total, true),
					date('j M Y (H:i:s)', strtotime($bp->tgl_dibuat)),
					date('j M Y (H:i:s)', strtotime($bp->tgl_diedit ?? $bp->tgl_dibuat)),
					$nama_admin,
					'<button type="button" class="btnDetail btn btn-info btn-xs" data-id="'.$bp->id_pembelian_produk.'">Detail</button> '.
					'<button type="button" class="btnEdit btn btn-warning btn-xs" data-id="'.$bp->id_pembelian_produk.'">Edit</button> '.
					'<button type="button" class="btnHapus btn btn-danger btn-xs" data-id="'.$bp->id_pembelian_produk.'">Hapus</button>'
				];
			}
			$hasil['data'] = $data; 
			return Fungsi::respon($hasil, [], "json", $request);
		} else {
			abort(404);
		}
	}

	public function getProdukBeliData(Request $request){
		if($request->ajax()){
			if(isset($request->id)){
				$beliData = DB::table('t_pembelian_produk')
					->where('data_of', Fungsi::dataOfCek())
					->where('id_pembelian_produk', $request->id)
					->get()->first();
				if(isset($beliData)){
					if(Cache::has('data_beli_produk_setiap_'.Fungsi::dataOfCek())){
						$data_cache = Cache::get('data_beli_produk_setiap_'.Fungsi::dataOfCek());
						if(isset($data_cache[$request->id])){
							$hasil = $data_cache[$request->id];
						} else {
							$hasil = $this->hitungBeliProdukData($beliData);
							$data_cache[$request->id] = $hasil;
							Cache::put('data_beli_produk_setiap_'.Fungsi::dataOfCek(), $data_cache, 30000);
						}
					} else {
						$hasil = $this->hitungBeliProdukData($beliData);
						Cache::put('data_beli_produk_setiap_'.Fungsi::dataOfCek(), [
							$request->id => $hasil
						], 30000);
					}
					return Fungsi::respon($hasil, [], "json", $request);
				} else {
					return response()->json('kosong');
				}
			} else {
				abort(404);
			}
		} else {
			abort(404);
		}
	}

	private function hitungBeliProdukData($beliData){
		$objGet = DB::table('t_varian_produk')
			->join('t_produk', 't_produk.id_produk', '=', 't_varian_produk.produk_id')
			->select('t_varian_produk.ukuran', 't_varian_produk.warna', 't_varian_produk.sku', 't_varian_produk.harga_beli',
				 't_varian_produk.foto_id', 't_produk.nama_produk', 't_varian_produk.id_varian', 't_produk.supplier_id')
			->where('t_varian_produk.data_of', Fungsi::dataOfCek());
		$data_b = json_decode($beliData->data);
		foreach(Fungsi::genArray($data_b) as $i_b => $b){
			if($i_b == 0){
				$objGet->where('t_varian_produk.id_varian', $b->id_varian);
			} else {
				$objGet->orWhere('t_varian_produk.id_varian', $b->id_varian);
			}
		}
		$objGet->orWhere('t_varian_produk.id_varian', 8);
		$data = $objGet->get()->toArray();
		$hasil = [];
		foreach(Fungsi::genArray($data_b) as $i_d => $d){
			$index = array_search($d->id_varian, array_column($data, 'id_varian'));
			$hasil[$i_d] = new stdClass();
			$hasil[$i_d]->id_varian = $d->id_varian;
			$hasil[$i_d]->jumlah = (int)$d->jumlah;
			$hasil[$i_d]->harga_beli = (int)$d->harga_satuan;
			$hasil[$i_d]->foto = asset("photo.png");
			if($index === false){
				$hasil[$i_d]->terhapus = true;
			} else {
				$hasil[$i_d]->terhapus = false;
				$hasil[$i_d]->sku = $data[$index]->sku;
				$hasil[$i_d]->ukuran = $data[$index]->ukuran;
				$hasil[$i_d]->warna = $data[$index]->warna;
				$hasil[$i_d]->nama_produk = ucwords(strtolower($data[$index]->nama_produk));
				if($data[$index]->supplier_id === 0){
					$hasil[$i_d]->supplier = 'Stok Sendiri';
				} else {
					$supplier = DB::table('t_supplier')
						->where('data_of', Fungsi::dataOfCek())
						->where('id_supplier', $data[$index]->supplier_id)
						->select('nama_supplier')
						->get()->first();
					if(isset($supplier)){
						$hasil[$i_d]->supplier = ucwords(strtolower($supplier->nama_supplier));
					} else {
						$hasil[$i_d]->supplier = '[?Terhapus?]';
					}
				}
				if(!is_null($data[$index]->foto_id)){
					$fotoSrc = json_decode($data[$index]->foto_id);
					if(!is_null($fotoSrc->utama)){
						if(is_numeric($fotoSrc->utama)){
							$fotoUtama = DB::table('t_foto')->where('id_foto', $fotoSrc->utama)->where('data_of', Fungsi::dataOfCek())->get()->first();
							$hasil[$i_d]->foto = asset($fotoUtama->path);
							unset($fotoUtama);
						} else if(filter_var($fotoSrc->utama, FILTER_VALIDATE_URL)){
							$hasil[$i_d]->foto = $fotoSrc->utama;
						} else {
							$hasil[$i_d]->foto = asset("photo.png");
						}
					} else {
						$hasil[$i_d]->foto = asset("photo.png");
					}
				} else {
					$hasil[$i_d]->foto = asset("photo.png");
				}

			}
		}
		return $hasil;
	}

	private function getProdukTanpaAjax(array $id){
		$produk = Cache::remember('data_produk_ajax_'.Fungsi::dataOfCek(), 30000, function(){
			return DB::table('t_varian_produk')
				->join('t_produk', 't_produk.id_produk', '=', 't_varian_produk.produk_id')
				->select('t_varian_produk.id_varian', 't_varian_produk.produk_id', 't_varian_produk.diskon_jual', 't_varian_produk.harga_beli',
				't_varian_produk.harga_jual_normal', 't_varian_produk.harga_jual_reseller', 't_produk.ket', 't_produk.berat', 
				't_varian_produk.foto_id', 't_produk.nama_produk', 't_produk.kategori_produk_id', 't_produk.supplier_id', 't_varian_produk.sku',
				't_varian_produk.stok', 't_varian_produk.ukuran',  't_varian_produk.warna')
				->where('t_varian_produk.data_of', Fungsi::dataOfCek())
				->where('t_produk.arsip', 0)
				->get();
		})->toArray();
		// dd($produk);
		$data = [];
		foreach(Fungsi::genArray($id) as $i => $v){
			$index = array_search($v, array_column($produk, 'id_varian'));
			$data[] = (array)$produk[$index];
			if($data[$i]['supplier_id'] == 0 || is_null($data[$i]['supplier_id'])){
				$data[$i]['supplier']['id'] = null;
				$data[$i]['supplier']['nama'] = null;
			} else {
				$supplier = DB::table('t_supplier')->select('nama_supplier')->where('id_supplier', $data[$i]['supplier_id'])->where('data_of', Fungsi::dataOfCek())->get()->first();
				if(isset($supplier)){
					$data[$i]['supplier']['id'] = $data[$i]['supplier_id'];
					$data[$i]['supplier']['nama'] = $supplier->nama_supplier;
				} else {
					$data[$i]['supplier']['id'] = $data[$i]['supplier_id'];
					$data[$i]['supplier']['nama'] = null;
				}
			}
			$data[$i]['nama_produk_tampil'] = $this->parseNamaProduk($data[$i]);
			$data[$i]['supplier_tampil'] = $this->parseSupplierProduk($data[$i]);
			$data[$i] = (object)$data[$i];
		}
		// dd($data);
		return $data;
	}

	private function parseNamaProduk(&$v){
		$nama_produk_tampil = $v['nama_produk'];
		if(($v['ukuran'] != null && $v['ukuran'] != "") && ($v['warna'] != null && $v['warna'] != "")){
			$nama_produk_tampil .= " (".$v['ukuran']." ".$v['warna'].") ";
		} else if(($v['ukuran'] != null && $v['ukuran'] != "") && ($v['warna'] == null || $v['warna'] == "")){
			$nama_produk_tampil .= " (".$v['ukuran'].") ";
		} else if(($v['ukuran'] == null || $v['ukuran'] == "") && ($v['warna'] != null && $v['warna'] != "")){
			$nama_produk_tampil .= " (".$v['warna'].") ";
		}
		return $nama_produk_tampil;
	}

	private function parseSupplierProduk(&$v){
		$cekStok = explode('|', $v['stok']);
		$nama_produk_tampil = '';
		if($cekStok[1] == 'sendiri'){
			$nama_produk_tampil .= "Stok Sendiri";
		} else if($cekStok[1] == 'lain'){
			if($v['supplier']['id'] !== null){
				$nama_produk_tampil .= ucwords(strtolower($v['supplier']['nama']));
			} else {
				$nama_produk_tampil .= "[?Terhapus?]";
			}
		}
		return $nama_produk_tampil;
	}
	
}