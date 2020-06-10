<?php

namespace App\Http\Controllers\belakang;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use Illuminate\Contracts\Encryption\DecryptException;
use App\Http\Controllers\PusatController as Fungsi;


class SettingController extends Controller
{
	public function __construct(){
		$this->middleware(['b.auth', 'xss_protect', 'b.cekOwner', 'b.cekDataToko']);
    }
    
    public function index(Request $request, Fungsi $fungsi){
        $id = Fungsi::dataOfCek();
        $pass = Fungsi::acakPass();
        $wilayah_indonesia = json_decode(Fungsi::getContent('data/wilayah_indonesia.json'));
		$wilayah_lengkap = json_decode(Fungsi::getContent('data/wilayah-lengkap.json'));
        $store = DB::table('t_store')
            ->join('users', 'users.id', '=', 't_store.data_of')
            ->where('users.id', $id)
            ->select('users.id', 't_store.*')
            ->get()->first();
        $foto = DB::table('t_store')
            ->join('t_foto', 't_foto.id_foto', '=', 't_store.foto_id')
            ->select('t_store.foto_id', 't_foto.path')
            ->where('t_store.data_of', Fungsi::dataOfCek())
            ->get()->first();

        $folder = array_filter(glob('src/resources/views/depan/*'), 'is_dir');
        $piece = [];

        foreach ($folder as $row) {
            $pi_[0] = explode("/", $row)[4];
            if(strtolower($pi_[0]) == strtolower($store->template)){
                $pi_[1] = "<i class='fa fa-check green-600'></i>";
            } else {
                $pi_[1] = '';
            }
            $piece[] = $pi_;
        };
        // dd($piece);
        if (!isset($foto)) {
            $tmp_logo['id'] = "";
            $tmp_logo['path'] = "";
        }else{
            $tmp_logo['id'] = encrypt($foto->foto_id);
            $tmp_logo['path'] = $foto->path;
        }
        // return var_dump($path_foto);

        $cekOngkir = json_decode(DB::table('t_store')
            ->where('data_of', $id)
            ->select('cek_ongkir')
            ->get()->first()->cek_ongkir);
        
        $key = Cache::rememberForever('data_key_pengaturan', function(){
            $key['t_order_source']['dd'] = encrypt('tambah_order_source', false);
            $key['t_order_source']['tt'] = base64_encode('tambah_order_source');
            $key['e_order_source']['dd'] = encrypt('edit_order_source', false);
            $key['e_order_source']['tt'] = base64_encode('edit_order_source');
            $key['h_order_source']['dd'] = encrypt('hapus_order_source', false);
            $key['h_order_source']['tt'] = base64_encode('hapus_order_source');
            $key['s_order_source']['dd'] = encrypt('switch_order_source', false);
            $key['s_order_source']['tt'] = base64_encode('switch_order_source');
            $key['e_stok_limit']['dd'] = encrypt('edit_stok_limit', false);
            $key['e_stok_limit']['tt'] = base64_encode('edit_stok_limit');
            $key['e_kat_customer']['dd'] = encrypt('edit_kat_customer', false);
            $key['e_kat_customer']['tt'] = base64_encode('edit_kat_customer');
            $key['t_bank']['dd'] = encrypt('tambah_bank', false);
            $key['t_bank']['tt'] = base64_encode('tambah_bank');
            $key['e_bank']['dd'] = encrypt('edit_bank', false);
            $key['e_bank']['tt'] = base64_encode('edit_bank');
            $key['h_bank']['dd'] = encrypt('hapus_bank', false);
            $key['h_bank']['tt'] = base64_encode('hapus_bank');
            $key['t_supplier']['dd'] = encrypt('tambah_supplier', false);
            $key['t_supplier']['tt'] = base64_encode('tambah_supplier');
            $key['e_supplier']['dd'] = encrypt('edit_supplier', false);
            $key['e_supplier']['tt'] = base64_encode('edit_supplier');
            $key['h_supplier']['dd'] = encrypt('hapus_supplier', false);
            $key['h_supplier']['tt'] = base64_encode('hapus_supplier');
            $key['e_template']['dd'] = encrypt('edit_template', false);
            $key['e_template']['tt'] = base64_encode('edit_template');
            $key['e_toko']['dd'] = encrypt('edit_toko', false);
            $key['e_toko']['tt'] = base64_encode('edit_toko');
            $key['t_user']['dd'] = encrypt('tambah_user', false);
            $key['t_user']['tt'] = base64_encode('tambah_user');
            $key['e_user']['dd'] = encrypt('edit_user', false);
            $key['e_user']['tt'] = base64_encode('edit_user');
            $key['h_user']['dd'] = encrypt('hapus_user', false);
            $key['h_user']['tt'] = base64_encode('hapus_user');
            $key['e_filter_order']['dd'] = encrypt('edit_filter_order', false);
            $key['e_filter_order']['tt'] = base64_encode('edit_filter_order');
            $key['h_filter_order']['dd'] = encrypt('hapus_filter_order', false);
            $key['h_filter_order']['tt'] = base64_encode('hapus_filter_order');
            $key['e_cek_ongkir']['dd'] = encrypt('edit_cek_ongkir', false);
            $key['e_cek_ongkir']['tt'] = base64_encode('edit_cek_ongkir');
            $key['h_data_cache']['dd'] = encrypt('hapus_data_cache', false);
            $key['h_data_cache']['tt'] = base64_encode('hapus_data_cache');
            return $key;
        });

        $genKecamatan2 = Fungsi::genArray($wilayah_lengkap);
        if($store->alamat_toko_offset == '' || is_null($store->alamat_toko_offset) || preg_match('/[0-9]{1,2}\|[0-9]{1,3}\|[0-9]{1,5}/i', $store->alamat_toko_offset) === 0){
            $kecamatan_cari = null;
        } else {
            $kecamatan_c = explode('|', $store->alamat_toko_offset)[2];
            foreach($genKecamatan2 as $w){
                if(preg_match("/".strTolower($kecamatan_c)."/", strtolower($w->kecamatan->id))){
                    $kecamatan_cari = json_encode([
                        'value' => $w->provinsi->id."|".$w->kota->id."|".$w->kecamatan->id,
                        'label' => $w->kecamatan->nama.", ".$w->kota->nama.", ".$w->provinsi->nama
                    ]);
                    $genKecamatan2->send('stop');
                }
            }
        }

        $kat_customer = json_decode($store->kat_customer);
        if ($request->ajax()) {
            return Fungsi::respon('belakang.setting', compact('store', 'pass', 'wilayah_indonesia', 'tmp_logo', 'piece', 'kat_customer', 'key', 'cekOngkir', 'kecamatan_cari'), 'ajax', $request);
        }
        return Fungsi::respon('belakang.setting', compact('store', 'pass', 'wilayah_indonesia', 'tmp_logo', 'piece', 'kat_customer', 'key', 'cekOngkir', 'kecamatan_cari'), 'html', $request);
    }

    public function proses(Request $request){
        if($request->ajax()){
            try {
                $tipeKirim = decrypt($request->dd, false);
            } catch (DecryptException $e) {
                return Fungsi::respon(['status' => false, 'msg' => "Anda mencoba melakukan hal yang tidak semestinya!"], [], 'json', $request);
            }
            $tipeKirim2 = base64_decode($request->tt);
            if(strcmp($tipeKirim, $tipeKirim2) === 0){
                switch($tipeKirim){
                    case 'first_setup':
                        $domain_not_allow = [
                            'admin',
                            'customer',
                            'administrator',
                            'app',
                            'aplikasi',
                            'application',
                            'pelanggan',
                            'dropshipper',
                            'reseller',
                            'superadmin'
                        ];
                        $domain = $request->subdomainToko;
                        $no_telpToko = $request->no_telpToko;
                        $alamatToko = $request->alamatToko;
                        $kecamatan = $request->kecamatan;
                        $cekDomain = DB::table('t_store')->where('domain_toko', $domain)->get()->first();
                        if(isset($cekDomain) || in_array($domain, $domain_not_allow)){
                            return Fungsi::respon(['status' => false, 'msg' => "Subdomain telah digunakan!"], [], 'json', $request);
                        }
                        $cekNo_telp = DB::table('t_store')->where('no_telp_toko', $no_telpToko)->get()->first();
                        if(isset($cekNo_telp)){
                            return Fungsi::respon(['status' => false, 'msg' => "No Telp toko telah digunakan!"], [], 'json', $request);
                        }
                        $store = DB::table('t_store')
                            ->where('data_of', Fungsi::dataOfCek())
                            ->update([
                                'nama_toko' => $request->namaToko,
                                'template' => 'default',
                                'alamat_toko' => $alamatToko,
                                'alamat_toko_offset' => $kecamatan,
                                'domain_toko' => $domain,
                                'no_telp_toko' => $no_telpToko,
                                'deskripsi_toko' => $request->deskripsiToko,
                            ]);
                        $user = DB::table('users')
                            ->where('id', Fungsi::dataOfCek())
                            ->update([
                                'name' => $request->namaLengkap,
                            ]);
                        if ($store || $user) {
                            return Fungsi::respon(['status' => true], [], 'json', $request);
                        } else {
                            return Fungsi::respon(['status' => false, 'msg' => "Gagal menyimpan data!"], [], 'json', $request);
                        }
                        break;

                    case 'tambah_order_source':
                        $orderSource = DB::table('t_order_source')
                            ->insert([
                                'store_id' => $request->storeId,
                                'kategori' => $request->kategoriOs,
                                'keterangan' => $request->ketOs,
                                'status' => $request->status,
                                'data_of' => Fungsi::dataOfCek()
                            ]);
                        Cache::forget('data_order_source_lengkap_'.Fungsi::dataOfCek());
                        if ($orderSource) {
                            return Fungsi::respon(['status' => true], [], 'json', $request);
                        } else {
                            return Fungsi::respon(['status' => false, 'msg' => "Gagal menyimpan Order Source!"], [], 'json', $request);
                        }
                        break;

                    case 'edit_order_source':
                        $orderSource = DB::table('t_order_source')
                            ->where('id_order_source', $request->id)
                            ->update([
                                'kategori' => $request->kategoriOs,
                                'keterangan' => $request->ketOs,
                                'status' => $request->status,
                                'data_of' => Fungsi::dataOfCek()
                            ]);
                        Cache::forget('data_order_source_lengkap_'.Fungsi::dataOfCek());
                        if ($orderSource) {
                            return Fungsi::respon(['status' => true], [], 'json', $request);
                        } else {
                            return Fungsi::respon(['status' => false, 'msg' => $orderSource], [], 'json', $request);
                        }
                        break;

                    case 'hapus_order_source':
                        $deleteOrderS = DB::table('t_order_source')
                            ->where('id_order_source', $request->id)
                            ->where('data_of', Fungsi::dataOfCek())
                            ->delete();
                        Cache::forget('data_order_source_lengkap_'.Fungsi::dataOfCek());
                        if($deleteOrderS){
                            return Fungsi::respon(['sukses' => true], [], 'json', $request);
                        } else {
                            return Fungsi::respon(['sukses' => false, 'msg' => $deleteOrderS], [], 'json', $request);
                        }
                        break;
                    case 'switch_order_source':
                        $orderSourceSet = DB::table('t_store')
                            ->where('id_store', $request->storeId)
                            ->update([
                                's_order_nama' => $request->namaOrder ? "on" : "off",
                                's_tampil_logo' => $request->tampilLogo ? "on" : "off",
                                's_order_source' => $request->orderSource ? "on" : "off",
                                'data_of' => Fungsi::dataOfCek()
                            ]);
                        if ($orderSourceSet) {
                            return Fungsi::respon(['status' => true], [], 'json', $request);
                        } else {
                            return Fungsi::respon(['status' => false, 'msg' => $orderSourceSet], [], 'json', $request);
                        }
                        break;
                    case 'edit_stok_limit':
                        $stockLimit = DB::table('t_store')
                            ->where('id_store', $request->storeId)
                            ->update([
                                'stok_produk_limit' => $request->stockLimit,
                                'data_of' => Fungsi::dataOfCek()
                            ]);
                        if ($stockLimit) {
                            return Fungsi::respon(['status' => true], [], 'json', $request);
                        } else {
                            return Fungsi::respon(['status' =>false, 'msg' => $stockLimit], [], 'json', $request);
                        };
                        break;
                    case 'edit_kat_customer':
                        $data['customer']['grosir'] = $request->grosirCustomer;
                        $data['customer']['diskon'] = $request->diskonCustomer;
                        $data['dropshipper']['grosir'] = $request->grosirDropshipper;
                        $data['dropshipper']['diskon'] = $request->diskonDropshipper;
                        $data['reseller']['grosir'] = $request->grosirReseller;
                        $data['reseller']['diskon'] = $request->diskonReseller;
                        $sgd = DB::table('t_store')
                            ->where('id_store', $request->storeId)
                            ->where('data_of', Fungsi::dataOfCek())
                            ->update([
                                'kat_customer' => json_encode($data)
                            ]);
                        if($sgd){
                            return Fungsi::respon(['status' => true], [], 'json', $request);
                        } else {
                            return Fungsi::respon(['status' => false, 'msg' => $sgd], [], 'json', $request);
                        }
                        break;

                    case 'tambah_bank':
                        $bank = DB::table('t_bank')
                            ->insert([
                                'bank' => $request->bank,
                                'no_rek' => $request->no_rek,
                                'cabang' => $request->cabang,
                                'atas_nama' => $request->nama,
                                'data_of' => Fungsi::dataOfCek(),
                            ]);
                        Cache::forget('data_bank_lengkap_'.Fungsi::dataOfCek());
                        if($bank){
                            return Fungsi::respon(['status' => true], [], 'json', $request);
                        } else {
                            return Fungsi::respon(['status' => false, 'msg' => $bank], [], 'json', $request);
                        }
                        break;
                    case 'edit_bank':
                        $bank = DB::table('t_bank')
                            ->where('id_bank', $request->id)
                            ->where('data_of', Fungsi::dataOfCek())
                            ->update([
                                'bank' => $request->bank,
                                'cabang' => $request->cabang,
                                'no_rek' => $request->no_rek,
                                'atas_nama' => $request->nama,
                            ]);
                        Cache::forget('data_bank_lengkap_'.Fungsi::dataOfCek());
                        if ($bank) {
                            return Fungsi::respon(['status' => true], [], 'json', $request);
                        } else {
                            return Fungsi::respon(['status' => false, 'msg' => $bank], [], 'json', $request);
                        }
                        break;
                    case 'hapus_bank':
                        $bank = DB::table('t_bank')
                            ->where('id_bank', $request->id)
                            ->where('data_of', Fungsi::dataOfCek())
                            ->delete();
                        Cache::forget('data_bank_lengkap_'.Fungsi::dataOfCek());
                        if ($bank) {
                            return Fungsi::respon(['sukses' => true], [], 'json', $request);
                        } else {
                            return Fungsi::respon(['sukses' => false, 'msg' => 'Gagal menghapus data!'], [], 'json', $request);
                        }
                        break;
                    case 'edit_template':
                        $template = DB::table('t_store')
                            ->where('data_of', Fungsi::dataOfCek())
                            ->update([
                                'template' => $request->template,
                            ]);
                        if($template){
                            return Fungsi::respon(['status' => true], [], 'json', $request);
                        } else {
                            return Fungsi::respon(['status' => false, 'msg' => "Gagal memilih template!"], [], 'json', $request);
                        }
                        break;
                    case 'tambah_user':
                        $cekEmail = DB::table('users')->where('email', $request->emailUser)->get()->first();
                        if(isset($cekEmail)){
                            return Fungsi::respon(['status' => false, 'msg' => "Email sudah digunakan!"], [], 'json', $request);
                        }
                        $userId = DB::table('users')->insertGetId([
                            'name' => $request->namaUser,
                            'username' => $request->usernameUser,
                            'email' => $request->emailUser,
                            'no_telp' => $request->no_telpUser,
                            'password' => Hash::make($request->passUser)
                        ]);
                        $user_meta = DB::table('t_user_meta')->insert([
                            'user_id' => $userId,
                            'role' => $request->roleUser,
                            'ijin' => ($request->roleUser == 'Admin') ? $request->ijinUser : null,
                            'data_of' => Fungsi::dataOfCek(),
                        ]);
                        Cache::forget('data_user_pengaturan_'.Fungsi::dataOfCek());
                        if($userId && $user_meta){
                            return Fungsi::respon(['status' => true], [], 'json', $request);
                        } else {
                            return Fungsi::respon(['status' => false, 'msg' => 'Gagal menambah user!'], [], 'json', $request);
                        }
                        break;
                    case 'edit_user':
                        if($request->passUser != ""){
                            $editUser = DB::table('users')
                            ->where('id', $request->id)
                            ->update([
                                'name' => $request->namaUser,
                                'username' => $request->usernameUser,
                                'email' => $request->emailUser,
                                'no_telp' => $request->no_telpUser,
                                'password' => Hash::make($request->passUser)
                            ]);
                        } else {
                            $editUser = DB::table('users')
                            ->where('id', $request->id)
                            ->update([
                                'name' => $request->namaUser,
                                'username' => $request->usernameUser,
                                'email' => $request->emailUser,
                                'no_telp' => $request->no_telpUser
                            ]);
                        }
                        $editRole = DB::table('t_user_meta')
                            ->where('user_id', $request->id)
                            ->where('data_of', Fungsi::dataOfCek())
                            ->update([
                                'role' => $request->roleUser,
                                'ijin' => ($request->roleUser == 'Admin') ? $request->ijinUser : null,
                            ]);
                        Cache::forget('data_user_pengaturan_'.Fungsi::dataOfCek());
                        if ($editUser || $editRole) {
                            return Fungsi::respon(['status' => true], [], 'json', $request);
                        }else{
                            return Fungsi::respon(['status' => false, 'msg' => 'Gagal mengedit user!'], [], 'json', $request);
                        }
                        break;
                    case 'hapus_user':
                        $proses1 = DB::table('users')
                            ->where('id', $request->id)
                            ->delete();
                        $proses2 = DB::table('t_user_meta')
                            ->where('user_id', $request->id)
                            ->where('data_of', Fungsi::dataOfCek())
                            ->delete();
                        Cache::forget('data_user_pengaturan_'.Fungsi::dataOfCek());
                        if ($proses1 && $proses2) {
                            return Fungsi::respon(['sukses' => true], [], 'json', $request);
                        } else {
                            return Fungsi::respon(['sukses' => false, 'msg' => 'Gagal menghapus data!'], [], 'json', $request);
                        }
                        break;
                    case 'edit_filter_order':
                        $proses1 = DB::table('t_filter_order')
                            ->where('id_filter_order', $request->id)
                            ->where('data_of', Fungsi::dataOfCek())
                            ->update([
                                'nama_filter' => $request->nama_filter
                            ]);
                        Cache::forget('data_filter_order_lengkap_'.Fungsi::dataOfCek());
                        if ($proses1) {
                            return Fungsi::respon(['sukses' => true], [], 'json', $request);
                        } else {
                            return Fungsi::respon(['sukses' => false, 'msg' => 'Gagal mengngedit Filter Order!'], [], 'json', $request);
                        }
                        break;
                    case 'hapus_filter_order':
                        $proses1 = DB::table('t_filter_order')
                            ->where('id_filter_order', $request->id)
                            ->where('data_of', Fungsi::dataOfCek())
                            ->delete();
                        Cache::forget('data_filter_order_lengkap_'.Fungsi::dataOfCek());
                        if ($proses1) {
                            return Fungsi::respon(['sukses' => true], [], 'json', $request);
                        } else {
                            return Fungsi::respon(['sukses' => false, 'msg' => 'Gagal menghapus Filter Order!'], [], 'json', $request);
                        }
                        break;
                    case 'edit_cek_ongkir':
                        $ongkir = DB::table('t_store')
                            ->where('data_of', Fungsi::dataOfCek())
                            ->update([
                                'cek_ongkir' => $request->cekongkir
                            ]);
                        if ($ongkir) {
                            return Fungsi::respon(['status' => true], [], 'json', $request);
                        } else {
                            return Fungsi::respon(['status' => false, 'msg' => 'Gagal mengedit Cek Ongkir!'], [], 'json', $request);
                        }
                        break;
                    case 'hapus_data_cache':
                        Cache::flush();
                        return Fungsi::respon(['status' => true], [], 'json', $request);
                        break;

                    
                    default:
                        return Fungsi::respon(['status' => false, 'msg' => "Anda mencoba melakukan hal yang tidak semestinya!"], [], 'json', $request);
                        break;
                }
            } else {
                return Fungsi::respon(['status' => false, 'msg' => "Anda mencoba melakukan hal yang tidak semestinya!"], [], 'json', $request);
            }
        } else {
            try {
                $tipeKirim = decrypt($request->dd, false);
            } catch (DecryptException $e) {
                return Fungsi::respon(['status' => false, 'msg' => "Anda mencoba melakukan hal yang tidak semestinya!"], [], 'json', $request);
            }
            $tipeKirim2 = base64_decode($request->tt);
            if(strcmp($tipeKirim, $tipeKirim2) === 0 && strcmp($tipeKirim, 'edit_toko') === 0){
                $dataMauSimpan['nama_toko'] = $request->namaToko;
                $dataMauSimpan['no_telp_toko'] = $request->no_telpToko;
                $dataMauSimpan['deskripsi_toko'] = $request->deskripsiToko;
                $dataMauSimpan['alamat_toko'] = $request->alamatToko;
                $dataMauSimpan['alamat_toko_offset'] = $request->kecamatan;
                if($dataMauSimpan['nama_toko'] == ''){
                    return redirect()->route("b.setting-index")->with(['msg_error' => 'Gagal mengubah pengaturan toko, Nama Toko belum diisi!']);
                }
                if($dataMauSimpan['no_telp_toko'] == ''){
                    return redirect()->route("b.setting-index")->with(['msg_error' => 'Gagal mengubah pengaturan toko, No Telepon Toko belum diisi!']);
                }
                if($dataMauSimpan['deskripsi_toko'] == ''){
                    return redirect()->route("b.setting-index")->with(['msg_error' => 'Gagal mengubah pengaturan toko, Deskripsi Toko belum diisi!']);
                }
                if($dataMauSimpan['alamat_toko'] == ''){
                    return redirect()->route("b.setting-index")->with(['msg_error' => 'Gagal mengubah pengaturan toko, Alamat Toko belum diisi!']);
                }
                if($dataMauSimpan['alamat_toko_offset'] == '' || preg_match('/[0-9]{1,2}\|[0-9]{1,3}\|[0-9]{1,5}/i', $dataMauSimpan['alamat_toko_offset']) === 0){
                    return redirect()->route("b.setting-index")->with(['msg_error' => 'Gagal mengubah pengaturan toko, Alamat Kecamatan Toko belum dipilih!']);
                }
                $logo = $request->file('logoToko');
                $tmp_logo = $request->logoTemp;
                $logo_id = null;
                $logo_lawas = false;
                if(isset($logo)){
                    if(in_array(strtolower($logo->getClientOriginalExtension()), array('jpg', 'jpeg', 'png', 'bmp', 'gif', ''))){
                        $path = "../data/".base64_encode(base64_encode(Fungsi::dataOfCek())."+".base64_encode(Fungsi::dataOfCekUsername()))."/";
                        if(is_dir(base_path($path))){
                            $path_isset = true;
                        } else {
                            if(mkdir(base_path($path), 0777, true)){
                                $path_isset = true;
                            } else {
                                $path_isset = false;
                                return response()->json(["error" => "Cannot create a folder!"]);
                            }
                        }
                        $filename = base64_encode(mt_rand(1, 99)).base64_encode($logo->getClientOriginalName().mt_rand(1, 999)).".".$logo->getClientOriginalExtension();
                        if($path_isset){
                            if($tmp_logo == ""){
                                if($logo->move(base_path($path), $filename)){
                                    $logo_id = DB::table('t_foto')->insertGetId([
                                        'path' => $path.$filename,
                                        'data_of' => Fungsi::dataOfCek()
                                    ]);
                                }
                            } else if(preg_match("/^hapus\+/", $tmp_logo)){
                                $tmpId_foto = decrypt(explode("hapus+", $tmp_logo)[1]);
                                $lastPath_foto = DB::table("t_foto")->select("path")->where("id_foto", $tmpId_foto)->where("data_of", Fungsi::dataOfCek())->get()->first();
                                if(isset($lastPath_foto)){
                                    if(file_exists(base_path($lastPath_foto->path))){
                                        unlink(base_path($lastPath_foto->path));
                                        $hapusFoto = DB::table('t_foto')->where('id_foto', $tmpId_foto)->where('data_of', Fungsi::dataOfCek())->delete();
                                    }
                                    if($logo->move(base_path($path), $filename)){
                                        $logo_id = DB::table('t_foto')->insertGetId([
                                            'path' => $path.$filename,
                                            'data_of' => Fungsi::dataOfCek()
                                        ]);
                                    }
                                }
                            } else {
                                $tmpId_foto = decrypt($tmp_logo);
                                $lastPath_foto = DB::table("t_foto")->select("path")->where("id_foto", $tmpId_foto)->where("data_of", Fungsi::dataOfCek())->get()->first();
                                if(isset($lastPath_foto)){
                                    if(file_exists(base_path($lastPath_foto->path))){
                                        unlink(base_path($lastPath_foto->path));
                                        $hapusFoto = DB::table('t_foto')->where('id_foto', $tmpId_foto)->where('data_of', Fungsi::dataOfCek())->delete();
                                    }
                                    if($logo->move(base_path($path), $filename)){
                                        $logo_id = DB::table('t_foto')->insertGetId([
                                            'path' => $path.$filename,
                                            'data_of' => Fungsi::dataOfCek()
                                        ]);
                                    }
                                }
                            }
                        }
                    } else {
                        return redirect()->route("b.setting-index")->with(['msg_error' => 'Extensi/Format gambar pada logo tidak didukung!']);
                    }
                } else {
                    if(preg_match("/^hapus\+/", $tmp_logo)){
                        $logo_lawas = true;
                        $tmpId_foto = decrypt(explode("hapus+", $tmp_logo)[1]);
                        $lastPath_foto = DB::table("t_foto")->select("path")->where("id_foto", $tmpId_foto)->where("data_of", Fungsi::dataOfCek())->get()->first();
                        if(isset($lastPath_foto)){
                            if(file_exists(base_path($lastPath_foto->path))){
                                unlink(base_path($lastPath_foto->path));
                                $hapusFoto = DB::table('t_foto')->where('id_foto', $tmpId_foto)->where('data_of', Fungsi::dataOfCek())->delete();
                            }
                        }
                    }
                }
                if(!is_null($logo_id) && !$logo_lawas){
                    $dataMauSimpan['foto_id'] = $logo_id;
                } else if(is_null($logo_id) && $logo_lawas){
                    $dataMauSimpan['foto_id'] = null;
                }       
                $storeSet = DB::table('t_store')
                    ->where('data_of', Fungsi::dataOfCek())
                    ->update($dataMauSimpan);
                if ($storeSet) {
                    return redirect()->route("b.setting-index")->with(['msg_success' => 'Pengaturan toko berhasil disimpan!']);
                } else {
                    return redirect()->route("b.setting-index")->with(['msg_error' => 'Pengaturan toko gagal disimpan!']);
                };
            } else {
                abort(404);
            }
        }
    }

    public function getOrderSourceData(Request $request){
        if($request->ajax()){
            if(isset($request->v)){
                $order_source = DB::table('t_order_source')
                    ->where('t_order_source.id_order_source', $request->v)
                    ->where('t_order_source.data_of', Fungsi::dataOfCek())
                    ->get()->first();
                return Fungsi::respon($order_source, [], 'json', $request);
            }
            $orderSource = Cache::remember('data_order_source_lengkap_'.Fungsi::dataOfCek(), 10000, function(){
                return DB::table('t_order_source')->where('data_of', Fungsi::dataOfCek())->get();
            });
            $data = [];
            $no = 0;
            foreach (Fungsi::genArray($orderSource) as $row ) {
                if ($row->status) {
                    $row3 = "<div class=\"badge badge-success badge-round\" style='cursor:default' readonly>
                        <span class=\"text-uppercase hidden-sm-down\">On</span>
                        </div>";
                } else {
                    $row3 ="<div class=\"badge badge-danger badge-round\" style='cursor:default' readonly>
                        <span class=\"text-uppercase hidden-sm-down\">Off</span>
                        </div>";
                };
                $data[$no++] = [
                    '',
                    $row->kategori. "<br><small style='color:#888;'>" . $row->keterangan . "</small>",
                    $row3,
                    "<button type='button' data-target='#editOrderSource' data-toggle='modal' class='btn btn-warning btn-xs' onClick='$(this).editOrderSource()' data-id='".$row->id_order_source."'>Edit</button>
                    <button type='button' class='btn btn-danger btn-xs' onClick='$(this).hapusOrderSource(tabelDataOrderSource)' data-id='".$row->id_order_source."'>Hapus</button>",
                ];
            }
            $result['data'] = $data;
            return Fungsi::respon($result, [], 'json', $request);
        } else {
            abort(404);
        }
    }

    public function getFilterOrderData(Request $request){
        if($request->ajax()){
            if(isset($request->v)){
                $filter_order = DB::table('t_filter_order')
                    ->where('t_filter_order.id_filter_order', $request->v)
                    ->where('t_filter_order.data_of', Fungsi::dataOfCek())
                    ->get()->first();
                return Fungsi::respon($filter_order, [], 'json', $request);
            }
            $filter_order = Cache::remember('data_filter_order_lengkap_'.Fungsi::dataOfCek(), 10000, function(){
                return DB::table('t_filter_order')->where('data_of', Fungsi::dataOfCek())->get();
            });
            $data = [];
            $no = 0;
            foreach (Fungsi::genArray($filter_order) as $row ) {
                $data[$no++] = [
                    '',
                    $row->nama_filter,
                    "<button type='button' data-target='#filterMod' data-toggle='modal' class='btn btn-warning btn-xs' onClick='$(this).editFilter_order()' data-id='".$row->id_filter_order."'>Edit</button>
                    <button type='button' class='btn btn-danger btn-xs' onClick='$(this).hapusFilter_order(tabelDataFilterOrder)' data-id='".$row->id_filter_order."'>Hapus</button>",
                ];
            }
            $result['data'] = $data;
            return Fungsi::respon($result, [], 'json', $request);
        } else {
            abort(404);
        }
    }

    public function getPaymentData(Request $request){
        if($request->ajax()){
            if(isset($request->v)){
                $bank = DB::table('t_bank')
                    ->where('t_bank.id_bank', $request->v)
                    ->where('t_bank.data_of', Fungsi::dataOfCek())
                    ->get()->first();
                return Fungsi::respon($bank, [], 'json', $request);
            }
            $bank = Cache::remember('data_bank_lengkap_'.Fungsi::dataOfCek(), 10000, function(){
                return DB::table('t_bank')->where('data_of', Fungsi::dataOfCek())->get();
            });
            $data = [];
            $no = 0;
            foreach (Fungsi::genArray($bank) as $row) {
                $data[$no] = [
                    '',
                    $row->bank,
                    $row->no_rek,
                    $row->atas_nama,
                    "<button type='button' data-target='#updatePayment' data-toggle='modal' class='btn btn-warning btn-xs' onClick='$(this).updatePayment()' data-id='".$row->id_bank."'>Edit</button>
                    <button type='button' class='btn btn-danger btn-xs' onClick='$(this).hapusPayment(tabelDataPayment)' data-id='".$row->id_bank."'>Hapus</button>",
                ];
                $no++;
            }
            $result['data'] = $data;
            return Fungsi::respon($result, [], 'json', $request);
        } else {
            abort(404);
        }
    }
    
    public function getDataUsers(Request $request){
        // if($request->ajax()){
            if(isset($request->v)){
                $users = DB::table('t_user_meta')
                    ->join('users', 'users.id', '=', 't_user_meta.user_id')
                    ->where('t_user_meta.data_of', Fungsi::dataOfCek())
                    ->where('users.id', $request->v)
                    ->select('users.*', 't_user_meta.role', 't_user_meta.ijin')
                    ->get()->first();
                return Fungsi::respon($users, [], 'json', $request);
            }
            $users = Cache::remember('data_user_pengaturan_'.Fungsi::dataOfCek(), 10000, function(){
                return DB::table('t_user_meta')
                    ->join('users', 'users.id', '=', 't_user_meta.user_id')
                    ->where('t_user_meta.data_of', Fungsi::dataOfCek())
                    ->select('users.*', 't_user_meta.role', 't_user_meta.ijin')
                    ->get();
            });
            $data = [];
            $no = 0;
            // dd($users);
            foreach (Fungsi::genArray($users) as $row ) {
                if($row->role != "Supplier" && $row->role != "SuperAdmin"){
                    $jumlah = 0;
                    if(!is_null($row->ijin)){
                        $ijin = json_decode($row->ijin);
                        foreach(Fungsi::genArray($ijin) as $ij){
                            $jumlah += (int)$ij;
                        }
                    }
                    $data[$no++] = [
                        '',
                        $row->name,
                        $row->email,
                        $row->role,
                        "<span class='badge badge-info badge-round'>".$jumlah." &nbsp;&nbsp;Akses</span>",
                        "<button type='button' data-target='#editUser' data-toggle='modal' class='btn btn-warning btn-xs' data-id='".$row->id."' onClick='$(this).editUser(tableDataUser)'>Edit</button>
                        <button type='button' class='btn btn-danger btn-xs' data-id='".$row->id."' onClick='$(this).hapusUser(tableDataUser)'>Hapus</button>",
                    ];
                }
            }
            $result['data'] = $data;
            return Fungsi::respon($result, [], "json", $request);
        // } else {
        //     abort(404);
        // }
    }

}
