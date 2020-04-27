<?php

namespace App\Http\Controllers\belakang;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\PusatController as Fungsi;
use Illuminate\Support\Facades\Hash;
use App\Events\BelakangLogging;
use Illuminate\Contracts\Encryption\DecryptException;
use \stdclass;
use \htmlentities;
use Swift_Mailer;
use Swift_SmtpTransport;
use App\Mail\NotifResiEmailAddon;
use App\Helpers\AddonNotifWa;

class OrderController extends Controller
{
	public function __construct(){
		$this->middleware('b.auth');
		$this->middleware('b.locale');
		// $this->middleware('xss_protect');
	}

	public function redirectIndex(){
		return redirect()->route("b.order-index");
	}

	private function parseDataOrder(&$data_order, &$tml, &$data_user, &$ijin){
		$order = [];
		$popover = [];
		$list_order_json_ = [];
		$temp = "";
		foreach($this->genArray($data_order) as $i => $d){
			$list_order_json_[] = $d->urut_order;
			$dataC_tujuan = DB::table("t_customer")
				->join("users", "users.id", "=", "t_customer.user_id")
				->select("t_customer.*", "users.name", "users.no_telp", "users.email")
				->where("user_id", $d->tujuan_kirim_id)
				->where("data_of", Fungsi::dataOfCek())
				->get()->first();
			$popover[$i]["tujuan"] = $dataC_tujuan;
			unset($dataC_tujuan);
			$dataC_pemesan = DB::table("t_customer")
				->join("users", "users.id", "=", "t_customer.user_id")
				->select("t_customer.*", "users.name", "users.no_telp", "users.email")
				->where("user_id", $d->pemesan_id)
				->where("data_of", Fungsi::dataOfCek())
				->get()->first();
			$popover[$i]["pemesan"] = $dataC_pemesan;
			unset($dataC_pemesan);
			$lacakResiAble = 0;
			$temp = str_replace("{!id_order!}", $d->id_order, $tml);
			$temp = str_replace("{!urut_order!}", $d->urut_order, $temp);
			$temp = str_replace("{!url_print!}", route('b.print-index').'/'.$d->urut_order, $temp);
			$temp = str_replace("{!delay_anim!}", ($i+3)."00", $temp);
			$temp = str_replace("{!index_mypop!}", ($i+1), $temp);
			$temp = str_replace("{!index_mypop_2!}", ($i+1)."-2", $temp);
			// $temp = str_replace("{!modBayar_orderId!}", '"'.$d->id_order.'"', $temp);
			$temp = str_replace("{!src_order!}", ucwords(strtolower($d->src)), $temp);
			$catatan = json_decode($d->catatan);
			if($catatan->print == "true"){
				$temp = str_replace("{!catatan!}", '<div class="alert alert-info mt-sm-down-20 rad-parent"><span>'.$catatan->data.'</span></div>', $temp);
			} else {
				$temp = str_replace("{!catatan!}", '', $temp);
			}
			unset($catatan);

			$newDate = date("l, j M Y", strtotime($d->tanggal_order));
			$temp = str_replace("{!tanggal_order!}", $newDate, $temp);
			unset($newDate);

			$cust = DB::table('users')->select("name")->where("id", $d->pemesan_id)->get()->first();
			if(isset($cust)){
				$temp = str_replace("{!nama_pemesan!}", ucwords(strtolower($cust->name)), $temp);
			} else {
				$temp = str_replace("{!nama_pemesan!}", "[?Terhapus?]", $temp);
			}
			unset($cust);

			$cust_t = DB::table('users')->select("name")->where("id", $d->tujuan_kirim_id)->get()->first();
			if(isset($cust_t)){
				$temp = str_replace("{!nama_tujuan!}", ucwords(strtolower($cust_t->name)), $temp);
			} else {
				$temp = str_replace("{!nama_tujuan!}", "[?Terhapus?]", $temp);
			}
			unset($cust_t);
			
			if(strtolower($d->src) == "app"){
				$adm = DB::table('users')->select("name")->where("id", $d->admin_id)->get()->first();
				$temp = str_replace("{!nama_admin!}", "<div class='text-muted'>Admin: </div><div class='ml-10'>".ucwords(strtolower($adm->name))."</div>", $temp);
				unset($adm);
			} else {
				$temp = str_replace("{!nama_admin!}", "", $temp);
			}

			$produk = json_decode($d->produk);
			$list_prod = "";
			$c_prod = 0;
			foreach($produk->list as $p){
				$cekP = DB::table('t_produk')->select("nama_produk")->where("id_produk", $p->rawData->produk_id)->get()->first();
				if(isset($cekP)){
					$list_prod .= "<li class='ml--15'>".ucwords(strtolower($p->rawData->nama_produk))."&nbsp;&nbsp;&nbsp;x".$p->jumlah."</li>";
				} else {
					$list_prod .= "<li class='ml--15'>[?Terhapus?]&nbsp;&nbsp;&nbsp;x".$p->jumlah."</li>";
				}
				$c_prod += (int)$p->jumlah;
			}
			$temp = str_replace("{!list_produk!}", $list_prod, $temp);
			$temp = str_replace("{!jumlah_produk!}", (string)$c_prod, $temp);
			unset($c_prod);
			unset($list_prod);
			unset($produk);

			$total = 0;
			$totalD = json_decode($d->total);
			$total += (int)$totalD->hargaProduk + (int)$totalD->hargaOngkir;
			if(!is_null($totalD->biayaLain)){
				foreach($totalD->biayaLain as $biaya){
					$total += (int)$biaya->harga;
				}
				unset($biaya);
			}
			if(!is_null($totalD->diskonOrder)){
				foreach($totalD->diskonOrder as $diskon){
					$total -= (int)$diskon->harga;
				}
				unset($diskon);
			}
			$temp = str_replace("{!total_bayar!}", Fungsi::uangFormat($total, true), $temp);
			unset($total);
			unset($totalD);

			$pembayaran = json_decode($d->pembayaran);
			if($pembayaran->status == "belum"){
				$temp = str_replace("{!data_bayar!}", "", $temp);
				$temp = str_replace("{!css_status_bayar!}", "bayar-belum", $temp);
				$temp = str_replace("{!btn_riwayat_bayar!}", "", $temp);
				$temp = str_replace("{!css_btn_status_bayar!}", "badge-danger", $temp);
				$temp = str_replace("{!btn_update_bayar!}", '<button class="btn btn-default btn-outline ml-5 btnBayarMod" data-target="#bayarMod" data-id="{!id_order!}" data-urut="{!urut_order!}" data-toggle="modal" type="button">Update Bayar</button>', $temp);
				$temp = str_replace("{!id_order!}", $d->id_order, $temp);
				$temp = str_replace("{!urut_order!}", $d->urut_order, $temp);
				$temp = str_replace("{!tulisan_btn_status_bayar!}", "Belum Bayar", $temp);
				$temp = str_replace("{!via_bayar!}", "", $temp);
			} else if($pembayaran->status == "cicil"){
				$lacakResiAble++;
				$temp = str_replace("{!css_status_bayar!}", "bayar-cicil", $temp);
				$temp = str_replace("{!css_btn_status_bayar!}", "badge-warning", $temp);
				$temp = str_replace("{!btn_riwayat_bayar!}", "<button type='button' class='btn btn-default btn-outline ml-10 btnRiwayatBayar' data-target='#riwayatMod' data-toggle='modal'><i class='fa fa-info'></i>&nbsp;&nbsp;Riwayat Pembayaran</button>", $temp);
				$temp = str_replace("{!btn_update_bayar!}", '<button class="btn btn-default btn-outline ml-5 btnBayarMod" data-target="#bayarMod" data-id="{!id_order!}" data-urut="{!urut_order!}" data-toggle="modal" type="button">Update Bayar</button>', $temp);
				$temp = str_replace("{!id_order!}", $d->id_order, $temp);
				$temp = str_replace("{!urut_order!}", $d->urut_order, $temp);
				$temp = str_replace("{!tulisan_btn_status_bayar!}", "Cicilan", $temp);
				$totalD = json_decode($d->total);
				// $total = ((int)$totalD->hargaProduk + (int)$totalD->hargaOngkir + ($totalD->biayaLain == "null" ? 0 : (int)$totalD->biayaLain)) - ($totalD->diskonOrder == "null" ? 0 : (int)$totalD->diskonOrder);
				$total = (int)$totalD->hargaProduk + (int)$totalD->hargaOngkir;
				if(!is_null($totalD->biayaLain)){
					foreach($totalD->biayaLain as $biaya){
						$total += (int)$biaya->harga;
					}
					unset($biaya);
				}
				if(!is_null($totalD->diskonOrder)){
					foreach($totalD->diskonOrder as $diskon){
						$total -= (int)$diskon->harga;
					}
					unset($diskon);
				}
				$bayar = DB::table('t_pembayaran')->select("id_bayar", "nominal", "order_id", "tgl_bayar", "via")->where("order_id", $d->id_order)->get();
				foreach($bayar as $b){
					$total -= (int)$b->nominal;
				}
				$dataBayar["bayar"] = $pembayaran;
				$dataBayar["riwayat"] = $bayar;
				$temp = str_replace("{!data_bayar!}", json_encode($dataBayar), $temp);
				$temp = str_replace("{!via_bayar!}", '<span class="badge badge-default badge-outline mr-1 mb-2 mt-1" style="border-color:#757575"><span style="color:#757575" class="bayarStat"> - '.Fungsi::uangFormat($total, true).'</span></span>', $temp);
				unset($total);
				unset($dataBayar);
				unset($totalD);
				unset($bayar);
			} else if($pembayaran->status == "lunas"){
				$lacakResiAble++;
				$bayar = DB::table('t_pembayaran')->where("order_id", $d->id_order)->get();
				$dataBayar["bayar"] = $pembayaran;
				$dataBayar["riwayat"] = $bayar;
				$tmp_via = DB::table('t_pembayaran')->select("via")->where("order_id", $d->id_order)->orderBy('tgl_bayar', 'desc')->get()->first();
				if(!isset($tmp_via)){
					$via_bayar = count(explode('|', $pembayaran->via)) == 2 ? explode('|', $pembayaran->via)[1] : explode('|', $pembayaran->via)[0];;
				} else {
					$via_bayar = count(explode('|', $tmp_via->via)) == 2 ? explode('|', $tmp_via->via)[1] : explode('|', $tmp_via->via)[0];
				}
				$temp = str_replace("{!data_bayar!}", json_encode($dataBayar), $temp);
				$temp = str_replace("{!css_status_bayar!}", "bayar-lunas", $temp);
				$temp = str_replace("{!btn_riwayat_bayar!}", "<button type='button' class='btn btn-default btn-outline ml-10 btnRiwayatBayar' data-target='#riwayatMod' data-toggle='modal'><i class='fa fa-info'></i>&nbsp;&nbsp;Riwayat Pembayaran</button>", $temp);
				$temp = str_replace("{!btn_update_bayar!}", '', $temp);
				$temp = str_replace("{!css_btn_status_bayar!}", "badge-success", $temp);
				$temp = str_replace("{!tulisan_btn_status_bayar!}", "Lunas", $temp);
				$newD = date("j M Y", strtotime($pembayaran->tanggalBayar));
				$temp = str_replace("{!via_bayar!}", '<span class="badge badge-default badge-outline mr-1 mb-2 mt-1" style="border-color:#757575"><span style="color:#757575">'.$via_bayar.' ('.$newD.')</span></span>', $temp);
				unset($newD);
				unset($dataBayar);
				unset($bayar);
			}


			$kurir = json_decode($d->kurir);
			if($kurir->tipe == "expedisi"){
				$exped = explode("|", $kurir->data)[0];
				if($exped == 'jnt'){
					$exped = 'j&t';
				}
				$plm = "<div style='position: relative;padding: 15px;background-color: #f3f7fa;border: 1px solid #eee;margin-top: -20px;width: 80%;'>{!isi!}</div>";
				$hasil = "<span style='border:4px solid #A3AFB7; padding:5px'><b>".strtoupper($exped)."</b></span>".
					"<span style='border:1px solid #A3AFB7; padding:5px; font-size:15px' class='ml-4 {!css_resi!}'>Resi: <span class='resiDiv'>{!resi!}</span></span>";
				$plm = str_replace("{!isi!}", $hasil, $plm);
				$temp = str_replace("{!kurir!}", $plm, $temp);
				$temp = str_replace("{!btn_tandai_terima!}", "", $temp);
				if(!is_null($d->resi)){
					$lacakResiAble++;
					$temp = str_replace("{!resi!}", $d->resi, $temp);
					$temp = str_replace("{!css_resi!}", "btnResi", $temp);
					$temp = str_replace("{!btn_update_resi!}", "", $temp);
				} else {
					$pembayaran = json_decode($d->pembayaran);
					if($pembayaran->status == "cicil" || $pembayaran->status == "lunas"){
						$temp = str_replace("{!btn_update_resi!}", "<button type='button' class='btn btn-default btn-outline ml-5 btnUpdateResi'>Update Resi</button>", $temp);
						$temp = str_replace("{!resi!}", "-", $temp);
						$temp = str_replace("{!css_resi!}", "", $temp);
					} else {
						$temp = str_replace("{!btn_update_resi!}", "", $temp);
						$temp = str_replace("{!resi!}", "-", $temp);
						$temp = str_replace("{!css_resi!}", "", $temp);
					}
				}
				unset($plm);
			} else if($kurir->tipe == "kurir"){
				$hasil = ($kurir->data->nama == "" ? "[Tanpa Nama]" : $kurir->data->nama);
				$temp = str_replace("{!kurir!}", $hasil, $temp);
				$temp = str_replace("{!btn_update_resi!}", "", $temp);
				if($pembayaran->status == "lunas" || $pembayaran->status == "cicil"){
					if($d->state == "terima"){
						$temp = str_replace("{!btn_tandai_terima!}", "", $temp);
					} else {
						$temp = str_replace("{!btn_tandai_terima!}", "<button type='button' class='btn btn-default btn-outline ml-5 btnTandaiTerima'>Tandai diterima</button>", $temp);
					}
				} else {
					$temp = str_replace("{!btn_tandai_terima!}", "", $temp);
				}
			} else {
				$hasil = "[Ambil di Toko]";
				$temp = str_replace("{!kurir!}", $hasil, $temp);
				$temp = str_replace("{!btn_update_resi!}", "", $temp);
				if($pembayaran->status == "lunas" || $pembayaran->status == "cicil"){
					if($d->state == "terima"){
						$temp = str_replace("{!btn_tandai_terima!}", "", $temp);
					} else {
						$temp = str_replace("{!btn_tandai_terima!}", "<button type='button' class='btn btn-default btn-outline ml-5 btnTandaiTerima'>Tandai diterima</button>", $temp);
					}
				} else {
					$temp = str_replace("{!btn_tandai_terima!}", "", $temp);
				}
			}
			unset($kurir);
			unset($hasil);


			if($d->state == "bayar"){
				$temp = str_replace("{!state_order1!}", "current", $temp);
				$temp = str_replace("{!state_order2!}", "", $temp);
				$temp = str_replace("{!state_order3!}", "", $temp);
				$temp = str_replace("{!state_order4!}", "", $temp);
				$temp = str_replace("{!state_order_tooltip!}", "state-order-bayar", $temp);
			} else if($d->state == "proses"){
				$temp = str_replace("{!state_order1!}", "done", $temp);
				$temp = str_replace("{!state_order2!}", "current", $temp);
				$temp = str_replace("{!state_order3!}", "", $temp);
				$temp = str_replace("{!state_order4!}", "", $temp);
				$temp = str_replace("{!state_order_tooltip!}", "state-order-proses", $temp);
			} else if($d->state == "kirim"){
				$lacakResiAble++;
				$temp = str_replace("{!state_order1!}", "done", $temp);
				$temp = str_replace("{!state_order2!}", "done", $temp);
				$temp = str_replace("{!state_order3!}", "current", $temp);
				$temp = str_replace("{!state_order4!}", "", $temp);
				$temp = str_replace("{!state_order_tooltip!}", "state-order-kirim", $temp);
			} else if($d->state == "terima"){
				$temp = str_replace("{!state_order1!}", "done", $temp);
				$temp = str_replace("{!state_order2!}", "done", $temp);
				$temp = str_replace("{!state_order3!}", "done", $temp);
				$temp = str_replace("{!state_order4!}", "current", $temp);
				$temp = str_replace("{!state_order_tooltip!}", "state-order-terima", $temp);
			}
			

			$temp = str_replace("{!url_detail_order!}", route('b.order-detail', ["id_order" => $d->id_order]), $temp);
			if(($ijin->editOrder === 1 && $data_user->role == 'Admin') || $data_user->role == 'Owner'){
				if(((int)$d->admin_id) === Auth::user()->id){
					$temp = str_replace("{!btn_edit_order!}", '<button type="button" class="btn btn-default btn-outline" onClick="pageLoad(\'{!url_edit_order!}\')">Edit Order</button>', $temp);
					$temp = str_replace("{!url_edit_order!}", route('b.order-edit', ["id_order" => $d->id_order]), $temp);
				} else {
					if(($ijin->editOrderAdminLain === 1 && $data_user->role == 'Admin') || $data_user->role == 'Owner'){
						$temp = str_replace("{!btn_edit_order!}", '<button type="button" class="btn btn-default btn-outline" onClick="pageLoad(\'{!url_edit_order!}\')">Edit Order</button>', $temp);
						$temp = str_replace("{!url_edit_order!}", route('b.order-edit', ["id_order" => $d->id_order]), $temp);
					} else {
						$temp = str_replace("{!btn_edit_order!}", '<button type="button" class="btn btn-default btn-outline disabled">Edit Order</button>', $temp);
					}
				}
			} else {
				$temp = str_replace("{!btn_edit_order!}", '<button type="button" class="btn btn-default btn-outline disabled">Edit Order</button>', $temp);
			}
			if(($ijin->cancelOrder === 1 && $data_user->role == 'Admin') || $data_user->role == 'Owner'){
				$temp = str_replace("{!btn_cancel_order!}", '<div class="dropdown-divider"></div><a class="dropdown-item btnCancelOrder" style="color:red" href="javascript:void(0)" role="menuitem">Cancel Order</a>', $temp);
			} else {
				$temp = str_replace("{!btn_cancel_order!}", '', $temp);
			}
			if($lacakResiAble == 3){
				$temp = str_replace("{!btn_lacak_resi!}", "<button type='button' class='btn btn-default btn-outline ml-5 btnLacakResi'>Lacak Resi</button>", $temp);
			} else {
				$temp = str_replace("{!btn_lacak_resi!}", "", $temp);
			}
			
			if($d->print_label){
				$temp = str_replace("{!tooltip_print!}", "tooltip-print", $temp);
			} else {
				$temp = str_replace("{!tooltip_print!}", "", $temp);
			}


			$order[$i] = $temp;
			$temp = "";
		}
		return [$order, $popover, $list_order_json_];
	}

    public function semuaIndex(Request $request){
		list($data_user, $ijin) = $this->getIjinUser();
		$admin_filter = DB::table('t_user_meta')
			->join('users', 'users.id', '=', 't_user_meta.id_user_meta')
			->where('t_user_meta.data_of', Fungsi::dataOfCek())
			->where('t_user_meta.role', 'Admin')
			->select('t_user_meta.id_user_meta', 'users.name')
			->get()->toArray();
		// dd($admin_filter);
		$bank = DB::table('t_bank')
			->select('bank', 'no_rek', 'cabang', 'atas_nama', 'id_bank')
			->where('data_of', Fungsi::dataOfCek())
			->get();
		$bank_list = "";
		$bank_filter = [];
		foreach($this->genArray($bank) as $b){
			$bank_filter[] = [
				'id' => $b->id_bank,
				'bank' => $b->bank,
			];
			$bank_list .= "<a class='dropdown-item pilihViaBayar' data-idb='".$b->id_bank."' href='javascript:void(0)' role='menuitem'><span>".$b->bank."</span></a>";
		}
		$tml = <<<CUT
		<div class='row-list-order mb-40 animation-slide-left selectBug' style='animation-delay:{!delay_anim!}ms' data-id='{!id_order!}' data-urut='{!urut_order!}'>
			<div class="row row-list-order-head">
				<div class="col-sm-4 col-md-3 col-lg-3">
					<h3 class="d-inline">
						<strong>Order #{!urut_order!}</strong>
					</h3>
					<div>
						<span class="text-muted">dari</span>
						<span>{!src_order!}</span>
						<span class="text-muted">({!tanggal_order!})</span>
					</div>
				</div>
				<div class="col-sm-8 col-md-6 col-lg-6">
					{!catatan!}
				</div>
				<div class="col-xs-12 col-md-3">
					<div class="pearls pearls-sm row mt-3 {!state_order_tooltip!}">
						<div class="pearl {!state_order1!} col-3">
							<div class="pearl-icon"><i class="icon fa fa-money" aria-hidden="true"></i></div>
						</div>
						<div class="pearl {!state_order2!} col-3">
							<div class="pearl-icon"><i class="icon fa fa-cube" aria-hidden="true"></i></div>
						</div>
						<div class="pearl {!state_order3!} col-3">
							<div class="pearl-icon"><i class="icon fa fa-road" aria-hidden="true"></i></div>
						</div>
						<div class="pearl {!state_order4!} col-3">
							<div class="pearl-icon"><i class="icon fa fa-thumbs-up" aria-hidden="true"></i></div>
						</div>
					</div>
				</div>
			</div>
			<div class="row row-list-order-body">
				<textarea id='dataBayar-{!id_order!}' class='hidden'>{!data_bayar!}</textarea>
				<div class='col-md-4'>
					<div class='mb-20'>
						<div class='text-muted text-uppercase'>Pemesan</div>
						<span class='ml-10 font-size-20' id='myPop-{!index_mypop!}' style='cursor:pointer;'>{!nama_pemesan!}</span>
					</div>
					<div class='mb-20'>
						<div class='text-muted text-uppercase'>Dikirim Kepada</div>
						<span class='ml-10 font-size-20' id='myPop-{!index_mypop_2!}' style='cursor:pointer;'>{!nama_tujuan!}</span>
					</div>
					<div class='d-flex mb-20'>
						{!nama_admin!}
					</div>
				</div>
				<div class='col-md-4'>
					<div>
						<div class='text-muted text-uppercase'>Produk ({!jumlah_produk!} Item)</div>
						<ul>
							{!list_produk!}
						</ul>
					</div>
				</div>
				<div class='col-md-4'>
					<div class='mb-20'>
						<div class='text-muted text-uppercase'>Kurir</div>
						<span class='ml-10 font-size-20'>{!kurir!}</span>
					</div>
					<div>
						<div class='text-muted text-uppercase'>Total Bayar</div>
						<div class="total-bayar-info {!css_status_bayar!}" style="padding: 10px"
							data-original-title="" title="">
							<div>
								<strong class="total-bayar">{!total_bayar!}</strong>
							</div>
							<div class="d-flex flex-wrap mb--5">
								<div class="badge mr-1 mb-2 mt-1 badge-status-order {!css_btn_status_bayar!} text-uppercase"
									style='letter-spcaing:2px;cursor:default'>
									<span>{!tulisan_btn_status_bayar!}</span>
								</div>
								{!via_bayar!}
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row row-list-order-footer">
				<div class='col-md-6'>
					<label for="list-tanda">
						<input type="checkbox" class="icek" name="list-tanda" id="pilihCheck-{!urut_order!}">
					</label>
					<a href='{!url_print!}' class='btn btn-default btn-outline ml-10 {!tooltip_print!}'><i class='fa fa-print'></i>&nbsp;&nbsp;Print</a>
					{!btn_riwayat_bayar!}
				</diV>
				<div class='col-md-6 text-right'>
					{!btn_update_bayar!}
					{!btn_update_resi!}
					{!btn_tandai_terima!}
					{!btn_lacak_resi!}
					<div class="btn-group ml-5">
						{!btn_edit_order!}
						<button type="button" class="btn btn-default dropdown-toggle btn-outline"
							id="exampleSplitDropdown1" data-toggle="dropdown" aria-expanded="false">
						</button>
						<div class="dropdown-menu" aria-labelledby="exampleSplitDropdown1" role="menu"
							style="position: absolute; will-change: transform; transform: translate3d(73px, 36px, 0px); top: 0px; left: 0px;">
							<a class="dropdown-item" href="javascript:void(0);" onClick="pageLoad('{!url_detail_order!}')" role="menuitem">Detail Order</a>
							{!btn_cancel_order!}
						</div>
					</div>
				</diV>
			</div>
		</div>
CUT;
		// dd($f_);
		$data_order = DB::table('t_order')->where("data_of", Fungsi::dataOfCek())->where("canceled", 0)->orderBy("id_order", "desc")->paginate(10);
		list($order, $popover, $list_order_json_) = $this->parseDataOrder($data_order, $tml, $data_user, $ijin);
		$list_order_json = json_encode($list_order_json_);
		$filter_order = Cache::remember('data_filter_order_lengkap_'.Fungsi::dataOfCek(), 10000, function(){
			return DB::table('t_filter_order')->where('data_of', Fungsi::dataOfCek())->get();
		});
		$data_filter = "";
		foreach($this->genArray($filter_order) as $iF => $vF){
			$data = [];
			$data["f_admin"] = $vF->f_admin;
			$data["f_bayar"] = $vF->f_bayar;
			$data["f_kirim"] = $vF->f_kirim;
			$data["f_via"] = $vF->f_via;
			$data["f_kurir"] = $vF->f_kurir;
			$data["f_print"] = $vF->f_print;
			$data["f_tglTipe"] = $vF->f_tglTipe;
			$data["f_tglDari"] = $vF->f_tglDari;
			$data["f_tglSampai"] = $vF->f_tglSampai;
			$data["f_orderSource"] = $vF->f_orderSource;
			$data_filter .= '<li class="p-5 animation-slide-top" style="animation-delay:'.($iF+8).'00ms;">'.
            	'<a class="btn btn-round p-15 btnFilterClick filterBtnDefault" data-id="'.$vF->id_filter_order.'" href="javascript:void(0)">'.
                	'<i class="icon wb-search" aria-hidden="true"></i>'.$vF->nama_filter.
            	'</a>'.
				'<textarea class="hidden">'.json_encode($data).'</textarea>'.
			'</li>';
			unset($data);
		}
		$order_source['cek'] = DB::table('t_store')
			->where('data_of', Fungsi::dataOfCek())
			->select('s_order_source')
			->get()->first()->s_order_source;
		$order_source['data'] = DB::table('t_order_source')
			->where('data_of', Fungsi::dataOfCek())
			->where('status', 1)
			->get();
		if($request->ajax()){
			return Fungsi::respon('belakang.order.semua', compact('admin_filter', "order", "data_order", 'data_filter', 'popover', 'bank_list', 'order_source', 'list_order_json', 'data_user', 'ijin', 'bank_filter'), "ajax", $request);
			// return Fungsi::parseAjax('belakang.semua_order');
		}
		return Fungsi::respon('belakang.order.semua', compact('admin_filter', "order", "data_order", 'data_filter', 'popover', 'bank_list', 'order_source', 'list_order_json', 'data_user', 'ijin', 'bank_filter'), "html", $request);
    }

    public function cancelIndex(Request $request){
		$tml = <<<CUT
		<div class='row-list-order mb-40 animation-slide-left selectBug' style='animation-delay:{!delay_anim!}ms' data-id='{!id_order!}' data-urut='{!urut_order!}'>
			<div class="row row-list-order-head">
				<div class="col-sm-4 col-md-3 col-lg-3">
					<h3 class="d-inline">
						<strong>Order #{!urut_order!}</strong>
					</h3>
					<div>
						<span class="text-muted">dari</span>
						<span>{!src_order!}</span>
						<span class="text-muted">({!tanggal_order!})</span>
					</div>
				</div>
				<div class="col-sm-8 col-md-6 col-lg-6">
					{!catatan!}
				</div>
				<div class="col-xs-12 col-md-3">
					<div class="pearls pearls-sm row mt-3 {!state_order_tooltip!}">
						<div class="pearl {!state_order1!} col-3">
							<div class="pearl-icon"><i class="icon fa fa-money" aria-hidden="true"></i></div>
						</div>
						<div class="pearl {!state_order2!} col-3">
							<div class="pearl-icon"><i class="icon fa fa-cube" aria-hidden="true"></i></div>
						</div>
						<div class="pearl {!state_order3!} col-3">
							<div class="pearl-icon"><i class="icon fa fa-road" aria-hidden="true"></i></div>
						</div>
						<div class="pearl {!state_order4!} col-3">
							<div class="pearl-icon"><i class="icon fa fa-thumbs-up" aria-hidden="true"></i></div>
						</div>
					</div>
				</div>
			</div>
			<div class="row row-list-order-body">
				<textarea id='dataBayar-{!id_order!}' class='hidden'>{!data_bayar!}</textarea>
				<div class='col-md-4'>
					<div class='mb-20'>
						<div class='text-muted text-uppercase'>Pemesan</div>
						<span class='ml-10 font-size-20' id='myPop-{!index_mypop!}' style='cursor:pointer;'>{!nama_pemesan!}</span>
					</div>
					<div class='mb-20'>
						<div class='text-muted text-uppercase'>Dikirim Kepada</div>
						<span class='ml-10 font-size-20' id='myPop-{!index_mypop_2!}' style='cursor:pointer;'>{!nama_tujuan!}</span>
					</div>
					<div class='d-flex mb-20'>
						{!nama_admin!}
					</div>
				</div>
				<div class='col-md-4'>
					<div>
						<div class='text-muted text-uppercase'>Produk ({!jumlah_produk!} Item)</div>
						<ul>
							{!list_produk!}
						</ul>
					</div>
				</div>
				<div class='col-md-4'>
					<div class='mb-20'>
						<div class='text-muted text-uppercase'>Kurir</div>
						<span class='ml-10 font-size-20'>{!kurir!}</span>
					</div>
					<div>
						<div class='text-muted text-uppercase'>Total Bayar</div>
						<div class="total-bayar-info {!css_status_bayar!}" style="padding: 10px"
							data-original-title="" title="">
							<div>
								<strong class="total-bayar">{!total_bayar!}</strong>
							</div>
							<div class="d-flex flex-wrap mb--5">
								<div class="badge mr-1 mb-2 mt-1 badge-status-order {!css_btn_status_bayar!} text-uppercase"
									style='letter-spcaing:2px;cursor:default'>
									<span>{!tulisan_btn_status_bayar!}</span>
								</div>
								{!via_bayar!}
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row row-list-order-footer">
				<div class='col-md-6'>
					{!btn_detail_order!}
				</diV>
				<div class='col-md-6 text-right'>
					{!btn_kembali_order!}
					{!btn_hapus_order!}
				</diV>
			</div>
		</div>
CUT;
		$data_order = DB::table('t_order')->where("data_of", Fungsi::dataOfCek())->where("canceled", 1)->orderBy("id_order", "desc")->paginate(10);
		$order = [];
		$temp = "";
		$popover = [];
		foreach($this->genArray($data_order) as $i => $d){
			$dataC_tujuan = DB::table("t_customer")
				->join("users", "users.id", "=", "t_customer.user_id")
				->select("t_customer.*", "users.name", "users.no_telp", "users.email")
				->where("user_id", $d->tujuan_kirim_id)
				->where("data_of", Fungsi::dataOfCek())
				->get()->first();
			$popover[$i]["tujuan"] = $dataC_tujuan;
			unset($dataC_tujuan);
			$dataC_pemesan = DB::table("t_customer")
				->join("users", "users.id", "=", "t_customer.user_id")
				->select("t_customer.*", "users.name", "users.no_telp", "users.email")
				->where("user_id", $d->pemesan_id)
				->where("data_of", Fungsi::dataOfCek())
				->get()->first();
			$popover[$i]["pemesan"] = $dataC_pemesan;
			unset($dataC_pemesan);
			$lacakResiAble = 0;
			$temp = str_replace("{!id_order!}", $d->id_order, $tml);
			$temp = str_replace("{!urut_order!}", $d->urut_order, $temp);
			$temp = str_replace("{!delay_anim!}", ($i+3)."00", $temp);
			$temp = str_replace("{!index_mypop!}", ($i+1), $temp);
			$temp = str_replace("{!index_mypop_2!}", ($i+1)."-2", $temp);
			// $temp = str_replace("{!modBayar_orderId!}", '"'.$d->id_order.'"', $temp);
			$temp = str_replace("{!src_order!}", ucwords(strtolower($d->src)), $temp);
			$temp = str_replace("{!btn_kembali_order!}", "<button type='button' class='btn btn-success btn-outline ml-10 btnKembaliOrder'>Kembalikan Order</button>", $temp);
			$temp = str_replace("{!btn_hapus_order!}", "<button type='button' class='btn btn-danger btn-outline ml-10 btnHapusOrder'>Hapus Order</button>", $temp);
			$temp = str_replace("{!btn_detail_order!}", "<a href='".route('b.order-detail', ["id_order" => $d->id_order])."' class='btn btn-info btn-outline ml-10 btnDetailOrder'>Detail Order</a>", $temp);

			$catatan = json_decode($d->catatan);
			if($catatan->print == "true"){
				$temp = str_replace("{!catatan!}", '<div class="alert alert-info mt-sm-down-20 rad-parent"><span>'.$catatan->data.'</span></div>', $temp);
			} else {
				$temp = str_replace("{!catatan!}", '', $temp);
			}
			unset($catatan);

			$newDate = date("l, j M Y", strtotime($d->tanggal_order));
			$temp = str_replace("{!tanggal_order!}", $newDate, $temp);
			unset($newDate);

			$cust = DB::table('users')->select("name")->where("id", $d->pemesan_id)->get()->first();
			if(isset($cust)){
				$temp = str_replace("{!nama_pemesan!}", ucwords(strtolower($cust->name)), $temp);
			} else {
				$temp = str_replace("{!nama_pemesan!}", "[?Terhapus?]", $temp);
			}
			unset($cust);

			$cust_t = DB::table('users')->select("name")->where("id", $d->tujuan_kirim_id)->get()->first();
			if(isset($cust_t)){
				$temp = str_replace("{!nama_tujuan!}", ucwords(strtolower($cust_t->name)), $temp);
			} else {
				$temp = str_replace("{!nama_tujuan!}", "[?Terhapus?]", $temp);
			}
			unset($cust_t);
			
			if(strtolower($d->src) == "app"){
				$adm = DB::table('users')->select("name")->where("id", $d->admin_id)->get()->first();
				$temp = str_replace("{!nama_admin!}", "<div class='text-muted'>Admin: </div><div class='ml-10'>".ucwords(strtolower($adm->name))."</div>", $temp);
				unset($adm);
			} else {
				$temp = str_replace("{!nama_admin!}", "", $temp);
			}

			$produk = json_decode($d->produk);
			$list_prod = "";
			$c_prod = 0;
			foreach($produk->list as $p){
				$cekP = DB::table('t_produk')->select("nama_produk")->where("nama_produk", $p->rawData->nama_produk)->get()->first();
				if(isset($cekP)){
					$list_prod .= "<li class='ml--15'>".ucwords(strtolower($p->rawData->nama_produk))."&nbsp;&nbsp;&nbsp;x".$p->jumlah."</li>";
				} else {
					$list_prod .= "<li class='ml--15'>[?Terhapus?]&nbsp;&nbsp;&nbsp;x".$p->jumlah."</li>";
				}
				$c_prod += (int)$p->jumlah;
			}
			$temp = str_replace("{!list_produk!}", $list_prod, $temp);
			$temp = str_replace("{!jumlah_produk!}", (string)$c_prod, $temp);
			unset($c_prod);
			unset($list_prod);
			unset($produk);

			$total = 0;
			$totalD = json_decode($d->total);
			$total += (int)$totalD->hargaProduk + (int)$totalD->hargaOngkir;
			if(!is_null($totalD->biayaLain)){
				foreach($totalD->biayaLain as $biaya){
					$total += (int)$biaya->harga;
				}
				unset($biaya);
			}
			if(!is_null($totalD->diskonOrder)){
				foreach($totalD->diskonOrder as $diskon){
					$total -= (int)$diskon->harga;
				}
				unset($diskon);
			}
			$temp = str_replace("{!total_bayar!}", Fungsi::uangFormat($total, true), $temp);
			unset($total);
			unset($totalD);

			$pembayaran = json_decode($d->pembayaran);
			if($pembayaran->status == "belum"){
				$temp = str_replace("{!data_bayar!}", "", $temp);
				$temp = str_replace("{!css_status_bayar!}", "bayar-belum", $temp);
				$temp = str_replace("{!btn_riwayat_bayar!}", "", $temp);
				$temp = str_replace("{!css_btn_status_bayar!}", "badge-danger", $temp);
				$temp = str_replace("{!id_order!}", $d->id_order, $temp);
				$temp = str_replace("{!urut_order!}", $d->urut_order, $temp);
				$temp = str_replace("{!tulisan_btn_status_bayar!}", "Belum Bayar", $temp);
				$temp = str_replace("{!via_bayar!}", "", $temp);
			} else if($pembayaran->status == "cicil"){
				$lacakResiAble++;
				$temp = str_replace("{!css_status_bayar!}", "bayar-cicil", $temp);
				$temp = str_replace("{!css_btn_status_bayar!}", "badge-warning", $temp);
				$temp = str_replace("{!id_order!}", $d->id_order, $temp);
				$temp = str_replace("{!urut_order!}", $d->urut_order, $temp);
				$temp = str_replace("{!tulisan_btn_status_bayar!}", "Cicilan", $temp);
				$totalD = json_decode($d->total);
				// $total = ((int)$totalD->hargaProduk + (int)$totalD->hargaOngkir + ($totalD->biayaLain == "null" ? 0 : (int)$totalD->biayaLain)) - ($totalD->diskonOrder == "null" ? 0 : (int)$totalD->diskonOrder);
				$total = (int)$totalD->hargaProduk + (int)$totalD->hargaOngkir;
				if(!is_null($totalD->biayaLain)){
					foreach($totalD->biayaLain as $biaya){
						$total += (int)$biaya->harga;
					}
					unset($biaya);
				}
				if(!is_null($totalD->diskonOrder)){
					foreach($totalD->diskonOrder as $diskon){
						$total -= (int)$diskon->harga;
					}
					unset($diskon);
				}
				$bayar = DB::table('t_pembayaran')->select("id_bayar", "nominal", "order_id", "tgl_bayar", "via")->where("order_id", $d->id_order)->get();
				foreach($bayar as $b){
					$total -= (int)$b->nominal;
				}
				$dataBayar["bayar"] = $pembayaran;
				$dataBayar["riwayat"] = $bayar;
				$temp = str_replace("{!data_bayar!}", json_encode($dataBayar), $temp);
				$temp = str_replace("{!via_bayar!}", '<span class="badge badge-default badge-outline mr-1 mb-2 mt-1" style="border-color:#757575"><span style="color:#757575" class="bayarStat"> - '.Fungsi::uangFormat($total, true).'</span></span>', $temp);
				unset($total);
				unset($dataBayar);
				unset($totalD);
				unset($bayar);
			} else if($pembayaran->status == "lunas"){
				$lacakResiAble++;
				$bayar = DB::table('t_pembayaran')->where("order_id", $d->id_order)->get();
				$dataBayar["bayar"] = $pembayaran;
				$dataBayar["riwayat"] = $bayar;
				$tmp_via = DB::table('t_pembayaran')->select("via")->where("order_id", $d->id_order)->orderBy('tgl_bayar', 'desc')->get()->first();
				if(!isset($tmp_via)){
					$via_bayar = count(explode('|', $pembayaran->via)) == 2 ? explode('|', $pembayaran->via)[1] : explode('|', $pembayaran->via)[0];;
				} else {
					$via_bayar = count(explode('|', $tmp_via->via)) == 2 ? explode('|', $tmp_via->via)[1] : explode('|', $tmp_via->via)[0];
				}
				$temp = str_replace("{!data_bayar!}", json_encode($dataBayar), $temp);
				$temp = str_replace("{!css_status_bayar!}", "bayar-lunas", $temp);
				$temp = str_replace("{!css_btn_status_bayar!}", "badge-success", $temp);
				$temp = str_replace("{!tulisan_btn_status_bayar!}", "Lunas", $temp);
				$newD = date("j M Y", strtotime($pembayaran->tanggalBayar));
				$temp = str_replace("{!via_bayar!}", '<span class="badge badge-default badge-outline mr-1 mb-2 mt-1" style="border-color:#757575"><span style="color:#757575">'.$via_bayar.' ('.$newD.')</span></span>', $temp);
				unset($newD);
				unset($dataBayar);
				unset($bayar);
			}


			$kurir = json_decode($d->kurir);
			if($kurir->tipe == "expedisi"){
				$exped = explode("|", $kurir->data)[0];
				if($exped == 'jnt'){
					$exped = 'j&t';
				}
				$plm = "<div style='position: relative;padding: 15px;background-color: #f3f7fa;border: 1px solid #eee;margin-top: -20px;width: 80%;'>{!isi!}</div>";
				$hasil = "<span style='border:4px solid #A3AFB7; padding:5px'><b>".strtoupper($exped)."</b></span>".
					"<span style='border:1px solid #A3AFB7; padding:5px; font-size:15px' class='ml-4 {!css_resi!}'>Resi: <span class='resiDiv'>{!resi!}</span></span>";
				$plm = str_replace("{!isi!}", $hasil, $plm);
				$temp = str_replace("{!kurir!}", $plm, $temp);
				if(!is_null($d->resi)){
					$lacakResiAble++;
					$temp = str_replace("{!resi!}", $d->resi, $temp);
					$temp = str_replace("{!css_resi!}", "btnResi", $temp);
				} else {
					$temp = str_replace("{!resi!}", "-", $temp);
					$temp = str_replace("{!css_resi!}", "", $temp);
				}
				unset($plm);
			} else if($kurir->tipe == "kurir"){
				$hasil = ($kurir->data->nama == "" ? "[Tanpa Nama]" : $kurir->data->nama);
				$temp = str_replace("{!kurir!}", $hasil, $temp);
			} else {
				$hasil = "[Ambil di Toko]";
				$temp = str_replace("{!kurir!}", $hasil, $temp);
			}
			unset($kurir);
			unset($hasil);


			if($d->state == "bayar"){
				$temp = str_replace("{!state_order1!}", "current", $temp);
				$temp = str_replace("{!state_order2!}", "", $temp);
				$temp = str_replace("{!state_order3!}", "", $temp);
				$temp = str_replace("{!state_order4!}", "", $temp);
				$temp = str_replace("{!state_order_tooltip!}", "state-order-bayar", $temp);
			} else if($d->state == "proses"){
				$temp = str_replace("{!state_order1!}", "done", $temp);
				$temp = str_replace("{!state_order2!}", "current", $temp);
				$temp = str_replace("{!state_order3!}", "", $temp);
				$temp = str_replace("{!state_order4!}", "", $temp);
				$temp = str_replace("{!state_order_tooltip!}", "state-order-proses", $temp);
			} else if($d->state == "kirim"){
				$lacakResiAble++;
				$temp = str_replace("{!state_order1!}", "done", $temp);
				$temp = str_replace("{!state_order2!}", "done", $temp);
				$temp = str_replace("{!state_order3!}", "current", $temp);
				$temp = str_replace("{!state_order4!}", "", $temp);
				$temp = str_replace("{!state_order_tooltip!}", "state-order-kirim", $temp);
			} else if($d->state == "terima"){
				$temp = str_replace("{!state_order1!}", "done", $temp);
				$temp = str_replace("{!state_order2!}", "done", $temp);
				$temp = str_replace("{!state_order3!}", "done", $temp);
				$temp = str_replace("{!state_order4!}", "current", $temp);
				$temp = str_replace("{!state_order_tooltip!}", "state-order-terima", $temp);
			}
			


			$order[$i] = $temp;
			$temp = "";
		}
		if($request->ajax()){
			return Fungsi::respon('belakang.order.cancel', compact("order", "data_order", 'popover'), "ajax", $request);
			// return Fungsi::parseAjax('belakang.semua_order');
		}
		return Fungsi::respon('belakang.order.cancel', compact("order", "data_order", 'popover'), "html", $request);
	}
	
	public function saveOrder(Request $request){
		// return "<pre>".print_r(json_decode($request->dataRaw, true), true)."</pre>";
		$data = json_decode($request->dataRaw);
		$catatan["print"] = $data->catatanPrint;
		$catatan["data"] = $data->catatan;
		$urutObj = DB::table('t_order')->select("urut_order")->where('data_of', Fungsi::dataOfCek())->orderBy("urut_order", "desc")->get()->first();
		$urut = is_null($urutObj) ? 1 : $urutObj->urut_order+1;
		$last_id = DB::table('t_order')->insertGetId([
			'urut_order' => $urut,
			'pemesan_id' => $data->idPemesan_customer,
			'pemesan_kategori' => $data->pemesan_kat,
			'tujuan_kirim_id' => $data->idUntukKirim_customer,
			'kecamatan_asal_kirim_id' => $data->idDariKirim_kecamatan,
			'tanggal_order' => $data->tanggalOrder,
			'pembayaran' => json_encode($data->pembayaran),
			'produk' => json_encode($data->produk),
			'kurir' => json_encode($data->kurir),
			'total' => json_encode($data->total),
			'catatan' => json_encode($catatan),
			'state' => $data->state,
			'cicilan_state' => ($data->pembayaran->status == "cicil") ? 1 : 0,
			'src' => $data->src,
			'admin_id' => ($data->src == "app") ? Fungsi::dataOfCek() : null,
			'order_source_id' => ($data->order_source == "") ? null : $data->order_source,
			'kat_customer' => $data->kat_customer,
			'tgl_dibuat' => date("Y-m-d"),
			'data_of' => Fungsi::dataOfCek()
		]);
		if($data->pembayaran->status == "cicil" || $data->pembayaran->status == "lunas"){
			$proses = DB::table('t_pembayaran')->insert([
				'tgl_bayar' => $data->pembayaran->tanggalBayar,
				'nominal' => (int)$data->pembayaran->nominal,
				'via' => $data->pembayaran->via,
				'order_id' => $last_id,
				'data_of' => Fungsi::dataOfCek()
			]);
		}
		Cache::forget('data_order_lengkap_'.Fungsi::dataOfCek());
		Cache::forget('data_transaksi_lengkap_'.Fungsi::dataOfCek());
		Cache::forget('data_laporan_'.Fungsi::dataOfCek());
		if(isset($last_id)){
			event(new BelakangLogging(Fungsi::dataOfCek(), 'tambah_order', [
				'user_id' => Auth::user()->id,
				'urut_order' => $urut
			]));
			if($data->redirect == "simpan"){
				return redirect()->route('b.order-index')->with(['msg_success' => 'Order baru berhasil ditambahkan!']);
			} else {
				return redirect()->route('b.order-tambah')->with(['msg_success' => 'Order baru berhasil ditambahkan!']);
			}
		} else {
			if($data->redirect == "simpan"){
				return redirect()->route('b.order-index')->with(['msg_success' => 'Gagal menambahkan Order baru!']);
			} else {
				return redirect()->route('b.order-tambah')->with(['msg_success' => 'Gagal menambahkan Order baru!']);
			}
		}
	}
    
    public function orderTambah(Request $request){
		$wilayah_indonesia = Fungsi::getContent('data/wilayah_indonesia.json');
		$bank = DB::table('t_bank')
			->select('bank', 'no_rek', 'cabang', 'atas_nama', 'id_bank')
			->where('data_of', Fungsi::dataOfCek())
			->get();
		$bank_list = "";
		foreach($this->genArray($bank) as $b){
			$bank_list .= "<a class='dropdown-item pilihViaBayar' data-idb='".$b->id_bank."' href='javascript:void(0)' role='menuitem'><span>".$b->bank."</span></a>";
		}
		unset($bank);
		$pass = Fungsi::acakPass();
		$data_store = DB::table('t_store')
			->where('data_of', Fungsi::dataOfCek())
			->select('cek_ongkir', 'kat_customer')
			->get()->first();
		$cekOngkir = [];
		foreach($this->genArray(json_decode($data_store->cek_ongkir)) as $iO => $vO){
			if($vO){
				array_push($cekOngkir, $iO);
			}
		}
		$cekOngkir = json_encode($cekOngkir);
		$kat_customer = $data_store->kat_customer;
		unset($data_store);
		$order_source['cek'] = DB::table('t_store')
			->where('data_of', Fungsi::dataOfCek())
			->select('s_order_source')
			->get()->first()->s_order_source;
		$order_source['data'] = DB::table('t_order_source')
			->where('data_of', Fungsi::dataOfCek())
			->where('status', 1)
			->get();
		if($request->ajax()){
			return Fungsi::respon('belakang.order.tambah', compact('pass', 'wilayah_indonesia', 'bank_list', 'cekOngkir', 'kat_customer', 'order_source'), "ajax", $request);
		}
		return Fungsi::respon('belakang.order.tambah', compact('pass', 'wilayah_indonesia', 'bank_list', 'cekOngkir', 'kat_customer', 'order_source'), "html", $request);
	}

	public function proses(Request $request){
		switch($request->tipeKirim){
			case "tambah_customer":
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
								'created_at' => date("Y-m-d H:i:s"),
								'updated_at' => date("Y-m-d H:i:s")
							]);
						}
					} else {
						$data_t = 'kosong|'.str_random();
						$lastUser_id = DB::table('users')->insertGetId([
							'name' => $request->namaC,
							'email' => $data_t,
							'no_telp' => $request->no_telpC,
							'password' => Hash::make($data_t),
							'created_at' => date("Y-m-d H:i:s"),
							'updated_at' => date("Y-m-d H:i:s")
						]);
					}
					$proses = DB::table('t_customer')->insert([
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
					if($proses){
						event(new BelakangLogging(Fungsi::dataOfCek(), 'tambah_customer', [
							'user_id' => Auth::user()->id,
							'kategori' => $request->kategoriC,
							'nama' => $request->namaC,
						]));
						return response()->json(['sukses' => true, 'last_id' => $lastUser_id]);
					} else {
						return response()->json(['sukses' => false, 'msg' => 'Gagal menambah customer!']);
					}
				}
				break;

			case "update_bayar":
				$data = json_decode($request->dataRaw);
				$dataOrder = DB::table('t_order')->select("pembayaran", "total")->where("id_order", $data->id_order)->where("data_of", Fungsi::dataOfCek())->get()->first();
				$dataBaru = json_decode($dataOrder->pembayaran);
				$totalD = json_decode($dataOrder->total);
				$total = ((int)$totalD->hargaProduk + (int)$totalD->hargaOngkir);
				if(!is_null($totalD->biayaLain)){
					foreach(Fungsi::genArray($totalD->biayaLain) as $b){
						$total += $b->harga;
					}
				}
				if(!is_null($totalD->diskonOrder)){
					foreach(Fungsi::genArray($totalD->diskonOrder) as $d){
						$total -= $d->harga;
					}
				}
				$bayar = DB::table('t_pembayaran')->where("order_id", $data->id_order)->where("data_of", Fungsi::dataOfCek())->get();
				foreach($bayar as $b){
					$total -= (int)$b->nominal;
				}
				if($request->resiCek == "true"){
					$resiState = "kirim";
				} else if($request->resiCek == "false"){
					$resiState = "proses";	
				}
				if($data->cicil_state == 0 && $data->nominal == ""){
					$proses = DB::table('t_pembayaran')->insert([
						'tgl_bayar' => $data->tgl_bayar,
						'nominal' => $total,
						'via' => $data->via,
						'order_id' => $data->id_order,
						'data_of' => Fungsi::dataOfCek()
					]);
					$dataBaru->status = "lunas";
					DB::table('t_order')->where("id_order", $data->id_order)->where("data_of", Fungsi::dataOfCek())->update([
						"pembayaran" => json_encode($dataBaru),
						"state" => $resiState
					]);
				} else if($data->cicil_state == 1 && $data->nominal != ""){
					if($total > (int)$data->nominal){
						echo "b";
						$proses = DB::table('t_pembayaran')->insert([
							'tgl_bayar' => $data->tgl_bayar,
							'nominal' => (int)$data->nominal,
							'via' => $data->via,
							'order_id' => $data->id_order,
							'data_of' => Fungsi::dataOfCek()
						]);
						$dataBaru->status = "cicil";
						DB::table('t_order')->where("id_order", $data->id_order)->where("data_of", Fungsi::dataOfCek())->update([
							"pembayaran" => json_encode($dataBaru),
							"cicilan_state" => 1
						]);
					} else if($total == (int)$data->nominal){
						echo "c";
						$proses = DB::table('t_pembayaran')->insert([
							'tgl_bayar' => $data->tgl_bayar,
							'nominal' => $total,
							'via' => $data->via,
							'order_id' => $data->id_order,
							'data_of' => Fungsi::dataOfCek()
						]);
						$dataBaru->status = "lunas";
						DB::table('t_order')->where("id_order", $data->id_order)->where("data_of", Fungsi::dataOfCek())->update([
							"pembayaran" => json_encode($dataBaru),
							"cicilan_state" => 1,
							"state" => $resiState
						]);
					}
				}
				Cache::forget('data_order_lengkap_'.Fungsi::dataOfCek());
				Cache::forget('data_transaksi_lengkap_'.Fungsi::dataOfCek());
				Cache::forget('data_laporan_'.Fungsi::dataOfCek());
				Cache::forget('data_edit_order_'.$data->id_order.'_'.Fungsi::dataOfCek());
				return redirect(url()->previous())->with([
					'msg_success' => 'Berhasil mengupdate pembayaran!',
					'id_update' => $data->id_order
				]);
				break;

			case "tandai_terima":
				// echo "<pre>".print_r($request->id_order, true)."</pre>";
				$hasil = DB::table('t_order')->where("id_order", $request->id_order)->where("data_of", Fungsi::dataOfCek())->update([
					"state" => "terima"
				]);
				$data_order = DB::table('t_order')->where("id_order", $request->id_order)->where("data_of", Fungsi::dataOfCek())->get()->first();
				if(isset($data_order)){
					$produk = json_decode($data_order->produk);
					foreach(Fungsi::genArray($produk->list) as $p){
						$varian_ = $p->rawData;
						$cekVarian = DB::table('t_varian_produk')->where("id_varian", $varian_->id_varian)->where("data_of", Fungsi::dataOfCek())->get()->first();
						if(isset($cekVarian)){
							$t_stok = explode('|', $cekVarian->stok);
							if((int)$t_stok[0] > 0 && $t_stok[1] == 'sendiri'){
								$t_stok_ = (int)$t_stok[0];
								$t_stok_ -= (int)$p->jumlah;
								$t_stok[0] = $t_stok_;
								$stokUbah = implode('|', $t_stok);
								$ubahStokVarian = DB::table('t_varian_produk')
									->where("id_varian", $varian_->id_varian)
									->where("data_of", Fungsi::dataOfCek())
									->update([
										'stok' => $stokUbah
									]);
								$riwayatStok_varian = DB::table('t_riwayat_stok')->insert([
									"varian_id" => $varian_->id_varian,
									"tgl" => date("Y-m-d H:i:s"),
									"ket" => "Order #".$data_order->urut_order,
									"jumlah" => $p->jumlah,
									"tipe" => "keluar",
									"data_of" => Fungsi::dataOfCek()
								]);
							}
						}
					}
				}
				Cache::forget('data_order_lengkap_'.Fungsi::dataOfCek());
				Cache::forget('data_laporan_'.Fungsi::dataOfCek());
				Cache::forget('data_edit_order_'.$request->id_order.'_'.Fungsi::dataOfCek());
				if($hasil){
					return redirect(url()->previous())->with([
						'msg_success' => 'Berhasil menandai barang sudah diterima Customer!',
						'id_update' => $request->id_order
					]);
				}
				break;

			case "update_resi":
				// dd($request->all());
				$resi = htmlentities($request->resi);
				$hasil = DB::table('t_order')->where("id_order", $request->id_order)->where("data_of", Fungsi::dataOfCek())->update([
					"resi" => $resi,
					"state" => "kirim"
				]);
				Cache::forget('data_order_lengkap_'.Fungsi::dataOfCek());
				Cache::forget('data_laporan_'.Fungsi::dataOfCek());
				Cache::forget('data_edit_order_'.$request->id_order.'_'.Fungsi::dataOfCek());
				if($hasil){

					$cekAddon = Cache::remember('data_addons_'.Fungsi::dataOfCek(), 30000, function(){
						return DB::table('t_addons')
							->where('data_of', Fungsi::dataOfCek())
							->get()->first();
					});

					$cekError = [];
					$cekAktifAddon['notif_resi_email'] = false;
					$cekAktifAddon['notif_wa'] = false;

					if($cekAddon->notif_resi_email === 1){
						$cekAktifAddon['notif_resi_email'] = true;
						$addonData = Cache::remember('data_addons_data_notif_resi_email_'.Fungsi::dataOfCek(), 30000, function(){
							$data = DB::table('t_addons_data')
								->where('data_of', Fungsi::dataOfCek())
								->get()->first();
							if(isset($data)){
								if(is_null($data->notif_resi_email)){
									return null;
								} else {
									return unserialize(decrypt($data->notif_resi_email));
								}
							} else {
								return null;
							}
						});

						$userData = DB::table('t_order')
							->join('users', 'users.id', '=', 't_order.pemesan_id')
							->where('id_order', $request->id_order)
							->select('users.no_telp', 'users.name', 't_order.kurir', 'users.email')
							->get()->first();
						$nama_toko = DB::table('t_store')
							->where('data_of', Fungsi::dataOfCek())
							->select('nama_toko')
							->get()->first()->nama_toko;
						$kurir = json_decode($userData->kurir);
						if($kurir->tipe == 'expedisi'){
							$data_kurir = strtoupper(explode('|', $kurir->data)[0]);
						} else if($kurir->tipe == 'toko'){
							$data_kurir = 'Ambil di toko';
						} else if($kurir->tipe == 'kurir'){
							$data_kurir = ucwords(strtolower($kurir->data->nama));
						}
						$emailFrom = DB::table('users')
							->where('id', Fungsi::dataOfCek())
							->get()->first()->email;

						$pesan_email = str_replace('%nama_customer%', $userData->name, $addonData['pesan']);
						$pesan_email = str_replace('%resi%', $resi, $pesan_email);
						$pesan_email = str_replace('%nama_toko%', $nama_toko, $pesan_email);
						$pesan_email = str_replace('%id_order%', '#'.$request->id_order, $pesan_email);
						$pesan_email = str_replace('%kurir%', $data_kurir, $pesan_email);
						
						try {

							$backup = Mail::getSwiftMailer();
							
							$transport = new Swift_SmtpTransport($addonData['smtp']['hostname'], $addonData['smtp']['port'], (!is_null($addonData['smtp']['security']) ? $addonData['smtp']['security'] : null));
							$transport->setUsername($addonData['smtp']['username']);
							$transport->setPassword(trim(decrypt($addonData['smtp']['password'])));
							
							$gmail = new Swift_Mailer($transport);
							
							Mail::setSwiftMailer($gmail);

							Mail::to($userData->email)->send(new NotifResiEmailAddon([
								'alamat' => $emailFrom,
								'nama' => $nama_toko
							], 'plain', $pesan_email));
							
							Mail::setSwiftMailer($backup);

						} catch(\Exception $e){
							$cekError['notif_resi_email'] = $e->getMessage();
						}

					}

					unset($addonData);

					if($cekAddon->notif_wa === 1){
						$cekAktifAddon['notif_wa'] = true;
						$objNotifWa = new AddonNotifWa(Fungsi::dataOfCek());
						$addonData = $objNotifWa->getData('resi_update');
						
						if($addonData['aktif'] === true){
							
							$userData = DB::table('t_order')
								->join('users', 'users.id', '=', 't_order.pemesan_id')
								->where('id_order', $request->id_order)
								->select('users.no_telp', 'users.name', 't_order.kurir')
								->get()->first();
							$nama_toko = DB::table('t_store')
								->where('data_of', Fungsi::dataOfCek())
								->select('nama_toko')
								->get()->first()->nama_toko;
							$kurir = json_decode($userData->kurir);
							if($kurir->tipe == 'expedisi'){
								$data_kurir = strtoupper(explode('|', $kurir->data)[0]);
							} else if($kurir->tipe == 'toko'){
								$data_kurir = 'Ambil di toko';
							} else if($kurir->tipe == 'kurir'){
								$data_kurir = ucwords(strtolower($kurir->data->nama));
							}
							
							if($userData->no_telp != '' && isset($userData->no_telp)){

								$response = $objNotifWa->kirim(Fungsi::cekPlus($userData->no_telp), $addonData['tmp'], [
									'%nama_customer%' => $userData->name,
									'%resi%' => $resi,
									'%nama_toko%' => $nama_toko,
									'%id_order%' => '#'.$request->id_order,
									'%kurir%' => $data_kurir,
								]);

								if($response['status'] === false){
									$cekError['notif_wa'] = $response['data'];
								}
	
							}

						}

					}

					if(count($cekError) < 1){
						return redirect(url()->previous())->with([
							'msg_success' => 'Berhasil mengupdate resi!',
							'id_update' => $request->id_order
						]);
					} else if(count($cekError) === 2 && $cekAktifAddon['notif_resi_email'] === true && $cekAktifAddon['notif_wa'] === true){
						return redirect(url()->previous())->with([
							'msg_error' => 'Berhasil mengupdate resi, tetapi gagal mengirim Notifikasi Email dan Notifikasi Whatsapp!',
							'id_update' => $request->id_order
						]);
					} else {
						if(isset($cekError['notif_resi_email']) && $cekAktifAddon['notif_resi_email'] === true){
							return redirect(url()->previous())->with([
								// 'msg_error' => 'Berhasil mengupdate resi, tetapi gagal mengirim notifikasi email!',
								'msg_error' => 'Berhasil mengupdate resi, tetapi gagal mengirim Notifikasi Email!',
								'id_update' => $request->id_order
							]);
						} else if(isset($cekError['notif_wa']) && $cekAktifAddon['notif_wa'] === true){
							return redirect(url()->previous())->with([
								// 'msg_error' => 'Berhasil mengupdate resi, tetapi gagal mengirim notifikasi email!',
								'msg_error' => 'Berhasil mengupdate resi, tetapi gagal mengirim Notifikasi Whatsapp!',
								'id_update' => $request->id_order
							]);
						}
					}
				}
				break;

			case "cancel_order":
				list($data_user, $ijin) = $this->getIjinUser();
				if(($ijin->cancelOrder === 1 && $data_user->role == 'Admin') || $data_user->role == 'Owner'){
					$hasil = DB::table('t_order')->where("id_order", $request->id_order)->where("data_of", Fungsi::dataOfCek())->update([
						"canceled" => 1
					]);
					$nama_order = DB::table('t_order')->where("id_order", $request->id_order)->where("data_of", Fungsi::dataOfCek())->select('urut_order')->get()->first();
					Cache::forget('data_order_lengkap_'.Fungsi::dataOfCek());
					Cache::forget('data_laporan_'.Fungsi::dataOfCek());
					Cache::forget('data_edit_order_'.$request->id_order.'_'.Fungsi::dataOfCek());
					if($hasil){
						event(new BelakangLogging(Fungsi::dataOfCek(), 'cancel_order', [
							'user_id' => Auth::user()->id,
							'urut_order' => $nama_order->urut_order
						]));
						return redirect(url()->previous())->with([
							'msg_success' => 'Berhasil mengcancel order!'
						]);
					}
				} else {
					return redirect()->route('b.order-index');
				}
				break;

			case "kembali_order":
				$hasil = DB::table('t_order')->where("id_order", $request->id_order)->where("data_of", Fungsi::dataOfCek())->update([
					"canceled" => 0
				]);
                $nama_order = DB::table('t_order')->where("id_order", $request->id_order)->where("data_of", Fungsi::dataOfCek())->select('urut_order')->get()->first();
				Cache::forget('data_order_lengkap_'.Fungsi::dataOfCek());
				Cache::forget('data_laporan_'.Fungsi::dataOfCek());
				if($hasil){
					event(new BelakangLogging(Fungsi::dataOfCek(), 'kembali_order', [
						'user_id' => Auth::user()->id,
						'urut_order' => $nama_order->urut_order
					]));
					return redirect(route('b.order-cancel'))->with([
						'msg_success' => 'Berhasil mengembalikkan order!'
					]);
				}
				break;

			case "hapus_order":
                $nama_order = DB::table('t_order')->where("id_order", $request->id_order)->where("data_of", Fungsi::dataOfCek())->select('urut_order')->get()->first();
				$hasil = DB::table('t_order')->where("id_order", $request->id_order)->where("data_of", Fungsi::dataOfCek())->delete();
				$hasil2 = DB::table('t_pembayaran')->where("order_id", $request->id_order)->where("data_of", Fungsi::dataOfCek())->delete();
				Cache::forget('data_order_lengkap_'.Fungsi::dataOfCek());
				Cache::forget('data_laporan_'.Fungsi::dataOfCek());
				Cache::forget('data_edit_order_'.$request->id_order.'_'.Fungsi::dataOfCek());
				if($hasil || $hasil2){
					event(new BelakangLogging(Fungsi::dataOfCek(), 'hapus_order', [
						'user_id' => Auth::user()->id,
						'urut_order' => $nama_order->urut_order
					]));
					return redirect(route('b.order-cancel'))->with([
						'msg_success' => 'Berhasil menghapus order!'
					]);
				}
				break;

			case "filter_save":
				$nama = strip_tags($request->nama_filter);
				$cek = DB::table("t_filter_order")->where("nama_filter", $nama)->where("data_of", Fungsi::dataOfCek())->get()->first();
				if(isset($cek)){
					return redirect(url()->previous())->with([
						'msg_error' => 'Nama filter sudah digunakan!'
					]);
				}
				$f_admin = strip_tags($request->f_admin);
				$f_bayar = strip_tags($request->f_bayar);
				$f_kirim = strip_tags($request->f_kirim);
				$f_via = strip_tags($request->f_via);
				$f_kurir = strip_tags($request->f_kurir);
				$f_print = strip_tags($request->f_print);
				$f_tglTipe = strip_tags($request->f_tglTipe);
				$orderSource_cek = DB::table('t_store')
					->where('data_of', Fungsi::dataOfCek())
					->select('s_order_source')
					->get()->first()->s_order_source;
				if($orderSource_cek == 'on' && isset($request->f_orderSource)){
					$f_orderSource = strip_tags($request->f_orderSource);
				} else {
					$f_orderSource = 0;
				}
				$f_tglDari = ($request->f_tglDari != "") ? strip_tags($request->f_tglDari) : null;
				$f_tglSampai = ($request->f_tglSampai != "") ? strip_tags($request->f_tglSampai) : null;
				$hasil = DB::table('t_filter_order')->insert([
					"nama_filter" => $nama,
					"f_admin" => $f_admin,
					"f_bayar" => $f_bayar,
					"f_kirim" => $f_kirim,
					"f_via" => $f_via,
					"f_kurir" => $f_kurir,
					"f_print" => $f_print,
					"f_tglTipe" => $f_tglTipe,
					"f_tglDari" => $f_tglDari,
					"f_tglSampai" => $f_tglSampai,
					"f_orderSource" => $f_orderSource,
					"data_of" => Fungsi::dataOfCek()
				]);
				Cache::forget('data_filter_order_lengkap_'.Fungsi::dataOfCek());
				if($hasil){
					return redirect(url()->previous())->with([
						'msg_success' => 'Berhasil menambah filter order!'
					]);
				}
				break;

			case "filter_hapus":
				try{
					$honey = base64_decode(base64_decode($request->dd));
					$id = decrypt($request->ff);
				} catch (DecryptException $e){
					return redirect(url()->previous());
				}
				if($honey != $id){
					return redirect(url()->previous());
				}
				$hasil = DB::table('t_filter_order')->where("id_filter_order", $id)->where("data_of", Fungsi::dataOfCek())->delete();
				Cache::forget('data_filter_order_lengkap_'.Fungsi::dataOfCek());
				if($hasil){
					return redirect(route("b.order-index"))->with([
						'msg_success' => 'Berhasil menghapus filter order!'
					]);
				}
				break;
			case "hapus_riwayat_bayar":
				$id = strip_tags($request->id);
				$id_order = strip_tags($request->id_order);
				$hasil = DB::table('t_pembayaran')
					->where("id_bayar", $id)
					->where("data_of", Fungsi::dataOfCek())
					->delete();
				if($hasil){
					$data['sukses'] = true;
					$t_data = DB::table('t_pembayaran')
						->where("data_of", Fungsi::dataOfCek())
						->where("order_id", $id_order)
						->get();
					$data_ = [];
					foreach(Fungsi::genArray($t_data) as $i_td => $td){
						$data_[$i_td] = $td;
						$data_[$i_td]->tgl_tampil = date('j M Y', strtotime($td->tgl_bayar));
						if($td->via == 'CASH'){
							$data_[$i_td]->bank_tampil = ' ('.$td->via.') ';
						} else {
							$bank = explode('|', $td->via);
							$no_rek = DB::table('t_bank')
								->where('data_of', Fungsi::dataOfCek())
								->where('id_bank', $bank[0])
								->select('no_rek')
								->get()->first();
							$data_[$i_td]->bank_tampil = ' ('.$bank[1].' - '.$no_rek->no_rek.') ';
						}
					}
					$data['data'] = $data_;
					return Fungsi::respon($data, [], "json", $request);
				} else {
					$data['sukses'] = false;
					$data['data'] = [];
					return Fungsi::respon($data, [], "json", $request);
				}
				Cache::forget('data_edit_order_'.$id_order.'_'.Fungsi::dataOfCek());
				break;

			default:
				return response()->json(['sukses' => false, 'msg' => 'Salah Rute!']);
				break;
		}
	}

	public function cekOngkir(Request $request){
		if($request->ajax()){
			$data = json_decode(Fungsi::cekOngkir($request->dari, $request->untuk, $request->berat, $request->v, "pro"), true)["rajaongkir"];
			// $data["jne"] = json_decode(Fungsi::cekOngkir($request->dari, $request->untuk, $request->berat, "jne"), true)["rajaongkir"];
			// $data["tiki"] = json_decode(Fungsi::cekOngkir($request->dari, $request->untuk, $request->berat, "tiki"), true)["rajaongkir"];
			// $data["pos"] = json_decode(Fungsi::cekOngkir($request->dari, $request->untuk, $request->berat, "pos"), true)["rajaongkir"];
			// echo "<pre>".print_r($data, true)."</pre>";
			// $data = $request->dari;
			// echo "<pre>".print_r($data, true)."</pre>";
			// return response()->json($data);
			// return response(gzencode(json_encode($data), 6))
			// 	->header('Content-type', 'application/json; charset=UTF-8')
			// 	->header('Content-Encoding', 'gzip');
			return Fungsi::respon($data, [], "json", $request);
		} else {
			abort(404);
		}
	}

	public function detailIndex(Request $request, $id_order = null){
		if(is_null($id_order) || preg_match("/\D/", $id_order)){
            return redirect()->route('b.order-index');
		}
		$data_order = DB::table("t_order")
			->where("id_order", $id_order)
			->where("data_of", Fungsi::dataOfCek())
			->get()->first();
		if(is_null($data_order)){
            return redirect()->route('b.order-index');
		}

		$data_bayar = DB::table("t_pembayaran")
			->where("order_id", $id_order)
			->where("data_of", Fungsi::dataOfCek())
			->get();

		$data_produk = json_decode($data_order->produk)->list;

		$data = new stdClass();
		$data->order = $data_order;
		unset($data->order->data_of);
		unset($data_order);
		$data->bayar = array();
		foreach($data_bayar as $i => $v){
			unset($v->data_of);
			array_push($data->bayar, $v);
		}
		unset($data_bayar);
		$data->produk = $data_produk;
		unset($data_produk);
		$data_tujuan = DB::table("t_customer")
			->join("users", "users.id", "=", "t_customer.user_id")
			->select("t_customer.*", "users.name", "users.no_telp", "users.email")
			->where("user_id", $data->order->tujuan_kirim_id)
			->where("data_of", Fungsi::dataOfCek())
			->get()->first();
		$data_pemesan = DB::table("t_customer")
			->join("users", "users.id", "=", "t_customer.user_id")
			->select("t_customer.kategori")
			->where("user_id", $data->order->pemesan_id)
			->where("data_of", Fungsi::dataOfCek())
			->get()->first();

		if(!isset($data_pemesan)){
			$data_pemesan = "[?Terhapus?]";
		}

		if(!isset($data_tujuan)){
			$data_tujuan = new stdclass();
			$data_tujuan->name = "[?Terhapus?]";
			$data_tujuan->alamat = "[?Terhapus?]";
			$data_tujuan->kecamatan = "[?Terhapus?]";
			$data_tujuan->kabupaten = "[?Terhapus?]";
			$data_tujuan->kode_pos = "[?Terhapus?]";
			$data_tujuan->no_telp = "[?Terhapus?]";
			$data_tujuan->email = "[?Terhapus?]";
			$data_tujuan->provinsi = "[?Terhapus?]";
		} else {
			unset($data_tujuan->data_of);
		}
		// return "<pre>".print_r($data_tujuan, true)."</pre>";
		$data->tujuan = $data_tujuan;
		unset($data_tujuan);
		$data->kategori_pemesan = $data_pemesan;
		$data->hargaList = "<tbody>";
		$total = $totalJual = $totalBeli = 0;
		$totalUntung = "";
		foreach($data->produk as $i => $v){
			$tmp = "";
			$p = $v->rawData;
			$cekID = DB::table("t_produk")->select("id_produk")->where("data_of", Fungsi::dataOfCek())->where("id_produk", $p->produk_id)->get()->first();
			if(isset($cekID)){
				$datnama_produk = ucwords(strtolower($p->nama_produk));
			} else {
				$datnama_produk = "[?Terhapus?]";
			}
			$tmp .= "<tr><td>";
			$hargaAkhir = 0;
			if($data->kategori_pemesan == "Reseller"){
				if($p->diskon_jual == ""){
					$hargaAkhir = $p->harga_jual_reseller;
					$tmp .= $datnama_produk."<br>";
					$tmp .= "<span class='text-muted'>".Fungsi::uangFormat($hargaAkhir, true)." x ".$v->jumlah."</span>";
				} else {
					$hargaAwal = $p->harga_jual_reseller;
					$tipeDiskon = explode("|", $p->diskon_jual)[1];
					$diskon = explode("|", $p->diskon_jual)[0];
					if($tipeDiskon == "%"){
						$hargaDiskon = round(((int)$diskon * (int)$hargaAwal) / 100);
						$hargaAkhir = $hargaAwal - $hargaDiskon;
						$tmp .= $datnama_produk."&nbsp;<span style='color:red'>(Diskon ".$diskon."%)</span><br>";
					} else if($tipeDikon == "*"){
						$hargaAkhir = $hargaAwal - (int)$diskon;
						$tmp .= $datnama_produk."&nbsp;<span style='color:red'>(Diskon ".Fungsi::uangFormat($diskon, true).")</span><br>";
					}
					$tmp .= "<span class='text-muted'><s>".Fungsi::uangFormat($hargaAwal, true)."</s></span>&nbsp;<span style='color:#ff8282'>".Fungsi::uangFormat($hargaAkhir, true)."</span>".
						"<span class='text-muted'> x ".$v->jumlah."</span>";
				}
			} else {
				if($p->diskon_jual == ""){
					$hargaAkhir = $p->harga_jual_normal;
					$tmp .= $datnama_produk."<br>";
					$tmp .= "<span class='text-muted'>".Fungsi::uangFormat($hargaAkhir, true)." x ".$v->jumlah."</span>";
				} else {
					$hargaAwal = $p->harga_jual_normal;
					$tipeDiskon = explode("|", $p->diskon_jual)[1];
					$diskon = explode("|", $p->diskon_jual)[0];
					if($tipeDiskon == "%"){
						$hargaDiskon = round(((int)$diskon * (int)$hargaAwal) / 100);
						$hargaAkhir = $hargaAwal - $hargaDiskon;
						$tmp .= $datnama_produk."&nbsp;<span style='color:red'>(Diskon ".$diskon."%)</span><br>";
					} else if($tipeDiskon == "*"){
						$hargaAkhir = $hargaAwal - (int)$diskon;
						$tmp .= $datnama_produk."&nbsp;<span style='color:red'>(Diskon ".Fungsi::uangFormat($diskon, true).")</span><br>";
					}
					$tmp .= "<span class='text-muted'><s>".Fungsi::uangFormat($hargaAwal, true)."</s></span>&nbsp;<span style='color:#ff8282'>".Fungsi::uangFormat($hargaAkhir, true)."</span>".
						"<span class='text-muted'> x ".$v->jumlah."</span>";
				}
			}
			$subtotal = $hargaAkhir * $v->jumlah;
			$total += (int)$subtotal;
			$totalJual += (int)$subtotal;
			$totalBeli += ((int)$p->harga_beli * (int)$v->jumlah);
			$tmp .= "</td><td class='text-right'>".Fungsi::uangFormat($subtotal, true);
			$tmp .= "</td><tr>";
			$data->hargaList .= $tmp;
		}
		$data->hargaList .= "</tbody>";
		unset($tmp);

		$kurir_harga = "<tbody><tr><td colspan='2' style='font-weight:bold;color:black'>Kurir</td></tr>";
		$kurir_data = json_decode($data->order->kurir);
		if($kurir_data->tipe == "expedisi"){
			$total += (int)explode("|", $kurir_data->data)[2];
			$kurir_harga .= "<tr><td>".strtoupper(explode("|", $kurir_data->data)[0])."</td><td class='text-right'>".Fungsi::uangFormat(explode("|", $kurir_data->data)[2], true)."</td></tr>";
		} else if($kurir_data->tipe == "kurir") {
			$total += (int)$kurir_data->data->harga;
			$kurir_harga .= "<tr><td>".$kurir_data->data->nama."</td><td class='text-right'>".Fungsi::uangFormat($kurir_data->data->harga, true)."</td></tr>";
		} else if($kurir_data->tipe == "toko") {
			$kurir_harga .= "<tr><td>Ambil Di Toko</td><td class='text-right'>Rp 0</td></tr>";
		}
		$kurir_harga .= "</tbody>";
		$data->hargaList .= $kurir_harga;
		unset($kurir_harga);
		unset($kurir_data);

		$biaya_n_diskon = json_decode($data->order->total);
		$tmp_harga = "";
		if(!is_null($biaya_n_diskon->biayaLain)){
			$tmp_harga = "<tbody><tr><td colspan='2' style='font-weight:bold;color:black'>Biaya Lain</td></tr>";
			foreach($biaya_n_diskon->biayaLain as $biayaLain){
				$tmp_harga .= "<tr><td>".$biayaLain->nama."</td><td class='text-right'>".Fungsi::uangFormat($biayaLain->harga, true)."</td></tr>";
				$total += (int)$biayaLain->harga;
				$totalJual += (int)$biayaLain->harga;
			}
			$tmp_harga .= "</tbody>";
		}
		$data->hargaList .= $tmp_harga;
		$tmp_harga = "";
		if(!is_null($biaya_n_diskon->diskonOrder)){
			$tmp_harga = "<tbody><tr><td colspan='2' style='font-weight:bold;color:black'>Diskon Order</td></tr>";
			foreach($biaya_n_diskon->diskonOrder as $diskonOrder){
				$tmp_harga .= "<tr><td>".$diskonOrder->nama."</td><td class='text-right' style='color:red'> - ".Fungsi::uangFormat($diskonOrder->harga, true)."</td></tr>";
				$total -= (int)$diskonOrder->harga;
				$totalJual -= (int)$diskonOrder->harga;
			}
			$tmp_harga .= "</tbody>";
		}
		$data->hargaList .= $tmp_harga;
		unset($tmp_harga);
		$data->hargaList .= "<tbody><tr><td style='font-weight:bold;color:black'>Total</td><td class='text-right'style='font-weight:bold;color:black'>".Fungsi::uangFormat($total, true)."</td></tr></tbody>";

		if(json_decode($data->order->pembayaran)->status == "cicil"){
			$sudahBayar = 0;
			foreach($data->bayar as $bayar){
				$sudahBayar += (int)$bayar->nominal;
			}
			$data->hargaList .= "<tbody><tr><td colspan='2'><span style='font-weight:bold;color:black'>Sisa Tagihan:</span> &nbsp;&nbsp;".Fungsi::uangFormat($total - $sudahBayar, true)."</td></tr></tbody>";
			unset($sudahBayar);
		}

		$riwayatTampil = "";
		if($data->order->cicilan_state == 1){
			$riwayatTampil .= "<span style='font-weight:bold;color:black'>Rincian Cicilan:</span><br><ul>";
			foreach($data->bayar as $riwayat){
				$bank = explode("|", $riwayat->via);
				if(count($bank) == 2){
					$cekBank = DB::table('t_bank')
						->where('data_of', Fungsi::dataOfCek())
						->where('id_bank', $bank[0])
						->get()->first();
					if(isset($cekBank)){
						$bank_tampil = $bank[1]."&nbsp;&nbsp; a/n &nbsp;&nbsp;".strtoupper(strtolower($cekBank->atas_nama));
					} else {
						$bank_tampil = "[?Terhapus?]";
					}
				} else {
					$bank_tampil = $riwayat->via;
				}
				$riwayatTampil .= "<li>".$riwayat->tgl_bayar." &nbsp;&nbsp; ".Fungsi::uangFormat($riwayat->nominal, true)." &nbsp; (".$bank_tampil.")</li>";
			}
			$riwayatTampil .= "</ul>";
		}

		unset($total);

		$totalUntung = Fungsi::uangFormat($totalJual - $totalBeli, true);
		$totalJual = Fungsi::uangFormat($totalJual, true);
		$totalBeli = Fungsi::uangFormat($totalBeli, true);
		// echo "<pre>".print_r($data, true)."</pre>";
		if($request->ajax()){
			return Fungsi::respon('belakang.order.detail', compact("data", "totalUntung", "totalJual", "totalBeli", "riwayatTampil"), "ajax", $request);
		}
		return Fungsi::respon('belakang.order.detail', compact("data", "totalUntung", "totalJual", "totalBeli", "riwayatTampil"), "html", $request);
	}

	private function genArray($data){
		foreach($data as $i => $c){
			$inject = yield $i => $c;
			if($inject === 'stop')return;
		}
	}

	public function cariIndex(Request $request){
        list($data_user, $ijin) = $this->getIjinUser();
		$bank = DB::table('t_bank')
			->select('bank', 'no_rek', 'cabang', 'atas_nama', 'id_bank')
			->where('data_of', Fungsi::dataOfCek())
			->get();
		$bank_list = "";
		foreach($this->genArray($bank) as $b){
			$bank_list .= "<a class='dropdown-item pilihViaBayar' data-idb='".$b->id_bank."' href='javascript:void(0)' role='menuitem'><span>".$b->bank."</span></a>";
		}
		$tml = <<<CUT
		<div class='row-list-order mb-40 animation-slide-left selectBug' style='animation-delay:{!delay_anim!}ms' data-id='{!id_order!}' data-urut='{!urut_order!}'>
			<div class="row row-list-order-head">
				<div class="col-sm-4 col-md-3 col-lg-3">
					<h3 class="d-inline">
						<strong>Order #{!urut_order!}</strong>
					</h3>
					<div>
						<span class="text-muted">dari</span>
						<span>{!src_order!}</span>
						<span class="text-muted">({!tanggal_order!})</span>
					</div>
				</div>
				<div class="col-sm-8 col-md-6 col-lg-6">
					{!catatan!}
				</div>
				<div class="col-xs-12 col-md-3">
					<div class="pearls pearls-sm row mt-3 {!state_order_tooltip!}">
						<div class="pearl {!state_order1!} col-3">
							<div class="pearl-icon"><i class="icon fa fa-money" aria-hidden="true"></i></div>
						</div>
						<div class="pearl {!state_order2!} col-3">
							<div class="pearl-icon"><i class="icon fa fa-cube" aria-hidden="true"></i></div>
						</div>
						<div class="pearl {!state_order3!} col-3">
							<div class="pearl-icon"><i class="icon fa fa-road" aria-hidden="true"></i></div>
						</div>
						<div class="pearl {!state_order4!} col-3">
							<div class="pearl-icon"><i class="icon fa fa-thumbs-up" aria-hidden="true"></i></div>
						</div>
					</div>
				</div>
			</div>
			<div class="row row-list-order-body">
				<textarea id='dataBayar-{!id_order!}' class='hidden'>{!data_bayar!}</textarea>
				<div class='col-md-4'>
					<div class='mb-20'>
						<div class='text-muted text-uppercase'>Pemesan</div>
						<span class='ml-10 font-size-20' id='myPop-{!index_mypop!}' style='cursor:pointer;'>{!nama_pemesan!}</span>
					</div>
					<div class='mb-20'>
						<div class='text-muted text-uppercase'>Dikirim Kepada</div>
						<span class='ml-10 font-size-20' id='myPop-{!index_mypop_2!}' style='cursor:pointer;'>{!nama_tujuan!}</span>
					</div>
					<div class='d-flex mb-20'>
						{!nama_admin!}
					</div>
				</div>
				<div class='col-md-4'>
					<div>
						<div class='text-muted text-uppercase'>Produk ({!jumlah_produk!} Item)</div>
						<ul>
							{!list_produk!}
						</ul>
					</div>
				</div>
				<div class='col-md-4'>
					<div class='mb-20'>
						<div class='text-muted text-uppercase'>Kurir</div>
						<span class='ml-10 font-size-20'>{!kurir!}</span>
					</div>
					<div>
						<div class='text-muted text-uppercase'>Total Bayar</div>
						<div class="total-bayar-info {!css_status_bayar!}" style="padding: 10px"
							data-original-title="" title="">
							<div>
								<strong class="total-bayar">{!total_bayar!}</strong>
							</div>
							<div class="d-flex flex-wrap mb--5">
								<div class="badge mr-1 mb-2 mt-1 badge-status-order {!css_btn_status_bayar!} text-uppercase"
									style='letter-spcaing:2px;cursor:default'>
									<span>{!tulisan_btn_status_bayar!}</span>
								</div>
								{!via_bayar!}
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row row-list-order-footer">
				<div class='col-md-6'>
					<label for="list-tanda">
						<input type="checkbox" class="icek" name="list-tanda" id="pilihCheck-{!urut_order!}">
					</label>
					<a href='{!url_print!}' class='btn btn-default btn-outline ml-10 {!tooltip_print!}'><i class='fa fa-print'></i>&nbsp;&nbsp;Print</a>
					{!btn_riwayat_bayar!}
				</diV>
				<div class='col-md-6 text-right'>
					{!btn_update_bayar!}
					{!btn_update_resi!}
					{!btn_tandai_terima!}
					{!btn_lacak_resi!}
					<div class="btn-group ml-5">
						{!btn_edit_order!}
						<button type="button" class="btn btn-default dropdown-toggle btn-outline"
							id="exampleSplitDropdown1" data-toggle="dropdown" aria-expanded="false">
						</button>
						<div class="dropdown-menu" aria-labelledby="exampleSplitDropdown1" role="menu"
							style="position: absolute; will-change: transform; transform: translate3d(73px, 36px, 0px); top: 0px; left: 0px;">
							<a class="dropdown-item" href="javascript:void(0);" onClick="pageLoad('{!url_detail_order!}')" role="menuitem">Detail Order</a>
							{!btn_cancel_order!}
						</div>
					</div>
				</diV>
			</div>
		</div>
CUT;
		$objData = DB::table('t_order')->where("data_of", Fungsi::dataOfCek())->where("canceled", 0);
		$query = htmlentities($request->queryCari);
		$tipeCari = htmlentities($request->tipe);
		$dataKosong = false;
		switch($tipeCari){
			case "order_id":
				$data_order = $objData->where("urut_order", $query)->orderBy("id_order", "desc")->paginate(10);
				if(count($data_order) == 0){
					$dataKosong = true;
					unset($data_order);
					break;
				}
				break;
			case "nama_cust":
				$query = str_replace('%', '\\%', $query);
				$data_cust = DB::table('users')->join("t_customer", "t_customer.user_id", "=", "users.id")->select("users.id")
					->where("name", "LIKE", "%".$query."%")->get();
				if(count($data_cust) == 0){
					$dataKosong = true;
					break;
				}
				$tempObj = [];
				foreach($this->genArray($data_cust) as $i => $c){
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
				$data_order = $tempObj[$data_cust_count-1]->orderBy("id_order", "desc")->paginate(10);
				unset($tempObj);
				break;
			case "nama_prod":
				$query = str_replace('%', '\\%', $query);
				$data_prod = DB::table('t_produk')->select("id_produk")->where("nama_produk", "LIKE", "%".$query."%")->where("data_of", Fungsi::dataOfCek())->get();
				if(count($data_prod) == 0){
					$dataKosong = true;
					break;
				}
				$tempObj = [];
				$data_ord = DB::table('t_order')->where("data_of", Fungsi::dataOfCek())->where("canceled", 0)->select("produk", "id_order")->get();
				$iT = $jumlah_iT = $jumlah_iT_kosong = 0;
				foreach($this->genArray($data_prod) as $i => $p){
					foreach($this->genArray($data_ord) as $i2 => $o){
						$tmp_ord = json_decode($o->produk)->list;
						$jumlah_iT += count($tmp_ord);
						foreach($this->genArray($tmp_ord) as $i3 => $td){
							$tmp_ = $td->rawData->produk_id;
							if($p->id_produk == $tmp_){
								if($iT == 0){
									$tempObj[$iT] = $objData->where("id_order", $o->id_order);
								} else {
									$tempObj[$iT] = $tempObj[$iT-1]->orWhere("id_order", $o->id_order);
									unset($tempObj[$iT-1]);
								}
								$iT++;
							} else {
								$jumlah_iT_kosong++;
							}
							unset($tmp_);
						}
					}
				}
				if($jumlah_iT_kosong == $jumlah_iT){
					$dataKosong = true;
					break;
				}
				unset($data_ord);
				$iT_count = $iT;
				unset($iT);
				unset($data_prod);
				$data_order = $tempObj[$iT_count-1]->orderBy("id_order", "desc")->paginate(10);
				unset($tempObj);
				break;
			case "resi":
				$data_order = $objData->where("resi", "LIKE", "%".$query."%")->orderBy("id_order", "desc")->paginate(10);
				if(count($data_order) == 0){
					$dataKosong = true;
					unset($data_order);
					break;
				}
				break;
			case "sku":
				$query = str_replace('%', '\\%', $query);
				$data_varProd = DB::table('t_varian_produk')->select("id_varian")->where("data_of", Fungsi::dataOfCek())->where("sku", "LIKE", "%".$query."%")->get();
				if(count($data_varProd) == 0){
					$dataKosong = true;
					break;
				}
				$tempObj = [];
				$data_ord = DB::table('t_order')->where("data_of", Fungsi::dataOfCek())->where("canceled", 0)->select("produk", "id_order")->get();
				$iT = $jumlah_iT = $jumlah_iT_kosong = 0;
				foreach($this->genArray($data_varProd) as $i => $p){
					foreach($this->genArray($data_ord) as $i2 => $o){
						$tmp_ord = json_decode($o->produk)->list;
						$jumlah_iT += count($tmp_ord);
						foreach($this->genArray($tmp_ord) as $i3 => $td){
							$tmp_ = $td->rawData->id_varian;
							if($p->id_varian == $tmp_){
								if($iT == 0){
									$tempObj[$iT] = $objData->where("id_order", $o->id_order);
								} else {
									$tempObj[$iT] = $tempObj[$iT-1]->orWhere("id_order", $o->id_order);
									unset($tempObj[$iT-1]);
								}
								$iT++;
							} else {
								$jumlah_iT_kosong++;
							}
							unset($tmp_);
						}
					}
				}
				if($jumlah_iT_kosong == $jumlah_iT){
					$dataKosong = true;
					break;
				}
				unset($data_ord);
				$iT_count = $iT;
				unset($iT);
				unset($data_varProd);
				$data_order = $tempObj[$iT_count-1]->orderBy("id_order", "desc")->paginate(10);
				unset($tempObj);
				break;
			case "no_telp":
				$query = str_replace('%', '\\%', $query);
				$data_cust_no = DB::table('users')->join("t_customer", "t_customer.user_id", "=", "users.id")->select("users.id")
					->where("users.no_telp", "LIKE", "%".$query."%")->where("data_of", Fungsi::dataOfCek())->get();
				if(count($data_cust_no) == 0){
					$dataKosong = true;
					break;
				}
				$tempObj = [];
				foreach($this->genArray($data_cust_no) as $i => $c){
					if($i == 0){
						$tempObj[$i] = $objData->where("pemesan_id", $c->id);
						$tempObj[$i] = $objData->orWhere("tujuan_kirim_id", $c->id);
					} else {
						$tempObj[$i] = $tempObj[$i-1]->orWhere("pemesan_id", $c->id);
						$tempObj[$i] = $tempObj[$i-1]->orWhere("tujuan_kirim_id", $c->id);
						unset($tempObj[$i-1]);
					}
				}
				$data_cust_count = count($data_cust_no);
				unset($data_cust_no);
				$data_order = $tempObj[$data_cust_count-1]->orderBy("id_order", "desc")->paginate(10);
				unset($tempObj);
				break;
			default:
				return redirect()->route('b.order-index');
				break;
		}
		if($dataKosong){
			$data_order = [];
		}
		if($query == ""){
			unset($data_order);
			$data_order = DB::table('t_order')->where("data_of", Fungsi::dataOfCek())->where("canceled", 0)->orderBy("id_order", "desc")->paginate(10);
		}
		list($order, $popover, $list_order_json_) = $this->parseDataOrder($data_order, $tml, $data_user, $ijin);
		$list_order_json = json_encode($list_order_json_);
		if($request->ajax()){
			return Fungsi::respon('belakang.order.cari', compact("order", "data_order", "query", "tipeCari", 'bank_list', 'popover', 'data_user', 'ijin', 'list_order_json'), "ajax", $request);
			// return Fungsi::parseAjax('belakang.semua_order');
		}
		return Fungsi::respon('belakang.order.cari', compact("order", "data_order", "query", "tipeCari", 'bank_list', 'popover', 'data_user', 'ijin', 'list_order_json'), "html", $request);
	}

	public function filterIndex(Request $request){
        list($data_user, $ijin) = $this->getIjinUser();
		$admin_filter = DB::table('t_user_meta')
			->join('users', 'users.id', '=', 't_user_meta.id_user_meta')
			->where('t_user_meta.data_of', Fungsi::dataOfCek())
			->where('t_user_meta.role', 'Admin')
			->select('t_user_meta.id_user_meta', 'users.name')
			->get()->toArray();
		$bank = DB::table('t_bank')
			->select('bank', 'no_rek', 'cabang', 'atas_nama', 'id_bank')
			->where('data_of', Fungsi::dataOfCek())
			->get();
		$bank_list = "";
		$bank_filter = [];
		foreach($this->genArray($bank) as $b){
			$bank_filter[] = [
				'id' => $b->id_bank,
				'bank' => $b->bank,
			];
			$bank_list .= "<a class='dropdown-item pilihViaBayar' data-idb='".$b->id_bank."' href='javascript:void(0)' role='menuitem'><span>".$b->bank."</span></a>";
		}
		$data["admin"] = strip_tags($request->f_admin);
		$data["bayar"] = strip_tags($request->f_bayar);
		$data["kirim"] = strip_tags($request->f_kirim);
		$data["via"] = strip_tags($request->f_via);
		$data["kurir"] = strip_tags($request->f_kurir); 
		$data["print"] = strip_tags($request->f_print); 
		$data["tglTipe"] = strip_tags($request->f_tglTipe);
		$data["tglDari"] = strip_tags($request->f_tglDari);
		$data["tglSampai"] = strip_tags($request->f_tglSampai);
		$data["orderSource"] = isset($request->f_orderSource) ? strip_tags($request->f_orderSource) : "0";
		$excel_tgl['xlsx'] = route('b.excel-export-order', ['format' => 'xlsx'])."?dari=".$data["tglDari"]."&sampai=".$data["tglSampai"];
		$excel_tgl['xls'] = route('b.excel-export-order', ['format' => 'xls'])."?dari=".$data["tglDari"]."&sampai=".$data["tglSampai"];
		$excel_tgl['csv'] = route('b.excel-export-order', ['format' => 'csv'])."?dari=".$data["tglDari"]."&sampai=".$data["tglSampai"];
		$order_temp = $array_id = [];
		$order_temp["raw"] = DB::table('t_order')->where("data_of", Fungsi::dataOfCek())->where("canceled", 0)->get();
		$order_temp["1_admin"] = $order_temp["2_bayar"] = $order_temp["3_kirim"] = $order_temp["4_via"] = $order_temp["5_kurir"] = $order_temp["6_tgl"] = $order_temp["0_order_source"] = $order_temp["7_print"] = [];

		//cek order source
		$cekOrderSource = DB::table('t_store')
			->where('data_of', Fungsi::dataOfCek())
			->select('s_order_source')
			->get()->first()->s_order_source;
		// if($cekOrderSource == 'on'){
			foreach($this->genArray($order_temp["raw"]) as $iO => $vO){
				if($data["orderSource"] != "0"){
					if($vO->order_source_id == $data["orderSource"]) {
						$order_temp["0_order_source"][] = $vO;
					} 
				} else {
					$order_temp["0_order_source"][] = $vO;
				}
			}
			unset($order_temp["raw"]);
		// }

		//cek admin
		foreach($this->genArray($order_temp["0_order_source"]) as $iO => $vO){
			if($data["admin"] != "0"){
				if(is_numeric($data["admin"])){
					if($vO->admin_id == $data["admin"]) $order_temp["1_admin"][] = $vO;
				} else {
					if($vO->admin_id == 0 && $vO->src == 'store_front') $order_temp["1_admin"][] = $vO;
				}
			} else {
				$order_temp["1_admin"][] = $vO;
			}
		}
		unset($order_temp["0_order_source"]);

		//cek bayar
		foreach($this->genArray($order_temp["1_admin"]) as $iC => $vC){
			if($data["bayar"] != "0"){
				switch($data["bayar"]){
					case "belum":
						$bayar_tmp = json_decode($vC->pembayaran)->status;
						if($bayar_tmp == "belum"){
							$order_temp["2_bayar"][] = $vC;
						}
						break;

					case "cicil":
						$bayar_tmp = json_decode($vC->pembayaran)->status;
						if($bayar_tmp == "cicil"){
							$order_temp["2_bayar"][] = $vC;
						}
						break;

					case "lunas":
						$bayar_tmp = json_decode($vC->pembayaran)->status;
						if($bayar_tmp == "lunas"){
							$order_temp["2_bayar"][] = $vC;
						}
						break;
				}
			} else {
				$order_temp["2_bayar"][] = $vC;
			}
		}
		unset($order_temp["1_admin"]);

		// cek kirim
		foreach($this->genArray($order_temp["2_bayar"]) as $iB => $vB){
			if($data["kirim"] != "0"){
				switch($data["kirim"]){
					case "belum_proses":
						if($vB->state == "bayar"){
							$order_temp["3_kirim"][] = $vB;
						}
						break;

					case "belum_resi":
						if($vB->state == "proses"){
							$order_temp["3_kirim"][] = $vB;
						}
						break;

					case "dalam_kirim":
						if($vB->state == "kirim"){
							$order_temp["3_kirim"][] = $vB;
						}
						break;

					case "sudah_tujuan":
						if($vB->state == "terima"){
							$order_temp["3_kirim"][] = $vB;
						}
						break;
				}
			} else {
				$order_temp["3_kirim"][] = $vB;
			}
		}
		unset($order_temp["2_bayar"]);

		// cek via
		foreach($this->genArray($order_temp["3_kirim"]) as $iK => $vK){
			if($data["via"] != "0"){
				if(is_numeric($data["via"])){
					$tmp_data = DB::table("t_pembayaran")->select("via")->where("order_id", $vK->id_order)->get();
					if(count($tmp_data) > 0){
						$genTmp = $this->genArray($tmp_data);
						foreach($genTmp as $iTmp => $vTmp){
							if($data["via"] == explode('|', $vTmp->via)[0]){
								$order_temp["4_via"][] = $vK;
								$genTmp->send('stop');
							}
						}
					}
				} else if($data["via"] == "cash"){
					$tmp_data = DB::table("t_pembayaran")->select("via")->where("order_id", $vK->id_order)->get();
					if(count($tmp_data) > 0){
						$genTmp = $this->genArray($tmp_data);
						foreach($genTmp as $iTmp => $vTmp){
							if($vTmp->via == "CASH"){
								$order_temp["4_via"][] = $vK;
								$genTmp->send('stop');
							}
						}
					}
				}
			} else {
				$order_temp["4_via"][] = $vK;
			}
		}
		unset($order_temp["3_kirim"]);

		// cek kurir
		foreach($this->genArray($order_temp["4_via"]) as $iV => $vV){
			if($data["kurir"] != "0"){
				if($data["kurir"] == "input"){
					$tmp_kurir = json_decode($vV->kurir)->tipe;
					if($tmp_kurir == "kurir"){
						$order_temp["5_kurir"][] = $vV;
					}
				} else if($data["kurir"] == "toko"){
					$tmp_kurir = json_decode($vV->kurir)->tipe;
					if($tmp_kurir == "toko"){
						$order_temp["5_kurir"][] = $vV;
					}
				} else {
					$tmp_kurir = json_decode($vV->kurir);
					if($tmp_kurir->tipe == "expedisi"){
						if($data["kurir"] == explode("|", $tmp_kurir->data)[0]){
							$order_temp["5_kurir"][] = $vV;
						}
					}
				}
			} else {
				$order_temp["5_kurir"][] = $vV;
			}
		}
		unset($order_temp["4_via"]);

		// cek tgl
		foreach($this->genArray($order_temp["5_kurir"]) as $iU => $vU){
			if($data["tglDari"] != "" || $data["tglSampai"] != ""){
				if($data["tglTipe"] == "bayar"){
					$tmp_data = DB::table("t_pembayaran")->select("tgl_bayar")->where("order_id", $vU->id_order)->get();
					if(count($tmp_data) > 0){
						if($data["tglDari"] != "" && $data["tglSampai"] != ""){
							foreach($this->genArray($tmp_data) as $iTmp => $vTmp){
								$t_tglDari = strtotime($data["tglDari"]);
								$t_tglSampai = strtotime($data["tglSampai"]);
								$t_tglBuat = strtotime($vTmp->tgl_bayar);
								if($t_tglBuat >= $t_tglDari && $t_tglBuat <= $t_tglSampai){
									$order_temp["6_tgl"][] = $vU;
									break;
								}
							}
						} else if($data["tglDari"] != "" && $data["tglSampai"] == ""){
							foreach($this->genArray($tmp_data) as $iTmp => $vTmp){
								$t_tglDari = strtotime($data["tglDari"]);
								$t_tglBuat = strtotime($vTmp->tgl_bayar);
								if($t_tglBuat >= $t_tglDari){
									$order_temp["6_tgl"][] = $vU;
									break;
								}
							}
						} else if($data["tglDari"] == "" && $data["tglSampai"] != ""){
							foreach($this->genArray($tmp_data) as $iTmp => $vTmp){
								$t_tglSampai = strtotime($data["tglSampai"]);
								$t_tglBuat = strtotime($vTmp->tgl_bayar);
								if($t_tglBuat <= $t_tglSampai){
									$order_temp["6_tgl"][] = $vU;
									break;
								}
							}
						}
					}
				} else if($data["tglTipe"] == "order"){
					if($data["tglDari"] != "" && $data["tglSampai"] != ""){
						$t_tglDari = strtotime($data["tglDari"]);
						$t_tglSampai = strtotime($data["tglSampai"]);
						$t_tglOrder = strtotime($vU->tanggal_order);
						if($t_tglOrder >= $t_tglDari && $t_tglOrder <= $t_tglSampai){
							$order_temp["6_tgl"][] = $vU;
						}
					} else if($data["tglDari"] != "" && $data["tglSampai"] == ""){
						$t_tglDari = strtotime($data["tglDari"]);
						$t_tglOrder = strtotime($vU->tanggal_order);
						if($t_tglOrder >= $t_tglDari){
							$order_temp["6_tgl"][] = $vU;
						}
					} else if($data["tglDari"] == "" && $data["tglSampai"] != ""){
						$t_tglSampai = strtotime($data["tglSampai"]);
						$t_tglOrder = strtotime($vU->tanggal_order);
						if($t_tglOrder <= $t_tglSampai){
							$order_temp["6_tgl"][] = $vU;
						}
					}
				}
			} else {
				$order_temp["6_tgl"][] = $vU;
			}
		}
		unset($order_temp["5_kurir"]);

		// cek print
		foreach($this->genArray($order_temp["6_tgl"]) as $iPR => $vPR){
			if($data["tglDari"] != "0"){
				if($data['print'] == 'print'){
					if($vPR->print_label){
						$order_temp["7_print"][] = $vPR;
					}
				} else if($data['print'] == 'belum_print'){
					if(!$vPR->print_label){
						$order_temp["7_print"][] = $vPR;
					}
				} else {
					$order_temp["7_print"][] = $vPR;
				}
			}
		}
		unset($order_temp["6_tgl"]);


		$tml = <<<CUT
		<div class='row-list-order mb-40 animation-slide-left selectBug' style='animation-delay:{!delay_anim!}ms' data-id='{!id_order!}' data-urut='{!urut_order!}'>
			<div class="row row-list-order-head">
				<div class="col-sm-4 col-md-3 col-lg-3">
					<h3 class="d-inline">
						<strong>Order #{!urut_order!}</strong>
					</h3>
					<div>
						<span class="text-muted">dari</span>
						<span>{!src_order!}</span>
						<span class="text-muted">({!tanggal_order!})</span>
					</div>
				</div>
				<div class="col-sm-8 col-md-6 col-lg-6">
					{!catatan!}
				</div>
				<div class="col-xs-12 col-md-3">
					<div class="pearls pearls-sm row mt-3 {!state_order_tooltip!}">
						<div class="pearl {!state_order1!} col-3">
							<div class="pearl-icon"><i class="icon fa fa-money" aria-hidden="true"></i></div>
						</div>
						<div class="pearl {!state_order2!} col-3">
							<div class="pearl-icon"><i class="icon fa fa-cube" aria-hidden="true"></i></div>
						</div>
						<div class="pearl {!state_order3!} col-3">
							<div class="pearl-icon"><i class="icon fa fa-road" aria-hidden="true"></i></div>
						</div>
						<div class="pearl {!state_order4!} col-3">
							<div class="pearl-icon"><i class="icon fa fa-thumbs-up" aria-hidden="true"></i></div>
						</div>
					</div>
				</div>
			</div>
			<div class="row row-list-order-body">
				<textarea id='dataBayar-{!id_order!}' class='hidden'>{!data_bayar!}</textarea>
				<div class='col-md-4'>
					<div class='mb-20'>
						<div class='text-muted text-uppercase'>Pemesan</div>
						<span class='ml-10 font-size-20' id='myPop-{!index_mypop!}' style='cursor:pointer;'>{!nama_pemesan!}</span>
					</div>
					<div class='mb-20'>
						<div class='text-muted text-uppercase'>Dikirim Kepada</div>
						<span class='ml-10 font-size-20' id='myPop-{!index_mypop_2!}' style='cursor:pointer;'>{!nama_tujuan!}</span>
					</div>
					<div class='d-flex mb-20'>
						{!nama_admin!}
					</div>
				</div>
				<div class='col-md-4'>
					<div>
						<div class='text-muted text-uppercase'>Produk ({!jumlah_produk!} Item)</div>
						<ul>
							{!list_produk!}
						</ul>
					</div>
				</div>
				<div class='col-md-4'>
					<div class='mb-20'>
						<div class='text-muted text-uppercase'>Kurir</div>
						<span class='ml-10 font-size-20'>{!kurir!}</span>
					</div>
					<div>
						<div class='text-muted text-uppercase'>Total Bayar</div>
						<div class="total-bayar-info {!css_status_bayar!}" style="padding: 10px"
							data-original-title="" title="">
							<div>
								<strong class="total-bayar">{!total_bayar!}</strong>
							</div>
							<div class="d-flex flex-wrap mb--5">
								<div class="badge mr-1 mb-2 mt-1 badge-status-order {!css_btn_status_bayar!} text-uppercase"
									style='letter-spcaing:2px;cursor:default'>
									<span>{!tulisan_btn_status_bayar!}</span>
								</div>
								{!via_bayar!}
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row row-list-order-footer">
				<div class='col-md-6'>
					<label for="list-tanda">
						<input type="checkbox" class="icek" name="list-tanda" id="pilihCheck-{!urut_order!}">
					</label>
					<a href='{!url_print!}' class='btn btn-default btn-outline ml-10 {!tooltip_print!}'><i class='fa fa-print'></i>&nbsp;&nbsp;Print</a>
					{!btn_riwayat_bayar!}
				</diV>
				<div class='col-md-6 text-right'>
					{!btn_update_bayar!}
					{!btn_update_resi!}
					{!btn_tandai_terima!}
					{!btn_lacak_resi!}
					<div class="btn-group ml-5">
						{!btn_edit_order!}
						<button type="button" class="btn btn-default dropdown-toggle btn-outline"
							id="exampleSplitDropdown1" data-toggle="dropdown" aria-expanded="false">
						</button>
						<div class="dropdown-menu" aria-labelledby="exampleSplitDropdown1" role="menu"
							style="position: absolute; will-change: transform; transform: translate3d(73px, 36px, 0px); top: 0px; left: 0px;">
							<a class="dropdown-item" href="javascript:void(0);" onClick="pageLoad('{!url_detail_order!}')" role="menuitem">Detail Order</a>
							{!btn_cancel_order!}
						</div>
					</div>
				</diV>
			</div>
		</div>
CUT;
		
		$array_id = [];
		foreach($order_temp["7_print"] as $tt){
			$array_id[] = $tt->id_order;
		}
		unset($order_temp);
		if(count($array_id) > 0){
			$data_order = DB::table('t_order')->where("data_of", Fungsi::dataOfCek())->where("canceled", 0);
			foreach($array_id as $ai1 => $ai2){
				if($ai1 == 0){
					$data_order->where("id_order", $ai2);
				} else {
					$data_order->orWhere("id_order", $ai2);
				}
			}
			$data_order = $data_order->orderBy("id_order", "desc")->paginate(10);
		} else {
			$data_order = [];
		}
		list($order, $popover, $list_order_json_) = $this->parseDataOrder($data_order, $tml, $data_user, $ijin);
		$list_order_json = json_encode($list_order_json_);
		$btnFilterCSS = [];
		$btnFilterCSS_id = null;
		$btnFilterCSS["f_semua"] = "filterBtnDefault";
		$btnFilterCSS["f_belum_bayar"] = "filterBtnDefault";
		$btnFilterCSS["f_belum_lunas"] = "filterBtnDefault";
		$btnFilterCSS["f_belum_proses"] = "filterBtnDefault";
		$btnFilterCSS["f_belum_resi"] = "filterBtnDefault";
		$btnFilterCSS["f_dalam_proses"] = "filterBtnDefault";
		$btnFilterCSS["f_kirim_berhasil"] = "filterBtnDefault";
		$btnFilterCSS["custom"] = "filterBtnDefault";
		if(isset($request->f_id)){
			switch($request->f_id){
				case "f_semua":
					$btnFilterCSS["f_semua"] = "btn-primary";
					break;

				case "f_belum_bayar":
					$btnFilterCSS["f_belum_bayar"] = "btn-primary";
					break;

				case "f_belum_lunas":
					$btnFilterCSS["f_belum_lunas"] = "btn-primary";
					break;

				case "f_belum_proses":
					$btnFilterCSS["f_belum_proses"] = "btn-primary";
					break;

				case "f_belum_resi":
					$btnFilterCSS["f_belum_resi"] = "btn-primary";
					break;

				case "f_dalam_proses":
					$btnFilterCSS["f_dalam_proses"] = "btn-primary";
					break;

				case "f_kirim_berhasil":
					$btnFilterCSS["f_kirim_berhasil"] = "btn-primary";
					break;

				default:
					$btnFilterCSS["custom"] = "btn-primary";
					$btnFilterCSS_id = $request->f_id;
					break;
			}
			
		}
		$filter_order = Cache::remember('data_filter_order_lengkap_'.Fungsi::dataOfCek(), 10000, function(){
			return DB::table('t_filter_order')->where('data_of', Fungsi::dataOfCek())->get();
		});
		$data_filter = "";
		foreach($this->genArray($filter_order) as $iF => $vF){
			if($btnFilterCSS_id == $vF->id_filter_order){
				$css_ = $btnFilterCSS["custom"];
			} else {
				$css_ = "filterBtnDefault";
			}
			$data = [];
			$data["f_admin"] = $vF->f_admin;
			$data["f_bayar"] = $vF->f_bayar;
			$data["f_kirim"] = $vF->f_kirim;
			$data["f_via"] = $vF->f_via;
			$data["f_kurir"] = $vF->f_kurir;
			$data["f_print"] = $vF->f_print;
			$data["f_tglTipe"] = $vF->f_tglTipe;
			$data["f_tglDari"] = $vF->f_tglDari;
			$data["f_tglSampai"] = $vF->f_tglSampai;
			$data["f_orderSource"] = $vF->f_orderSource;
			$data_filter .= '<li class="p-5 animation-slide-top" style="animation-delay:'.($iF+8).'00ms;">'.
            	'<a class="btn btn-round p-15 btnFilterClick '.$css_.'" data-id="'.$vF->id_filter_order.'" href="javascript:void(0)">'.
                	'<i class="icon wb-search" aria-hidden="true"></i>'.$vF->nama_filter.
            	'</a>'.
				'<textarea class="hidden">'.json_encode($data).'</textarea>'.
			'</li>';
			unset($data);
		}
		$cekIdFilter = [];
		if(is_numeric($request->f_id)){
			$cekIdFilter["cek"] = true;
		} else {
			$cekIdFilter["cek"] = false;
		}
		$cekIdFilter["id"] = encrypt($request->f_id);
		$cekIdFilter["honey"] = base64_encode(base64_encode($request->f_id));
		$order_source['cek'] = DB::table('t_store')
			->where('data_of', Fungsi::dataOfCek())
			->select('s_order_source')
			->get()->first()->s_order_source;
		$order_source['data'] = DB::table('t_order_source')
			->where('data_of', Fungsi::dataOfCek())
			->where('status', 1)
			->get();
		if($request->ajax()){
			return Fungsi::respon('belakang.order.filter', compact('admin_filter', "excel_tgl", 'list_order_json', "order", "data_order", "btnFilterCSS", "data_filter", "cekIdFilter", 'bank_list', 'popover', 'order_source', 'data_user', 'ijin', 'bank_filter'), "ajax", $request);
			// return Fungsi::parseAjax('belakang.semua_order');
		}
		return Fungsi::respon('belakang.order.filter', compact('admin_filter', "excel_tgl", 'list_order_json', "order", "data_order", "btnFilterCSS", "data_filter", "cekIdFilter", 'bank_list', 'popover', 'order_source', 'data_user', 'ijin', 'bank_filter'), "html", $request);
	}

	public function LacakResiIndex(Request $request, $id_order = null){
		if(is_null($id_order) || preg_match("/\D/", $id_order)){
            return redirect()->route('b.order-index');
		}
		$cekKirim = false;
		$id = strip_tags($id_order);
		$data_order = DB::table("t_order")->select("kurir", "resi", "state")->where("data_of", Fungsi::dataOfCek())->where("id_order", $id)->get()->first();
		if(isset($data_order)){
			$data_kurir = json_decode($data_order->kurir);
			if(!is_null($data_order->resi) && $data_kurir->tipe == "expedisi"){
				$resi = $data_order->resi;
				$kurir = explode("|", $data_kurir->data)[0];
				if($data_order->state != "terima" && $data_order->state == "kirim"){
					$cekKirim = true;
				} else {
					return redirect()->route("b.order-index");
				}
			} else {
				return redirect()->route("b.order-index");
			}
		} else {
			return redirect()->route("b.order-index");
		}
		unset($data_order);
		if($cekKirim){
			$hasilCekResi = json_decode(Fungsi::trackResi($resi, $kurir))->rajaongkir;
			if($hasilCekResi->status->code == 200){
				$data = $hasilCekResi->result;
				if(strtolower($data->delivery_status->status) == strtolower("DELIVERED")){
					$updateed = DB::table("t_order")->where("data_of", Fungsi::dataOfCek())->where("id_order", $id)->update([
						"state" => "terima"
					]);
					$data_order = DB::table('t_order')->where("id_order", $id)->where("data_of", Fungsi::dataOfCek())->get()->first();
					if(isset($data_order)){
						$produk = json_decode($data_order->produk);
						foreach(Fungsi::genArray($produk->list) as $p){
							$varian_ = $p->rawData;
							$cekVarian = DB::table('t_varian_produk')->where("id_varian", $varian_->id_varian)->where("data_of", Fungsi::dataOfCek())->get()->first();
							if(isset($cekVarian)){
								$t_stok = explode('|', $cekVarian->stok);
								if((int)$t_stok[0] > 0 && $t_stok[1] == 'sendiri'){
									$t_stok_ = (int)$t_stok[0];
									$t_stok_ -= (int)$p->jumlah;
									$t_stok[0] = $t_stok_;
									$stokUbah = implode('|', $t_stok);
									$ubahStokVarian = DB::table('t_varian_produk')
										->where("id_varian", $varian_->id_varian)
										->where("data_of", Fungsi::dataOfCek())
										->update([
											'stok' => $stokUbah
										]);
									$riwayatStok_varian = DB::table('t_riwayat_stok')->insert([
										"varian_id" => $varian_->id_varian,
										"tgl" => date("Y-m-d H:i:s"),
										"ket" => "Order #".$data_order->urut_order,
										"jumlah" => $p->jumlah,
										"tipe" => "keluar",
										"data_of" => Fungsi::dataOfCek()
									]);
								}
							}
						}
					}
					return redirect(route("b.order-index"))->with([
						'msg_success' => 'Berhasil melacak resi, barang sudah diterima customer!',
						'id_update' => $id
					]);
				} else {
					return Fungsi::respon('belakang.order.track-resi', compact("data"), "html", $request);
				}
			} else {
				return redirect(route('b.order-index'))->with([
					'msg_error' => $hasilCekResi->status->description
				]);
			}
		}
	}

	public function TrackResiIndex(Request $request){
		if($request->has("resi") && $request->has("kurir")){
			$resi = strip_tags($request->resi);
			$kurir = strip_tags($request->kurir);
		} else {
			$id = strip_tags($request->ff);
			$data_order = DB::table("t_order")->select("kurir", "resi")->where("data_of", Fungsi::dataOfCek())->where("id_order", $id)->get()->first();
			if(isset($data_order)){
				$data_kurir = json_decode($data_order->kurir);
				if(!is_null($data_order->resi) && $data_kurir->tipe == "expedisi"){
					$resi = $data_order->resi;
					$kurir = explode("|", $data_kurir->data)[0];
				} else {
					return redirect()->route("b.order-index");
				}
			} else {
				return redirect()->route("b.order-index");
			}
			unset($data_order);
		}
		$hasilCekResi = json_decode(Fungsi::trackResi($resi, $kurir))->rajaongkir;
		if($hasilCekResi->status->code == 200){
			$data = $hasilCekResi->result;
			if($kurir == "pos"){
				$hasil_manifest = [];
				foreach(Fungsi::genArray($hasilCekResi->result->manifest) as $index => $t_data){
					$waktu = strtotime($t_data->manifest_date." ".$t_data->manifest_time);
					$hasil_manifest[$index] = $t_data;
					$hasil_manifest[$index]->timestamp = $waktu;
				}
				usort($hasil_manifest, function($a, $b){
					if($a->timestamp === $b->timestamp) {
						return 0;
					}
					return ($a->timestamp > $b->timestamp) ? 1 : -1;					
				});
				$data->manifest = $hasil_manifest;
			}
			if($request->ajax()){
				return Fungsi::respon('belakang.order.track-resi', compact("data"), "ajax", $request);
				// return Fungsi::parseAjax('belakang.semua_order');
			}
			return Fungsi::respon('belakang.order.track-resi', compact("data"), "html", $request);
		} else {
			return redirect(route('b.order-index'))->with([
				'msg_error' => $hasilCekResi->status->description
			]);
		}
	}

	private function getDataEditOrder(&$id_order){
		$wilayah_lengkap = json_decode(Fungsi::getContent('data/wilayah-lengkap.json'));
		$cekOngkir = [];

		$hasil['order'] = DB::table('t_order')
			->where('data_of', Fungsi::dataOfCek())
			->where('id_order', $id_order)
			->get()->first();

		$c = DB::table('t_customer')
			->join('users', 'users.id', '=', 't_customer.user_id')
			->select('users.name', 't_customer.*')
			->where('t_customer.data_of', Fungsi::dataOfCek())
			->where('users.id', $hasil['order']->pemesan_id)
			->get()->first();
		$hasil['pemesan'] = json_encode([
			'label' => "{$c->name}|{$c->alamat}|{$c->kecamatan}|{$c->kabupaten}|{$c->provinsi}|{$c->kode_pos}|{$c->kategori}", 
			'value' => $c->user_id
		]);
		unset($c);

		$c = DB::table('t_customer')
			->join('users', 'users.id', '=', 't_customer.user_id')
			->select('users.name', 't_customer.*')
			->where('t_customer.data_of', Fungsi::dataOfCek())
			->where('users.id', $hasil['order']->tujuan_kirim_id)
			->get()->first();
		$hasil['untuk_kirim'] = [
			'label' => "{$c->name}|{$c->alamat}|{$c->kecamatan}|{$c->kabupaten}|{$c->provinsi}|{$c->kode_pos}|{$c->kategori}", 
			'value' => $c->user_id
		];
		$genKecamatan = Fungsi::genArray($wilayah_lengkap);
		foreach($genKecamatan as $w){
			if(preg_match("/".strTolower($c->kecamatan)."/", strtolower($w->kecamatan->nama))){
				$cekOngkir['tujuan'] = $w->kecamatan->id;
				$hasil['untuk_kirim']['alamat'] = $w->provinsi->id."|".$w->kota->id."|".$w->kecamatan->id;
				$genKecamatan->send('stop');
			}
		}
		$hasil['untuk_kirim'] = json_encode($hasil['untuk_kirim']);

		
		$genKecamatan2 = Fungsi::genArray($wilayah_lengkap);
		$kecamatan_c = explode(',', explode('|', $hasil['order']->kecamatan_asal_kirim_id)[3])[0];
		foreach($genKecamatan2 as $w){
			if(preg_match("/".strTolower($kecamatan_c)."/", strtolower($w->kecamatan->nama))){
				$cekOngkir['asal'] = $w->kecamatan->id;
				$hasil['dari_kirim'] = json_encode([
					'value' => $w->provinsi->id."|".$w->kota->id."|".$w->kecamatan->id,
					'label' => $w->kecamatan->nama.", ".$w->kota->nama.", ".$w->provinsi->nama
				]);
				$genKecamatan2->send('stop');
			}
		}

		$cekOngkir['berat'] = 0;
		$list_produk = json_decode($hasil['order']->produk);
		foreach(Fungsi::genArray($list_produk->list) as $i_ => $p_){
			$hasil['produk'][] = $p_;
			$cekOngkir['berat'] += $hasil['produk'][$i_]->rawData->berat;
			$cekProd = DB::table('t_varian_produk')
				->join('t_produk', 't_produk.id_produk', '=', 't_varian_produk.produk_id')
				->select('t_varian_produk.id_varian')
				->where('t_varian_produk.data_of', Fungsi::dataOfCek())
				->where('t_varian_produk.id_varian', $p_->rawData->id_varian)
				->get()
				->first();
			if(isset($cekProd)){
				$hasil['produk'][$i_]->data_lama = true;
			} else {
				$hasil['produk'][$i_]->data_lama = false;
			}
			if(isset($hasil['produk'][$i_]->rawData->foto_id)){
				$hasil['produk'][$i_]->rawData->foto_id = json_decode($hasil['produk'][$i_]->rawData->foto_id);
			}
		}
		$hasil['produk'] = json_encode($hasil['produk']);

		$hasilCekOngkir = Cache::remember('data_cekOngkir_order_'.$hasil['order']->id_order.'_'.Fungsi::dataOfCek(), 30000, function() use($cekOngkir){
			$data_store = DB::table('t_store')
				->where('data_of', Fungsi::dataOfCek())
				->select('cek_ongkir', 'kat_customer')
				->get()->first();
			$list_kurir = [];
			foreach(Fungsi::genArray(json_decode($data_store->cek_ongkir)) as $iO => $vO){
				if($vO){
					$list_kurir[] = $iO;
				}
			}
			unset($data_store);
			$hasilCekOngkir = [];
			foreach(Fungsi::genArray($list_kurir) as $iK => $vK){
				$t_asal = preg_replace('/[^0-9a-zA_Z]/', '', $cekOngkir['asal']);
				$t_tujuan = preg_replace('/[^0-9a-zA_Z]/', '', $cekOngkir['tujuan']);
				$t_berat = (string)$cekOngkir['berat'];
				$term = $t_asal.'_'.$t_tujuan.'_'.$t_berat.'_'.$vK;
				$data_ongkir = json_decode(Fungsi::cekOngkir($cekOngkir['asal'], $cekOngkir['tujuan'], $cekOngkir['berat'], $vK, "pro"), true)["rajaongkir"];
				$hasilCekOngkir[$vK] = $data_ongkir;
				$hasilCekOngkir[$vK]['term'] = $term;
			}
			return $hasilCekOngkir;
		});
		$hasil['ongkir'] = json_encode($hasilCekOngkir);


		$hasil['bayar']['status'] = json_decode($hasil['order']->pembayaran)->status;
		$hasil['bayar']['data'] = [];
		$v_a = 0;
		$data_bayar = DB::table('t_pembayaran')
			->where('data_of', Fungsi::dataOfCek())
			->where('order_id', $hasil['order']->id_order)
			->get();
		foreach(Fungsi::genArray($data_bayar) as $dB){
			$hasil['bayar']['data'][] = $dB;
			$v_a++;
		}
		$hasil['bayar']['count'] = $v_a;
		unset($v_a);
		$hasil['bayar'] = json_encode($hasil['bayar']);
		// dd($hasil);
		return $hasil;
	}

	public function editIndex(Request $request, $id_order = null){
        list($data_user, $ijin) = $this->getIjinUser();
		if(($ijin->editOrder === 1 && $data_user->role == 'Admin') || $data_user->role == 'Owner'){
			if(is_null($id_order) || preg_match("/\D/", $id_order)){
				return redirect()->route('b.order-index');
			}
			$cekOrder = DB::table('t_order')
				->select('id_order')
				->where('data_of', Fungsi::dataOfCek())
				->where('id_order', $id_order)
				->get()->first();
			if(is_null($cekOrder)){
				return redirect()->route('b.order-index');
			}
			$wilayah_indonesia = Fungsi::getContent('data/wilayah_indonesia.json');
			$bank = DB::table('t_bank')
				->select('bank', 'no_rek', 'cabang', 'atas_nama', 'id_bank')
				->where('data_of', Fungsi::dataOfCek())
				->get();
			$bank_list = "";
			foreach(Fungsi::genArray($bank) as $b){
				$bank_list .= "<a class='dropdown-item pilihViaBayar' data-idb='".$b->id_bank."' href='javascript:void(0)' role='menuitem'><span>".$b->bank."</span></a>";
			}
			unset($bank);
			$pass = Fungsi::acakPass();
			$data_store = DB::table('t_store')
				->where('data_of', Fungsi::dataOfCek())
				->select('cek_ongkir', 'kat_customer')
				->get()->first();
			$cekOngkir = [];
			foreach(Fungsi::genArray(json_decode($data_store->cek_ongkir)) as $iO => $vO){
				if($vO){
					array_push($cekOngkir, $iO);
				}
			}
			$cekOngkir = json_encode($cekOngkir);
			$kat_customer = $data_store->kat_customer;
			unset($data_store);
			$order_source['cek'] = DB::table('t_store')
				->where('data_of', Fungsi::dataOfCek())
				->select('s_order_source')
				->get()->first()->s_order_source;
			$order_source['data'] = DB::table('t_order_source')
				->where('data_of', Fungsi::dataOfCek())
				->where('status', 1)
				->get();
			
			$objThis = $this;
			$data_edit = Cache::remember('data_edit_order_'.$id_order.'_'.Fungsi::dataOfCek(), 30000, function() use($objThis, $id_order){
				return $this->getDataEditOrder($id_order);
			});
			// dd($data_edit);
			if($request->ajax()){
				return Fungsi::respon('belakang.order.edit', compact('pass', 'wilayah_indonesia', 'bank_list', 'cekOngkir', 'kat_customer', 'order_source', 'data_edit'), "ajax", $request);
			}
			return Fungsi::respon('belakang.order.edit', compact('pass', 'wilayah_indonesia', 'bank_list', 'cekOngkir', 'kat_customer', 'order_source', 'data_edit'), "html", $request);
		} else {
			return redirect()->route('b.order-index');
		}
	}

	public function editOrder(Request $request){
		// echo "<pre>".print_r($request->all(), true)."</pre>";
		// return "<pre>".print_r(json_decode($request->dataRaw, true), true)."</pre>";
        list($data_user, $ijin) = $this->getIjinUser();
		if(($ijin->editOrder === 1 && $data_user->role == 'Admin') || $data_user->role == 'Owner'){

			$data = json_decode($request->dataRaw);
	
			$data_lama = DB::table('t_order')
				->where('data_of', Fungsi::dataOfCek())
				->where('id_order', $data->id_order)
				->select('pembayaran', 'urut_order', 'total')
				->get()->first();
	
			$data_bayar_lama = DB::table('t_pembayaran')
				->where('data_of', Fungsi::dataOfCek())
				->where('order_id', $data->id_order)
				->get();
	
			$cekStatus_lama = json_decode($data_lama->pembayaran);
	
			$catatan["print"] = $data->catatanPrint;
			$catatan["data"] = $data->catatan;
			$data_update = [
				'pemesan_id' => $data->idPemesan_customer,
				'pemesan_kategori' => $data->pemesan_kat,
				'tujuan_kirim_id' => $data->idUntukKirim_customer,
				'kecamatan_asal_kirim_id' => $data->idDariKirim_kecamatan,
				'tanggal_order' => $data->tanggalOrder,
				'produk' => json_encode($data->produk),
				'kurir' => json_encode($data->kurir),
				'total' => json_encode($data->total),
				'catatan' => json_encode($catatan),
				'cicilan_state' => ($data->pembayaran->status == "cicil") ? 1 : 0,
				'order_source_id' => ($data->order_source == "") ? null : $data->order_source,
				'kat_customer' => $data->kat_customer,
				'resi' => isset($data->resi) ? $data->resi : null,
				'tgl_diedit' => date("Y-m-d")
			];
	
			if($data->pembayaran->status != $cekStatus_lama->status){
	
				if($data->pembayaran->status == 'lunas'){
					if($cekStatus_lama->status == 'belum'){
		
						$proses_ = DB::table('t_pembayaran')->insert([
							'tgl_bayar' => $data->pembayaran->tanggalBayar,
							'nominal' => (int)$data->pembayaran->nominal,
							'via' => $data->pembayaran->via,
							'order_id' => $data->id_order,
							'data_of' => Fungsi::dataOfCek()
						]);
		
					} else if($cekStatus_lama->status == 'cicil'){
		
						// dd("a");
						$data_bayar = DB::table('t_pembayaran')
							->where('data_of', Fungsi::dataOfCek())
							->where('order_id', $data->id_order)
							->get();
		
						$total = 0;
						foreach(Fungsi::genArray($data_bayar) as $d){
							$total += (int)$d->nominal;
						}
		
						$sisa = (int)$data->pembayaran->nominal - $total;
						
						if($sisa > 0){
							$proses_ = DB::table('t_pembayaran')->insert([
								'tgl_bayar' => $data->pembayaran->tanggalBayar,
								'nominal' => $sisa,
								'via' => $data->pembayaran->via,
								'order_id' => $data->id_order,
								'data_of' => Fungsi::dataOfCek()
							]);	
						}
		
					}
					
				} else if($data->pembayaran->status == 'cicil'){
		
					if($cekStatus_lama->status == 'belum'){
		
						$proses_ = DB::table('t_pembayaran')->insert([
							'tgl_bayar' => $data->pembayaran->tanggalBayar,
							'nominal' => (int)$data->pembayaran->nominal,
							'via' => $data->pembayaran->via,
							'order_id' => $data->id_order,
							'data_of' => Fungsi::dataOfCek()
						]);
						
					} else if($cekStatus_lama->status == 'lunas'){
		
						$proses_ = DB::table('t_pembayaran')->insert([
							'tgl_bayar' => $data->pembayaran->tanggalBayar,
							'nominal' => (int)$data->pembayaran->nominal,
							'via' => $data->pembayaran->via,
							'order_id' => $data->id_order,
							'data_of' => Fungsi::dataOfCek()
						]);
		
					}
		
				} else if($data->pembayaran->status == 'belum'){
		
					if($cekStatus_lama->status == 'lunas' || $cekStatus_lama->status == 'cicil'){
		
						$proses_ = DB::table('t_pembayaran')
							->where('data_of', Fungsi::dataOfCek())
							->where('order_id', $data->id_order)
							->delete();
		
					}
				}
	
				$data_update['pembayaran'] = json_encode($data->pembayaran);
	
			} else {
	
				$data_bayar = DB::table('t_pembayaran')
						->where('data_of', Fungsi::dataOfCek())
						->where('order_id', $data->id_order)
						->get();
	
				if($cekStatus_lama->status == 'lunas'){
	
					if(count($data_bayar) < 1){
	
						$data_bayar_baru = $cekStatus_lama;
						$data_bayar_baru->status = 'belum';
						$data_update['pembayaran'] = json_encode($data_bayar_baru);
	
					} else {
	
						$total = 0;
						foreach(Fungsi::genArray($data_bayar) as $dby){
							$total += (int)$dby->nominal;
						}
						
						$harga_total = (int)$data->total->hargaProduk + (int)$data->total->hargaOngkir;
						if(!is_null($data->total->biayaLain)){
							foreach(Fungsi::genArray($data->total->biayaLain) as $bl){
								$harga_total += (int)$bl->harga;
							}
						}
						if(!is_null($data->total->diskonOrder)){
							foreach(Fungsi::genArray($data->total->diskonOrder) as $do){
								$harga_total -= (int)$do->harga;
							}
						}
	
						$sisa = $harga_total - $total;
	
						if($sisa > 0){
							$data_bayar_baru = $cekStatus_lama;
							$data_bayar_baru->status = 'cicil';
							$data_update['pembayaran'] = json_encode($data_bayar_baru);
						} 
	
					}
					
					$proses_ = 1;
				} else if($cekStatus_lama->status == 'cicil'){
	
					if(count($data_bayar) < 1){
	
						$data_bayar_baru = $cekStatus_lama;
						$data_bayar_baru->status = 'belum';
						$data_update['pembayaran'] = json_encode($data_bayar_baru);
	
					} else {
	
						$total = 0;
						foreach(Fungsi::genArray($data_bayar) as $dby){
							$total += (int)$dby->nominal;
						}
						
						$harga_total = (int)$data->total->hargaProduk + (int)$data->total->hargaOngkir;
						if(!is_null($data->total->biayaLain)){
							foreach(Fungsi::genArray($data->total->biayaLain) as $bl){
								$harga_total += (int)$bl->harga;
							}
						}
						if(!is_null($data->total->diskonOrder)){
							foreach(Fungsi::genArray($data->total->diskonOrder) as $do){
								$harga_total -= (int)$do->harga;
							}
						}
	
						if($harga_total === $total){
							$data_bayar_baru = $cekStatus_lama;
							$data_bayar_baru->status = 'lunas';
							$data_update['pembayaran'] = json_encode($data_bayar_baru);
						} 
	
					}
	
					$proses_ = 1;
				} else {
	
					$proses_ = 1; 
	
				}
				 
			}
	
			$update_data = DB::table('t_order')
				->where('data_of', Fungsi::dataOfCek())
				->where('id_order', $data->id_order)
				->update($data_update);
			// if($data->pembayaran->status == "cicil" || $data->pembayaran->status == "lunas"){
			// 	$proses = DB::table('t_pembayaran')->insert([
			// 		'tgl_bayar' => $data->pembayaran->tanggalBayar,
			// 		'nominal' => (int)$data->pembayaran->nominal,
			// 		'via' => $data->pembayaran->via,
			// 		'order_id' => $last_id,
			// 		'data_of' => Fungsi::dataOfCek()
			// 	]);
			// }
			Cache::forget('data_order_lengkap_'.Fungsi::dataOfCek());
			Cache::forget('data_transaksi_lengkap_'.Fungsi::dataOfCek());
			Cache::forget('data_laporan_'.Fungsi::dataOfCek());
			if($update_data || $proses_){
				event(new BelakangLogging(Fungsi::dataOfCek(), 'edit_order', [
					'user_id' => Auth::user()->id,
					'urut_order' => $data_lama->urut_order
				]));
				return redirect()->route('b.order-index')->with([
					'msg_success' => 'Berhasil mengedit Order #'.$data_lama->urut_order.'!',
					'id_update' => $request->id_order
				]);
			} else {
				return redirect()->route('b.order-index')->with([
					'msg_error' => 'Gagal mengedit Order #'.$data_lama->urut_order.'!'
				]);
			}
		} else {
			return redirect()->route('b.order-index');
		}
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
				$ijin->editOrder = 1;
				$ijin->editOrderAdminLain = 1;
				$ijin->cancelOrder = 1;
			}
        } else {
            $ijin = new \stdclass();
            $ijin->uploadProdukExcel = 0;
            $ijin->downloadExcel = 0;
            $ijin->editOrder = 0;
            $ijin->editOrderAdminLain = 0;
            $ijin->cancelOrder = 0;
        }
        return [$data_user, $ijin];
    }

	// public function testes(Request $request){
	// 	$data = json_decode(Fungsi::cekOngkir(255, 351, 30, 'pos', "pro"), true)["rajaongkir"];
	// 	return "<pre>".print_r($data, true)."</pre>";
	// }
	
	// function getRange($max = 10) {
	// 	for ($i = 1; $i < $max; $i++) {
	// 		$injected = yield $i;
	
	// 		if ($injected === 'stop') return;
	// 	}
	// }

}