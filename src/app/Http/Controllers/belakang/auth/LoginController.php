<?php

namespace App\Http\Controllers\belakang\auth;

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
        $this->middleware('b.guest')->except('logout');
    }
	
    public function showLoginForm(Request $request)
    {
		// return view('belakang.auth.login');
		return Fungsi::respon('belakang.auth.login', [], "html", $request);
    }
	
	
    public function logout(Request $request)
    {
        event(new BelakangLogging(Fungsi::dataOfCek(), 'logout', Auth::user()->id));
        $this->guard()->logout();

        $request->session()->invalidate();

        return redirect('/login');
    }
    
    protected function credentials(Request $request)
    {
        if(filter_var($request->get($this->username()), FILTER_VALIDATE_EMAIL)){
            $field = $this->username();
        } else if(is_numeric($request->get($this->username()))){
            $field = "no_telp";
        } else {
            $field = "username";
        }
        return [
            $field => $request->get($this->username()),
            'password' => $request->password,
        ];
    }
	
	
    public function authenticated(Request $request, $user)
    {
        $data_verif = DB::table('users')
                ->where('id', $user->id)
                ->select('email_verified_at', 'email_token')
                ->get()->first();
                // dd($data_verif);
        if(is_null($data_verif->email_verified_at)) {
            auth()->logout();
            if(is_null($data_verif->email_token)){
                $token_gen = \Str::random(40);
                $data_verif_edit = DB::table('users')->where('id', $user->id)->update(['email_token' => $token_gen]);
                Mail::to($user->email)->send(new EmailVerification($user, route('b.email-verified', ['token' => $token_gen])));
                // dispatch(new SendEmail([
                //     'tujuan' => $user->email,
                //     'email' => new EmailVerification($user, route('b.email-verified', ['token' => $token_gen]))
                // ]));
            }
            return back()->with('warning', 'You need to confirm your account. We have sent you an activation code, please check your email.');
        }
        $role_tipe = DB::table('t_user_meta')
                ->where('user_id', $user->id)
                ->select('role')
                ->get()->first();
        if($role_tipe->role != 'Admin' && $role_tipe->role != 'Owner'){
            auth()->logout();
            return back()->with('warning', 'Hanya bisa diakses oleh admin atau owner');
        }
        event(new BelakangLogging(Fungsi::dataOfCek(), 'login', $user));
        return redirect()->intended($this->redirectPath());
    }
}
