<?php
namespace App\Http\Controllers\belakang;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use App\Mail\NotifResiEmailAddon;
use Swift_Mailer;
use Swift_SmtpTransport;
use App\Http\Controllers\PusatController as Fungsi;
use App\Helpers\AddonNotifWa;

class AddonsController extends Controller
{

	public function __construct(){
		$this->middleware(['b.auth', 'b.locale', 'xss_protect', 'b.cekOwner']);
    }

    public function index(Request $request){
        $cekAddon = Cache::remember('data_addons_'.Fungsi::dataOfCek(), 30000, function(){
            return DB::table('t_addons')
                ->where('data_of', Fungsi::dataOfCek())
                ->get()->first();
        });
        // dd($cekAddon);
        if($request->ajax()){
            return Fungsi::respon('belakang.addons.index', compact('cekAddon'), "ajax", $request);
        }
        return Fungsi::respon('belakang.addons.index', compact('cekAddon'), "html", $request);
    }

    public function simpanNotifResiEmail(Request $request){
        $cekAddon = Cache::remember('data_addons_'.Fungsi::dataOfCek(), 30000, function(){
            return DB::table('t_addons')
                ->where('data_of', Fungsi::dataOfCek())
                ->get()->first();
        });
        $data = [];
        if($cekAddon->notif_resi_email === 1){
            if(isset($request->smtp_password)){
                $data['smtp']['password'] = encrypt(strip_tags($request->smtp_password));
            } else {
                $addonData = Cache::remember('data_addons_data_notif_resi_email_'.Fungsi::dataOfCek(), 30000, function(){
                    $data = DB::table('t_addons_data')
                        ->where('data_of', Fungsi::dataOfCek())
                        ->get()->first();
                    if(isset($data)){
                        return $data->notif_resi_email ? unserialize($data->notif_resi_email) : null;
                    } else {
                        return null;
                    }
                });
                $data['smtp']['password'] = $addonData['smtp']['password'];
            }
        } else {
            if(isset($request->smtp_password)){
                $data['smtp']['password'] = encrypt(strip_tags($request->smtp_password));
            } else {
                $addonData = Cache::remember('data_addons_data_notif_resi_email_'.Fungsi::dataOfCek(), 30000, function(){
                    $data = DB::table('t_addons_data')
                        ->where('data_of', Fungsi::dataOfCek())
                        ->get()->first();
                    if(isset($data)){
                        return $data->notif_resi_email ? unserialize($data->notif_resi_email) : null;
                    } else {
                        return null;
                    }
                });
                $data['smtp']['password'] = $addonData['smtp']['password'];
            }
        }
        if(isset($request->aktifData) && $request->aktifData == 'on'){
            DB::table('t_addons')
                ->where('data_of', Fungsi::dataOfCek())
                ->update([
                    'notif_resi_email' => 1
                ]);
        } else {
            DB::table('t_addons')
                ->where('data_of', Fungsi::dataOfCek())
                ->update([
                    'notif_resi_email' => 0
                ]);
        }
        $data['smtp']['hostname'] = strip_tags($request->smtp_hostname);
        $data['smtp']['port'] = (int)strip_tags($request->smtp_port);
        $data['smtp']['security'] = strip_tags($request->smtp_security);
        $data['smtp']['username'] = strip_tags($request->smtp_username);
        if($request->tipePesan == 'plain'){
            $pesan = strip_tags(htmlentities($request->pesan));
            $cekData = DB::table('t_addons_data')
                ->where('data_of', Fungsi::dataOfCek())
                ->get()->first();
            $data['tipe'] = 'plain';
            $data['pesan'] = $pesan;
            if(isset($cekData)){
                DB::table('t_addons_data')
                    ->where('data_of', Fungsi::dataOfCek())
                    ->update([
                        'notif_resi_email' => serialize($data)
                    ]);
            } else {
                DB::table('t_addons_data')
                    ->insert([
                        'notif_resi_email' => serialize($data),
                        'data_of' => Fungsi::dataOfCek()
                    ]);
            }
        } else if($request->tipePesan == 'html'){
            $cekData = DB::table('t_addons_data')
                ->where('data_of', Fungsi::dataOfCek())
                ->get()->first();
            $data['tipe'] = 'html';
            $data['pesan'] = $request->pesan;
            if(isset($cekData)){
                DB::table('t_addons_data')
                    ->where('data_of', Fungsi::dataOfCek())
                    ->update([
                        'notif_resi_email' => serialize($data)
                    ]);
            } else {
                DB::table('t_addons_data')
                    ->insert([
                        'notif_resi_email' => serialize($data),
                        'data_of' => Fungsi::dataOfCek()
                    ]);
            }
        }
        Cache::forget('data_addons_'.Fungsi::dataOfCek());
        Cache::forget('data_addons_data_notif_resi_email_'.Fungsi::dataOfCek());
        return redirect()->route('b.addons-index')->with([
            'msg_success' => 'Berhasil menyimpan settingan Notifikasi Resi via Email'
        ]);
    }

    public function notifResiEmailIndex(Request $request){
        $cekAddon = Cache::remember('data_addons_'.Fungsi::dataOfCek(), 30000, function(){
            return DB::table('t_addons')
                ->where('data_of', Fungsi::dataOfCek())
                ->get()->first();
        });
        $addonData = Cache::remember('data_addons_data_notif_resi_email_'.Fungsi::dataOfCek(), 30000, function(){
            $data = DB::table('t_addons_data')
                ->where('data_of', Fungsi::dataOfCek())
                ->get()->first();
            if(isset($data)){
                return $data->notif_resi_email ? unserialize($data->notif_resi_email) : null;
            } else {
                return null;
            }
        });
        if($request->ajax()){
            return Fungsi::respon('belakang.addons.notif-resi-email', compact('cekAddon', 'addonData'), "ajax", $request);
        }
        return Fungsi::respon('belakang.addons.notif-resi-email', compact('cekAddon', 'addonData'), "html", $request);
    }

    public function kirimTestNotifResiEmail(Request $request){
        if($request->ajax()){
            $cekAddon = Cache::remember('data_addons_'.Fungsi::dataOfCek(), 30000, function(){
                return DB::table('t_addons')
                    ->where('data_of', Fungsi::dataOfCek())
                    ->get()->first();
            });
            $addonData = Cache::remember('data_addons_data_notif_resi_email_'.Fungsi::dataOfCek(), 30000, function(){
                $data = DB::table('t_addons_data')
                    ->where('data_of', Fungsi::dataOfCek())
                    ->get()->first();
                if(isset($data)){
                    return $data->notif_resi_email ? unserialize($data->notif_resi_email) : null;
                } else {
                    return null;
                }
            });
            
            if($cekAddon->notif_resi_email === 1){
                $email = strip_tags($request->email);
                $nama_toko = DB::table('t_store')
                    ->where('data_of', Fungsi::dataOfCek())
                    ->get()->first()->nama_toko;
                $emailFrom = DB::table('users')
                    ->where('id', Fungsi::dataOfCek())
                    ->get()->first()->email;
                
                try {

                    // Backup your default mailer
                    $backup = Mail::getSwiftMailer();
                    
                    // Setup your gmail mailer
                    $transport = new Swift_SmtpTransport($addonData['smtp']['hostname'], $addonData['smtp']['port'], (!is_null($addonData['smtp']['security']) ? $addonData['smtp']['security'] : null));
                    $transport->setUsername($addonData['smtp']['username']);
                    $transport->setPassword(trim(decrypt($addonData['smtp']['password'])));
                    // Any other mailer configuration stuff needed...
                    
                    $gmail = new Swift_Mailer($transport);
                    
                    // Set the mailer as gmail
                    Mail::setSwiftMailer($gmail);

                    // Send your message
                    Mail::to($email)->send(new NotifResiEmailAddon([
                        'alamat' => $emailFrom,
                        'nama' => $nama_toko
                    ], 'plain', 'testing'));
                    
                    // Restore your original mailer
                    Mail::setSwiftMailer($backup);

                    return Fungsi::respon(['status' => true, 'msg' => 'Berhasil mengirim Email Test!'], [], 'json', $request);
                    // dispatch(new SendEmail([
                    //     'tujuan' => $user->email,
                    //     'email' => new EmailVerification($user, route('b.email-verified', ['token' => $token_gen]))
                    // ]));

                } catch(\Exception $e){
                    return Fungsi::respon(['status' => false, 'msg' => $e->getMessage()], [], 'json', $request);
                }

            } else {
                return Fungsi::respon(['status' => false, 'msg' => 'Notifikasi Resi via Email tidak diaktifkan!'], [], 'json', $request);
            }
        } else {
            abort(404);
        }
    }

    public function notifWaIndex(Request $request){
        $cekAddon = Cache::remember('data_addons_'.Fungsi::dataOfCek(), 30000, function(){
            return DB::table('t_addons')
                ->where('data_of', Fungsi::dataOfCek())
                ->get()->first();
        });
        $addonData = Cache::remember('data_addons_data_notif_wa_'.Fungsi::dataOfCek(), 30000, function(){
            $data = DB::table('t_addons_data')
                ->where('data_of', Fungsi::dataOfCek())
                ->get()->first();
            if(isset($data)){
                return $data->notif_wa ? unserialize($data->notif_wa) : null;
            } else {
                return null;
            }
        });
        // dd($addonData);
        if($request->ajax()){
            return Fungsi::respon('belakang.addons.notif-wa', compact('cekAddon', 'addonData'), "ajax", $request);
        }
        return Fungsi::respon('belakang.addons.notif-wa', compact('cekAddon', 'addonData'), "html", $request);
    }

    public function kirimTestNotifWa(Request $request){
        if($request->ajax()){
            $cekAddon = Cache::remember('data_addons_'.Fungsi::dataOfCek(), 30000, function(){
                return DB::table('t_addons')
                    ->where('data_of', Fungsi::dataOfCek())
                    ->get()->first();
            });
            $objNotifWa = new AddonNotifWa(Fungsi::dataOfCek());

            if($cekAddon->notif_wa === 1 && !$objNotifWa->isDataNull()){
                $no = strip_tags($request->no);
                
                $response = $objNotifWa->kirim(Fungsi::cekPlus($no), "Testing..\n\nBerhasil terkirim pada ".date('Y-m-d H:i:s'));

                if($response['status'] === true){
                    return Fungsi::respon(['status' => true, 'msg' => 'Berhasil mengirim Test Notifikasi Whatsapp!'], [], 'json', $request);
                } else {
                    return Fungsi::respon(['status' => false, 'msg' => $response['data']], [], 'json', $request);
                }
	
            } else {
                return Fungsi::respon(['status' => false, 'msg' => 'Notifikasi Whatsapp tidak diaktifkan!'], [], 'json', $request);
            }
        } else {
            abort(404);
        }
    }

    public function simpanNotifWa(Request $request){
        // return "<pre>".print_r($request->all(), true)."</pre>";
        if(isset($request->aktifData) && $request->aktifData == 'on'){
            DB::table('t_addons')
                ->where('data_of', Fungsi::dataOfCek())
                ->update([
                    'notif_wa' => 1
                ]);
        } else {
            DB::table('t_addons')
                ->where('data_of', Fungsi::dataOfCek())
                ->update([
                    'notif_wa' => 0
                ]);
        }
        $data['key'] = strip_tags($request->api_key);
        $data['resi_update']['aktif'] = isset($request->notifWa_resiUpdate) && $request->notifWa_resiUpdate == 'on' ? true : false;
        $data['resi_update']['tmp'] = strip_tags($request->notifWa_resiUpdate_tmp);
        $cekData = DB::table('t_addons_data')
            ->where('data_of', Fungsi::dataOfCek())
            ->get()->first();
        if(isset($cekData)){
            DB::table('t_addons_data')
                ->where('data_of', Fungsi::dataOfCek())
                ->update([
                    'notif_wa' => serialize($data)
                ]);
        } else {
            DB::table('t_addons_data')
                ->insert([
                    'notif_wa' => serialize($data),
                    'data_of' => Fungsi::dataOfCek()
                ]);
        }
        Cache::forget('data_addons_'.Fungsi::dataOfCek());
        Cache::forget('data_addons_data_notif_wa_'.Fungsi::dataOfCek());
        return redirect()->route('b.addons-index')->with([
            'msg_success' => 'Berhasil menyimpan settingan Notifikasi Whatsapp'
        ]);
    }
}