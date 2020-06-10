<?php

namespace App\Http\Controllers\depan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\PusatController as Fungsi;
use Cart;

class CheckoutController extends Controller
{
	public function __construct(){
		$this->middleware('cek_toko_domain');
    }
    
    public function guest_checkout(Request $request, $domain_toko){
        $cart = Cart::session($request->getClientIp())->getContent();
		$toko = DB::table('t_store')
            ->where('domain_toko', $domain_toko)
            ->get()->first();
        $data_store = DB::table('t_store')
            ->where('data_of', Fungsi::dataOfByDomainToko($domain_toko))
            ->select('cek_ongkir', 'kat_customer', 'alamat_toko_offset')
            ->get()->first();
        $cekOngkir = [];
        foreach(Fungsi::genArray(json_decode($data_store->cek_ongkir)) as $iO => $vO){
            if($vO){
                $cekOngkir[] = $iO;
            }
        }
        $cekOngkir = json_encode($cekOngkir);
        $alamat_toko_offset = $data_store->alamat_toko_offset;
        $cart = Cart::session($request->getClientIp())->getContent();
        if(count($cart) < 1){
            return redirect()->route('d.home', ['domain_toko' => $toko->domain_toko]);
        }
        if(isset($toko)){
            return Fungsi::respon('depan.all.checkout', compact('toko', 'cekOngkir', 'cart', 'alamat_toko_offset'), "html", $request);
        } else {
            // ke landing page
        }
    }

    private function getAlamatById($data, $tipe = 'kecamatan'){
        $wilayah_lengkap = json_decode(Fungsi::getContent('data/wilayah_lengkap.json'));
        switch($tipe){
            case 'provinsi':
                $id = explode('|', $data)[0];
                $objW = Fungsi::genArray($wilayah_lengkap);
                $ketemu = null;
                foreach($objW as $w){
                    if($w->provinsi->id == $id) {
                        $ketemu = $w->provinsi->nama;
                        $objW->send('stop');
                    }
                }
                return $ketemu;
                break;

            case 'kabupaten':
                $id = explode('|', $data)[1];
                $objW = Fungsi::genArray($wilayah_lengkap);
                $ketemu = null;
                foreach($objW as $w){
                    if($w->kota->id == $id) {
                        $ketemu = $w->kota->nama;
                        $objW->send('stop');
                    }
                }
                return $ketemu;
                break;

            case 'kecamatan':
            default:
                $id = explode('|', $data)[2];
                $objW = Fungsi::genArray($wilayah_lengkap);
                $ketemu = null;
                foreach($objW as $w){
                    if($w->kecamatan->id == $id) {
                        $ketemu = $w->kecamatan->nama;
                        $objW->send('stop');
                    }
                }
                return $ketemu;
                break;

        }
    }

    public function proses(Request $request){
        return "<pre>".print_r($request->all(), true)."</pre>";
        
        $nama = strip_tags($request->get('nama'));
        $no_telp = strip_tags($request->get('no_telp'));
        $kecamatan = strip_tags($request->get('kecamatan'));
        $kodepos = strip_tags($request->get('kodepos'));
        $alamat = strip_tags($request->get('alamat'));

        $email_offset = 'kosong|'.str_random();
        $customer_id = DB::table('users')->insertGetId([
            'name' => $nama,
            'email' => $email_offset,
            'no_telp' => $no_telp,
            'password' => Hash::make($email_offset),
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ]);
        $customer = DB::table('t_customer')->insert([
            'user_id' => $customer_id,
            'kategori' => 'Customer',
            'provinsi' => $this->getAlamatById($kecamatan, 'provinsi'),
            'kabupaten' => $this->getAlamatById($kecamatan, 'kabupaten'),
            'kecamatan' => $this->getAlamatById($kecamatan, 'kecamatan'),
            'kode_pos' => $kodepos,
            'alamat' => $alamat,
            'data_of' => Fungsi::dataOfCek()
        ]);

        if($request->get('catatan') == ''){
            $catatan["print"] = 'false';
            $catatan["data"] = '';
        } else {
            $catatan["print"] = 'true';
            $catatan["data"] = $request->get('catatan');
        }
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
    }
}