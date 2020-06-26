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
        $data_of = Fungsi::dataOfCek();
        $cekAddon = Cache::remember('data_addons_'.$data_of, 30000, function() use($data_of){
            return DB::table('t_addons')
                ->where('data_of', $data_of)
                ->get()->first();
        });
        if(Cache::has('notif-email-test-'.$data_of.'-timer')){
            $timer = Cache::get('notif-email-test-'.$data_of.'-timer');
            $timer_email = $timer['time'] - (time() - $timer['start']);
            $timer_email = $timer_email < 0 ? 0 : $timer_email;
        } else {
            $timer_email = 0;
        }
        if(Cache::has('notif-wa-test-'.$data_of.'-timer')){
            $timer = Cache::get('notif-wa-test-'.$data_of.'-timer');
            $timer_wa = $timer['time'] - (time() - $timer['start']);
            $timer_wa = $timer_wa < 0 ? 0 : $timer_wa;
        } else {
            $timer_wa = 0;
        }
        if($request->ajax()){
            return Fungsi::respon('belakang.addons.index', compact('cekAddon', 'timer_wa', 'timer_email'), "ajax", $request);
        }
        return Fungsi::respon('belakang.addons.index', compact('cekAddon', 'timer_wa', 'timer_email'), "html", $request);
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
            $data_of = Fungsi::dataOfCek();
            $cekAddon = Cache::remember('data_addons_'.$data_of, 30000, function() use($data_of){
                return DB::table('t_addons')
                    ->where('data_of', $data_of)
                    ->get()->first();
            });
            $addonData = Cache::remember('data_addons_data_notif_resi_email_'.$data_of, 30000, function() use($data_of){
                $data = DB::table('t_addons_data')
                    ->where('data_of', $data_of)
                    ->get()->first();
                if(isset($data)){
                    return $data->notif_resi_email ? unserialize($data->notif_resi_email) : null;
                } else {
                    return null;
                }
            });
            
            if($cekAddon->notif_resi_email === 1){
                
                if(Cache::has('notif-email-test-'.$data_of.'-timer')){
                    $timer = Cache::get('notif-email-test-'.$data_of.'-timer');
                    $timer_email_cek = $timer['time'] - (time() - $timer['start']);
                    if($timer_email_cek > 0) {
                        return Fungsi::respon([
                            'status' => -1,
                            'msg' => 'Tunggu hingga cooldown selesai, untuk mengirim pesan test lagi!',
                            'timer' => $timer_email_cek
                        ], [], 'json', $request);
                    }
                }

                $email = strip_tags($request->email);
                $nama_toko = DB::table('t_store')
                    ->where('data_of', $data_of)
                    ->get()->first()->nama_toko;
                $emailFrom = DB::table('users')
                    ->where('id', $data_of)
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

                    if(Cache::has('notif-email-test-'.$data_of.'-timer')){
                        $timer['time'] = Cache::get('notif-email-test-'.$data_of.'-timer')['time'] * 2;
                        $timer['start'] = time();
                        Cache::put('notif-email-test-'.$data_of.'-timer', $timer, $timer['time']);
                    } else {
                        $timer['time'] = 240;
                        $timer['start'] = time();
                        Cache::add('notif-email-test-'.$data_of.'-timer', $timer, $timer['time']);
                    }

                    return Fungsi::respon([
                        'status' => 1, 
                        'msg' => 'Berhasil mengirim Email Test!',
                        'timer' => $timer['time']
                    ], [], 'json', $request);
                    // dispatch(new SendEmail([
                    //     'tujuan' => $user->email,
                    //     'email' => new EmailVerification($user, route('b.email-verified', ['token' => $token_gen]))
                    // ]));

                } catch(\Exception $e){
                    return Fungsi::respon(['status' => 0, 'msg' => $e->getMessage()], [], 'json', $request);
                }

            } else {
                return Fungsi::respon(['status' => 0, 'msg' => 'Notifikasi Resi via Email tidak diaktifkan!'], [], 'json', $request);
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
            $data_of = Fungsi::dataOfCek();
            $cekAddon = Cache::remember('data_addons_'.$data_of, 30000, function() use($data_of){
                return DB::table('t_addons')
                    ->where('data_of', $data_of)
                    ->get()->first();
            });
            $objNotifWa = new AddonNotifWa($data_of);

            if($cekAddon->notif_wa === 1 && !$objNotifWa->isDataNull()){
                
                if(Cache::has('notif-wa-test-'.$data_of.'-timer')){
                    $timer = Cache::get('notif-wa-test-'.$data_of.'-timer');
                    $timer_wa_cek = $timer['time'] - (time() - $timer['start']);
                    if($timer_wa_cek > 0) {
                        return Fungsi::respon([
                            'status' => -1,
                            'msg' => 'Tunggu hingga cooldown selesai, untuk mengirim pesan test lagi!',
                            'timer' => $timer_wa_cek
                        ], [], 'json', $request);
                    }
                }

                $no = strip_tags($request->no);
                
                $response = $objNotifWa->kirim(Fungsi::cekPlus($no), "Testing..\n\nBerhasil terkirim pada ".date('Y-m-d H:i:s'));

                if($response['status'] === true){
                    if(Cache::has('notif-wa-test-'.$data_of.'-timer')){
                        $timer['time'] = Cache::get('notif-wa-test-'.$data_of.'-timer')['time'] * 2;
                        $timer['start'] = time();
                        Cache::put('notif-wa-test-'.$data_of.'-timer', $timer, $timer['time']);
                    } else {
                        $timer['time'] = 60;
                        $timer['start'] = time();
                        Cache::add('notif-wa-test-'.$data_of.'-timer', $timer, $timer['time']);
                    }
                    return Fungsi::respon([
                        'status' => 1, 
                        'msg' => 'Berhasil mengirim Test Notifikasi Whatsapp!',
                        'timer' => $timer['time']
                    ], [], 'json', $request);
                } else {
                    return Fungsi::respon([
                        'status' => 0,
                        'msg' => $response['data']
                    ], [], 'json', $request);
                }
	
            } else {
                return Fungsi::respon([
                    'status' => 0, 
                    'msg' => 'Notifikasi Whatsapp tidak diaktifkan!'
                ], [], 'json', $request);
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