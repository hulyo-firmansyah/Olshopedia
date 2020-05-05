<?php

namespace App\Http\Controllers\depan\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Mail\EmailVerification;
use Illuminate\Support\Facades\Auth;
use App\Events\BelakangLogging;
use Illuminate\Support\Facades\Mail;
use App\Jobs\SendEmail;
use App\Http\Controllers\PusatController as Fungsi;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('d.guest')->except('logout');
        $this->middleware('cek_toko_domain');
    }
	
    public function showLoginForm(Request $request, $domain_toko)
    {
		$toko = DB::table('t_store')
            ->where('domain_toko', $domain_toko)
            ->get()->first();
        $r['sort'] = strip_tags($request->sort);
        $r['cari'] = strip_tags($request->q);
		return Fungsi::respon('depan.'.$toko->template.'.auth.login', compact('toko', 'r'), "html", $request);
    }

    public function login(Request $request, $domain_toko)
    {
		$toko = DB::table('t_store')
            ->where('domain_toko', $domain_toko)
            ->get()->first();
            // dd($request->all());
        if(isset($toko)){
            $this->validateLogin($request);

            if (method_exists($this, 'hasTooManyLoginAttempts') &&
                $this->hasTooManyLoginAttempts($request)) {
                $this->fireLockoutEvent($request);

                return $this->sendLockoutResponse($request);
            }

            if ($this->attemptLogin($request)) {
                return $this->sendLoginResponse($request, $domain_toko);
            }

            $this->incrementLoginAttempts($request);

            return $this->sendFailedLoginResponse($request);
        } else {
            //landing page
        }
    }

    protected function sendLoginResponse(Request $request, $domain_toko)
    {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        return $this->authenticated($request, $this->guard()->user(), $domain_toko)
                ?: redirect()->intended($this->redirectPath());
    }
	
    public function logout(Request $request, $domain_toko)
    {
        // event(new BelakangLogging(Fungsi::dataOfCek(), 'logout', Auth::user()->id));
        $this->guard()->logout();

        $request->session()->invalidate();

        return redirect()->route('d.home', ['domain_toko' => $domain_toko]);
    }
    
    protected function credentials(Request $request)
    {
        return [
            'email' => $request->email,
            'password' => $request->password,
        ];
    }
	
	
    public function authenticated(Request $request, $user, $domain_toko)
    {
		$toko = DB::table('t_store')
            ->where('domain_toko', $domain_toko)
            ->get()->first();
        $data_verif = DB::table('users')
                ->where('id', $user->id)
                ->select('email_verified_at', 'email_token')
                ->get()->first();
                // dd($data_verif);
        if(is_null($data_verif->email_verified_at)) {
            auth()->logout();
            if(is_null($data_verif->email_token)){
                $token_gen = str_random(45);
                $data_verif_edit = DB::table('users')->where('id', $user->id)->update(['email_token' => $token_gen]);
                // Mail::to($user->email)->send(new EmailVerification($user, route('d.email-verified', ['token' => $token_gen]), 'depan'));
                // dispatch(new SendEmail([
                //     'tujuan' => $user->email,
                //     'email' => new EmailVerification($user, route('b.email-verified', ['token' => $token_gen]))
                // ]));
                try {

                    // Log::info('mau mengirim email queue');
                    Mail::to($user->email)->send(new EmailVerification($user, route('d.email-verified', [
                        'domain_toko' => $domain_toko,
                        'token' => $token_gen
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
                    DB::table('users')
                        ->where('id', $user->id)
                        ->delete();
                    DB::table('t_customer')
                        ->where('user_id', $user->id)
                        ->delete();
                    return redirect(route('d.login', ['domain_toko' => $domain_toko]))->with('error', $e->getMessage());
                }
            }
            return back()->with('warning', 'You need to confirm your account. We have sent you an activation code, please check your email.');
        }
        return redirect()->route('d.home', ['domain_toko' => $domain_toko]);
    }
}
