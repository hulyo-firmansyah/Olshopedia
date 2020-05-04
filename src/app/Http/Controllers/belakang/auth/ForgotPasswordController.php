<?php

namespace App\Http\Controllers\belakang\auth;

use App\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\ForgotPassword;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Jobs\SendEmail;
use App\Http\Controllers\PusatController as Fungsi;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('guest');
    }

    public function showLinkRequestForm(Request $request)
    {
        return Fungsi::respon('belakang.auth.passwords.email', [], 'html', $request);
    }

    /**
     * Send a reset link to the given user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function passMailSend(Request $request)
    {
        $user = User::where('email', $request->email)
            ->get()->first();
        if ($user) {
            $token = Str::random(40);
            $data_user = DB::table('password_resets')
                ->insert([
                    'email' => $user->email,
                    'token' => $token,
                    'created_at' => date('Y-m-d H:i:s')
                ]);
            // dispatch(new SendEmail([
            //     'tujuan' => $user->email,
            //     'email' => new ForgotPassword($user, route('b.password-resetPass', [
            //         'mail' => urlencode($user->email), 
            //         'token' => $token
            //     ]))
            // ]));
            Mail::to($user->email)->send(new ForgotPassword($user, route('b.password-resetPass', [
                'mail' => urlencode($user->email), 
                'token' => $token
            ])));
            return Fungsi::respon([
                'status' => [
                    'data' => true,
                    'pesan' => "Email autentikasi berhasil dikirim, periksa email anda!"
                ],
                'email' => $user->email
            ], [], 'json', $request);
        } else if (is_null($user)) {
            return Fungsi::respon([
                'status' => [
                    'data' => false,
                    'pesan' => "Email yang anda masukkan belum terdaftar!"
                ],
                'email' => null
            ], [], 'json', $request);
        }
    }

    /*
     * Show form reset password
     */
    public function showFormResetPass(Request $request, $mail, $token)
    {
        $user_mail = strip_tags(urldecode($mail));
        $user_token = strip_tags($token);
        $user = DB::table('password_resets')
            ->where('email', $user_mail)
            ->get()->first();
        if(isset($user)){
            if($user->token == $user_token){
                return Fungsi::respon('belakang.auth.passwords.reset', compact('user_mail'), 'html', $request);
            } else {
                return redirect()
                    ->route('b.password-forgotPassword')
                    ->with([
                        'error_msg' => 'Token anda salah!'
                    ]);
            }
        } else {
            return redirect()
                ->route('b.password-forgotPassword')
                ->with([
                    'error_msg' => 'Email tersebut belum terdaftar!'
                ]);
        }
    }

    /*
    * Renew Password
    */
    public function renewPassword(Request $request)
    {
        $renewPass = DB::table('users')
            ->where('email', $request->email)
            ->update([
                "password" => bcrypt($request->newPass)
            ]);
        if ($renewPass) {
            $user_hapus = DB::table('password_resets')
                ->where('email', $request->email)
                ->delete();
            return Fungsi::respon([
                'status' => [
                    'data' => true,
                    'pesan' => "Password anda berhasil diubah"
                ],
            ], [], 'json', $request);
        }
    }
}
