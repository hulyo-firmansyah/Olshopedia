<?php

namespace App\Http\Controllers\depan\auth;

use App\User;
// use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\EmailVerification;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
// use Illuminate\Support\Facades\Log;
use App\Jobs\SendEmail;
// use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Http\Controllers\PusatController as Fungsi;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        // $this->middleware('b.guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:50',
            'email' => 'required|string|email|max:70|unique:users',
            'no_telp' => 'required|string|min:5|max:25|unique:users',                                    
            'password' => 'required|string|min:6|confirmed',
            'terms' => 'required|accepted',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'no_telp' => $data['no_telp'],
            'password' => bcrypt($data['password']),
            'email_token' => str_random(45),
        ]);
        return $user;
    }
	 
    public function showRegistrationForm(Request $request, $toko_slug)
    {
		$toko = DB::table('t_store')
            ->where('domain_toko', $toko_slug)
            ->get()->first();
        $r['sort'] = strip_tags($request->sort);
        $r['cari'] = strip_tags($request->q);
		return Fungsi::respon('depan.'.$toko->template.'.auth.register', compact('toko', 'r'), "html", $request);
    }

	
    public function register(Request $request, $domain_toko)
    {
        $this->validator($request->all())->validate();
        $user = $this->create($request->all());
        try {

            // Log::info('mau mengirim email queue');
            Mail::to($user->email)->send(new EmailVerification($user, route('d.email-verified', [
                'domain_toko' => $domain_toko,
                'token' => $user->email_token
                ]), 'depan'));
            // dispatch(new SendEmail([
            //     'tujuan' => $user->email,
            //     'email' => new EmailVerification($user, route('b.email-verified', ['token' => $user->email_token]))
            // ]));
            // Log::info('selesai mengirim email queue');

        } catch(\Exception $e){
            DB::table('users')
                ->where('id', $user->id)
                ->delete();
            return redirect(route('d.register', ['domain_toko' => $domain_toko]))->with('error', $e->getMessage());
        }

        return $this->registered($request, $user)
                    ?: redirect(route('b.login'))
                        ->with('success', 'We sent you an activation code. Check your email and click on the link to verify, Didn\'t receive email <a href="javascript:void(0);" class="text-reset resendMail">resend mail</a>.')
                        ->with('user_token', $user->email_token);
    }

    
}
