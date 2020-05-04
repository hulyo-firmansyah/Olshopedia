<?php

namespace App\Http\Controllers\depan\auth;

use App\User;
use Illuminate\Http\Request;
use App\Mail\EmailVerification;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\PusatController as Fungsi;

class AccountVerifiedController extends Controller
{
    public function verified($domain_toko, $token)
    {
        $user = DB::table('users')
			->where('email_token', $token)
			->update([
				'email_verified_at' => date("Y-m-d H:i:s"),
				'email_token' => null,
            ]);

        if ($user) {
            return redirect(route('d.login', ['domain_toko' => $domain_toko]))->with('sukses', 'Your Email address has been succesfully verified.');
        } else {
            return redirect(route('d.login', ['domain_toko' => $domain_toko]))->with('error', 'Your Token Email Verification is invalid!');
        }
    }

    public function resendMail(Request $request, $domain_toko)
    {
		$toko = DB::table('t_store')
            ->where('domain_toko', $domain_toko)
            ->get()->first();
        if(isset($toko)){
            $user = User::where('email_token', $request->token)->first();
            if(isset($user)){
                // Mail::to($user->email)->send(new EmailVerification($user, route('b.email-verified', ['token' => $user->email_token])));
                try {
    
                    // Log::info('mau mengirim email queue');
                    Mail::to($user->email)->send(new EmailVerification($user, route('d.email-verified', [
                        'domain_toko' => $domain_toko,
                        'token' => $user->email_token
                        ]), [
                            'tipe' => 'depan',
                            'tema' => $toko->template
                        ]));
                    // dispatch(new SendEmail([
                    //     'tujuan' => $user->email,
                    //     'email' => new EmailVerification($user, route('b.email-verified', ['token' => $user->email_token]))
                    // ]));
                    // Log::info('selesai mengirim email queue');
        
                } catch(\Exception $e){
                    return Fungsi::respon([
                        'status' => false,
                        'msg' => $e->getMessage()
                    ], [], 'json', $request);
                }

                return Fungsi::respon(['status' => true], [], 'json', $request);
            } else {
                return Fungsi::respon([
                    'status' => false,
                    'msg' => 'Gagal mengirim ulang email verifikasi!'
                ], [], 'json', $request);
            }
        } else {
            //landing page
        }
    }
}
