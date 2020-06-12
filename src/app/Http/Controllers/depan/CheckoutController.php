<?php

namespace App\Http\Controllers\depan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\PusatController as Fungsi;
use Illuminate\Support\Facades\Mail;
use App\Mail\GuestOrder;
use App\Cart;

class CheckoutController extends Controller
{
	public function __construct(){
		$this->middleware('cek_toko_domain');
    }
    
    public function guest_checkout(Request $request, $domain_toko){
        $cart = Cart::getCart($request);
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
        $bank = DB::table('t_bank')
            ->select('bank', 'id_bank')
            ->where('data_of', Fungsi::dataOfByDomainToko($domain_toko))
            ->get();
        if(count($cart) < 1){
            return redirect()->route('d.home', ['domain_toko' => $toko->domain_toko]);
        }
        if(isset($toko)){
            return Fungsi::respon('depan.all.checkout', compact('toko', 'cekOngkir', 'cart', 'alamat_toko_offset', 'bank'), "html", $request);
        } else {
            // ke landing page
        }
    }

    private function getAlamatById($data, $tipe = 'kecamatan'){
        $wilayah_lengkap = json_decode(Fungsi::getContent('data/wilayah-lengkap.json'));
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

    private function getProdukById($id_varian, $data_of){
        $p = DB::table('t_varian_produk')
            ->join('t_produk', 't_produk.id_produk', '=', 't_varian_produk.produk_id')
            ->select('t_varian_produk.*', 't_produk.nama_produk', 't_produk.berat')
            ->where('t_varian_produk.data_of', $data_of)
            ->where('t_varian_produk.id_varian', $id_varian)
            ->get()->first();
        if(isset($p)){
            $data = (array)$p;
            if(!is_null($p->foto_id)){
                $fotoSrc = json_decode($p->foto_id);
                if(!is_null($fotoSrc->utama) && is_numeric($fotoSrc->utama)){
                    $fotoUtama = DB::table('t_foto')->where('id_foto', $fotoSrc->utama)->where('data_of', $data_of)->get()->first();
                    $data['foto']["utama"] = asset($fotoUtama->path);
                    unset($fotoUtama);
                } else if(!is_null($fotoSrc->utama) && filter_var($fotoSrc->utama, FILTER_VALIDATE_URL)){
                    $data['foto']["utama"] = $fotoSrc->utama;
                }
                if($fotoSrc->lain != ""){
                    $fotoLain_list = explode(";", $fotoSrc->lain);
                    foreach($fotoLain_list as $iI => $iL){
                        if(is_numeric($iL)){
                            $fotoLain = DB::table('t_foto')->where('id_foto', $iL)->where('data_of', $data_of)->get()->first();
                            $data['foto']["lain"][$iI+1] = asset($fotoLain->path);
                            unset($fotoLain);
                        } else if(filter_var($fotoSrc->utama, FILTER_VALIDATE_URL)){
                            $data['foto']["lain"][$iI+1] = $iL;
                        }
                    }
                }
            }
            unset($data["data_of"]);
            $hg = DB::table('t_grosir')
                ->select('t_grosir.rentan', 't_grosir.harga', 't_grosir.id_grosir')
                ->where('t_grosir.data_of', $data_of)
                ->where('t_grosir.produk_id', $data["produk_id"])
                ->get();
            if(!empty($hg[0])){
                foreach($hg as $key => $g){
                    $data["harga_grosir"][$key] = $g;
                }
            }
            $data = (object)$data;
            return $data;
        } else {
            return null;
        }
    }

    public function proses(Request $request, $domain_toko){
        if(!$request->ajax() || !$request->filled('tipe')) abort(404);

        $tipe = strip_tags($request->get('tipe'));
        switch($tipe){
            case 'proses_order':
                $data_of = Fungsi::dataOfByDomainToko($domain_toko);
        
        
                $cart = Cart::getCart($request);
                $nama = strip_tags($request->get('nama'));
                $no_telp = strip_tags($request->get('no_telp'));
                $kecamatan = strip_tags($request->get('kecamatan'));
                $kodepos = strip_tags($request->get('kodepos'));
                $alamat = strip_tags($request->get('alamat'));
                $bank = strip_tags($request->get('bank'));
                $berat = strip_tags($request->get('berat'));
                $kurir = strip_tags($request->get('kurir'));
                $email = strip_tags($request->get('email'));
        
                $cekEmail = DB::table('users')
                    ->where('email', $email)
                    ->get()->first();

                if(isset($cekEmail)) {
                    return Fungsi::respon([
                        'status' => false,
                        'pesan' => 'Email sudah digunakan!'
                    ], [], 'json', $request);
                }
        
                $total['hargaProduk'] = 0;
                $list_produk = [];
                foreach(Fungsi::genArray($cart) as $c){
                    $data_prod = $this->getProdukById($c->data->id_varian, $data_of);
                    // dd($data_prod);
                    $list_produk[] = [
                        'rawData' => $data_prod,
                        'jumlah' => $c->jumlah
                    ];
                    $total['hargaProduk'] += ($data_prod->harga_jual_normal * $c->jumlah);
                    unset($data_prod);
                }
                $total['hargaOngkir'] = (int)explode('|', $kurir)[2];
                $total['biayaLain'] = null;
                $total['diskonOrder'] = null;
                $total['diskonProduk'] = null;
        
        
                $customer_id = DB::table('users')->insertGetId([
                    'name' => $nama,
                    'email' => $email,
                    'no_telp' => $no_telp,
                    'password' => Hash::make($email),
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s")
                ]);
                $customer_user_id = DB::table('t_customer')->insertGetId([
                    'user_id' => $customer_id,
                    'kategori' => 'Customer',
                    'provinsi' => $this->getAlamatById($kecamatan, 'provinsi'),
                    'kabupaten' => $this->getAlamatById($kecamatan, 'kabupaten'),
                    'kecamatan' => $this->getAlamatById($kecamatan, 'kecamatan'),
                    'kode_pos' => $kodepos,
                    'alamat' => $alamat,
                    'data_of' => $data_of
                ]);
        
                if($request->get('catatan') == ''){
                    $catatan["print"] = 'false';
                    $catatan["data"] = '';
                } else {
                    $catatan["print"] = 'true';
                    $catatan["data"] = $request->get('catatan');
                }
                $kat_customer = DB::table('t_store')
                    ->where('data_of', Fungsi::dataOfByDomainToko($domain_toko))
                    ->select('kat_customer')
                    ->get()->first();
                $urutObj = DB::table('t_order')->select("urut_order")->where('data_of', $data_of)->orderBy("urut_order", "desc")->get()->first();
                $urut = is_null($urutObj) ? 1 : $urutObj->urut_order+1;
                $order_id = DB::table('t_order')->insertGetId([
                    'urut_order' => $urut,
                    'pemesan_id' => $customer_user_id,
                    'pemesan_kategori' => 'Customer',
                    'tujuan_kirim_id' => $customer_user_id,
                    'kecamatan_asal_kirim_id' => $kecamatan.'|'.$this->getAlamatById($kecamatan, 'kecamatan').', '.$this->getAlamatById($kecamatan, 'kabupaten').', '.$this->getAlamatById($kecamatan, 'provinsi'),
                    'tanggal_order' => date('d F Y'),
                    'pembayaran' => json_encode([
                        'status' => 'belum',
                        'tanggalBayar' => date('d F Y'),
                        'via' => $bank,
                        'nominal' => ''
                    ]),
                    'produk' => json_encode([
                        'totalBerat' => (int)$berat,
                        'list' => $list_produk
                    ]),
                    'kurir' => json_encode([
                        'tipe' => 'expedisi',
                        'data' => $kurir
                    ]),
                    'total' => json_encode($total),
                    'catatan' => json_encode($catatan),
                    'state' => 'bayar',
                    'cicilan_state' => 0,
                    'src' => 'storefront',
                    'admin_id' => null,
                    'order_source_id' => null,
                    'kat_customer' => $kat_customer->kat_customer,
                    'tgl_dibuat' => date("Y-m-d H:i:s"),
                    'tgl_expired' => date("Y-m-d H:i:s", strtotime('tomorrow')),
                    'data_of' => $data_of
                ]);

                $emailFrom = DB::table('users')
                    ->where('id', $data_of)
                    ->get()->first()->email;
                $nama_toko = DB::table('t_store')
                    ->where('data_of', $data_of)
                    ->select('nama_toko')
                    ->get()->first()->nama_toko;

                try {

                    // Log::info('mau mengirim email queue');
                    Mail::to($email)->send(new GuestOrder([
                        'alamat' => $emailFrom,
                        'nama' => $nama_toko
                    ], 'sss'));
                    // dispatch(new SendEmail([
                    //     'tujuan' => $user->email,
                    //     'email' => new EmailVerification($user, route('b.email-verified', ['token' => $user->email_token]))
                    // ]));
                    // Log::info('selesai mengirim email queue');
        
                } catch(\Exception $e){
                    return Fungsi::respon([
                        'status' => false,
                        'pesan' => $e->getMessage()
                    ], [], 'json', $request);
                }
                return Fungsi::respon([
                    'status' => true,
                    'pesan' => 'Berhasil mengirim invoice ke email anda!',
                    'order_id' => $order_id
                ], [], 'json', $request);
                break;

            default:
                abort(404);
                break;
        }
    }

    public function orderIndex(Request $request, $domain_toko, $order_id = null){
        echo "asd";
    }
}