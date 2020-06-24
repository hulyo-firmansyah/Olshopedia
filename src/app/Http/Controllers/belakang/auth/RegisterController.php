<?php

namespace App\Http\Controllers\belakang\auth;

use App\User;
use Illuminate\Support\Str;
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
    protected $redirectTo = '/login';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('b.guest');
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
            'name' => 'required|string|max:191',
            'username' => 'required|string|max:30|unique:users',
            'email' => 'required|string|email|max:191|unique:users',
            'no_telp' => 'required|string|max:20|unique:users',                                    
            'password' => 'required|string|min:6|confirmed',
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
            'username' => $data['username'],
            'email' => $data['email'],
            'no_telp' => $data['no_telp'],
            'password' => bcrypt($data['password']),
            'email_token' => Str::random(40),
        ]);
        return $user;
    }
	
    public function showRegistrationForm(Request $request)
    {
        // return view('belakang.auth.register');
		return Fungsi::respon('belakang.auth.register', [], "html", $request);
    }

    
    protected function registered(Request $request, $user)
    {
        DB::table('t_store')->insert([
            'data_of' => $user->id,
            'kat_customer' => '{"customer":{"grosir":1,"diskon":1},"dropshipper":{"grosir":1,"diskon":1},"reseller":{"grosir":1,"diskon":1}}',
            'cek_ongkir' => '{"jne":1,"pos":1,"tiki":1,"pcp":0,"esl":0,"rpx":0,"pandu":0,"wahana":0,"sicepat":1,"jnt":1,"pahala":0,"sap":0,"jet":1,"slis":0,"dse":0,"first":0,"ncs":0,"star":0,"lion":0,"ninja":0,"idl":0,"rex":0,"indah":0,"cahaya":0}'
        ]);
        DB::table("t_user_meta")->insert([
            "user_id" => $user->id,
            "ijin" => null,
            "role" => "Owner",
            "data_of" => null
        ]);
        DB::table("t_addons")->insert([
            "notif_resi_email" => false,
            "data_of" => $user->id
        ]);
    }
	
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();
        $user = $this->create($request->all());
        // event(new Registered($user = $this->create($request->all())));

        // $this->guard()->login($user);
        try {

            // Log::info('mau mengirim email queue');
            Mail::to($user->email)->send(new EmailVerification($user, route('b.email-verified', ['token' => $user->email_token])));
            // dispatch(new SendEmail([
            //     'tujuan' => $user->email,
            //     'email' => new EmailVerification($user, route('b.email-verified', ['token' => $user->email_token]))
            // ]));
            // Log::info('selesai mengirim email queue');
            // dd('c');

        } catch(\Exception $e){
            DB::table('users')
                ->where('id', $user->id)
                ->delete();
            return redirect(route('b.register'))->with('error', $e->getMessage());
        }

        return $this->registered($request, $user)
                    ?: redirect($this->redirectPath())
                        ->with('success', __('register-form.sukses-kirim-kode').'<a href="javascript:void(0);" class="text-reset resendMail">'.__('register-form.sukses-link-resend').'</a>.')
                        ->with('user_token', $user->email_token);
    }
}
