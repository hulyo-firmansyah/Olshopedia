<?php

namespace App\Http\Controllers\depan\auth;

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
        $this->middleware(['d.guest', 'cek_toko_domain']);
    }

    public function showLinkRequestForm(Request $request, $domain_toko)
    {
		$toko = DB::table('t_store')
            ->where('domain_toko', $domain_toko)
            ->get()->first();
        if(isset($toko)){
            return Fungsi::respon('depan.'.$toko->template.'.auth.passwords.email', compact('toko'), 'html', $request);
        } else {
            //landing page
        }
    }

    /**
     * Send a reset link to the given user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function passMailSend(Request $request, $domain_toko)
    {
		$toko = DB::table('t_store')
            ->where('domain_toko', $domain_toko)
            ->get()->first();
        if(isset($toko)){

            $user = User::where('email', $request->email)
                ->get()->first();
            if ($user) {
                $token = Str::random(45);
                $cekUser = DB::table('password_resets')
                    ->where('email', $user->email)
                    ->get()->first();
                if(isset($cekUser)){
                    $data_user = DB::table('password_resets')
                        ->where('email', $user->mail)
                        ->update([
                            'token' => $token,
                            'created_at' => date('Y-m-d H:i:s')
                        ]);
                } else {
                    $data_user = DB::table('password_resets')
                        ->insert([
                            'email' => $user->email,
                            'token' => $token,
                            'created_at' => date('Y-m-d H:i:s')
                        ]);
                }
                // dispatch(new SendEmail([
                //     'tujuan' => $user->email,
                //     'email' => new ForgotPassword($user, route('b.password-resetPass', [
                //         'mail' => urlencode($user->email), 
                //         'token' => $token
                //     ]))
                // ]));
                try {
    
                    Mail::to($user->email)->send(new ForgotPassword($user, route('d.password-resetPass', [
                        'domain_toko' => $domain_toko, 
                        'mail' => urlencode($user->email), 
                        'token' => $token
                    ]), [
                        'tipe' => 'depan',
                        'tema' => $toko->template
                    ]));
    
                } catch(\Exception $e){
                    return Fungsi::respon([
                        'status' => [
                            'data' => false,
                            'pesan' => "".$e->getMessage()
                        ],
                        'email' => null
                    ], [], 'json', $request);
                }
    
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
        } else {
            //landing page
        }
    }

    /*
     * Show form reset password
     */
    public function showFormResetPass(Request $request, $domain_toko, $mail, $token)
    {
		$toko = DB::table('t_store')
            ->where('domain_toko', $domain_toko)
            ->get()->first();
        if(isset($toko)){
            // dd($mail, $token);
            if($mail !== '' && $token !== ''){
                $user_mail = strip_tags(urldecode($mail));
                $user_token = strip_tags($token);
                $user = DB::table('password_resets')
                    ->where('email', $user_mail)
                    ->get()->first();
                if(isset($user)){
                    if($user->token == $user_token){
                        return Fungsi::respon('depan.'.$toko->template.'.auth.passwords.reset', compact('user_mail', 'toko'), 'html', $request);
                    } else {
                        return redirect()
                            ->route('d.password-forgotPassword', ['domain_toko' => $domain_toko])
                            ->with([
                                'error_msg' => 'Token anda salah!'
                            ]);
                    }
                } else {
                    return redirect()
                        ->route('d.password-forgotPassword', ['domain_toko' => $domain_toko])
                        ->with([
                            'error_msg' => 'Email tersebut belum terdaftar!'
                        ]);
                }
            } else {
                return redirect()
                    ->route('d.password-forgotPassword', ['domain_toko' => $domain_toko])
                    ->with([
                        'error_msg' => 'Email dan Password tidak ditemukan!'
                    ]);
            }
        } else {
            //landing page
        }
    }

    /*
    * Renew Password
    */
    public function renewPassword(Request $request, $domain_toko)
    {
		$toko = DB::table('t_store')
            ->where('domain_toko', $domain_toko)
            ->get()->first();
        if(isset($toko)){
            $email = strip_tags($request->email);
            $cekUser = DB::table('users')
                ->where('email', $email)
                ->get()->first();
            if(isset($cekUser)){
                $pass = strip_tags($request->newPass);
                $re_pass = strip_tags($request->re_newPass);
                if(strcmp($pass, $re_pass) === 0){
                    $renewPass = DB::table('users')
                        ->where('email', $email)
                        ->update([
                            "password" => bcrypt($pass)
                        ]);
                    if($renewPass){
                        $user_hapus = DB::table('password_resets')
                            ->where('email', $request->email)
                            ->delete();
                        return Fungsi::respon([
                            'status' => [
                                'data' => true,
                                'pesan' => "Password anda berhasil diubah!"
                            ],
                        ], [], 'json', $request);
                    } else {
                        return Fungsi::respon([
                            'status' => [
                                'data' => false,
                                'pesan' => "Gagal mengubah password!"
                            ],
                        ], [], 'json', $request);
                    }
                } else {
                    return Fungsi::respon([
                        'status' => [
                            'data' => false,
                            'pesan' => "Password dan Password Konfirmasi tidak sama!"
                        ],
                    ], [], 'json', $request);
                }
            } else {
                return Fungsi::respon([
                    'status' => [
                        'data' => false,
                        'pesan' => "User dengan email tersebut tidak ada!"
                    ],
                ], [], 'json', $request);
            }
        } else {
            //landing page
        }
    }
}
