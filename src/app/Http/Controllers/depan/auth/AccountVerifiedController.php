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
    public function verified($domain_toko, $toko)
    {
        $user = DB::table('users')
			->where('email_token', $token)
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
        Mail::to($user->email)->send(new EmailVerification($user, route('b.email-verified', ['token' => $user->email_token])));
        return Fungsi::respon(['sukses' => true], [], 'json', $request);
    }
}
