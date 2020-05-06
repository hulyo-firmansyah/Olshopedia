<?php

namespace App\Http\Controllers\belakang\auth;

use App\User;
use Illuminate\Http\Request;
use App\Mail\EmailVerification;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\PusatController as Fungsi;

class AccountVerifiedController extends Controller
{
    public function verified($token)
    {
        $user = DB::table('users')
			->where('email_token',$token)
			->update([
				'email_verified_at' => date("Y-m-d H:i:s"),
				'email_token' => null,
            ]);

        if ($user) {
            return redirect(route('b.login'))->with('success', 'Your Email address has been succesfully verified.');
        } else {
            return redirect(route('b.login'))->with('error', 'Your Token Email Verification is invalid!');
        }
    }

    public function resendMail(Request $request)
    {
        $user = User::where('email_token', $request->token)->first();
        if(isset($user)){
            try {
                
                // Log::info('mau mengirim email queue');
                Mail::to($user->email)->send(new EmailVerification($user, route('b.email-verified', ['token' => $user->email_token])));
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

            return Fungsi::respon(['sukses' => true], [], 'json', $request);
        } else {
            return Fungsi::respon([
                'status' => false,
                'msg' => 'Data User dengan email tersebut tidak ada!'
            ], [], 'json', $request);
        }

    }
}
