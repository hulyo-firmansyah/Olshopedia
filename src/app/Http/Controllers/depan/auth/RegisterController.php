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
	 
    public function showRegistrationForm(Request $request, $domain_toko)
    {
		$toko = DB::table('t_store')
            ->where('domain_toko', $domain_toko)
            ->get()->first();
        if(isset($toko)){
            $r['sort'] = strip_tags($request->sort);
            $r['cari'] = strip_tags($request->q);
            return Fungsi::respon('depan.'.$toko->template.'.auth.register', compact('toko', 'r'), "html", $request);
        } else {
            //landing page
        }
    }

	
    public function register(Request $request, $domain_toko)
    {
        $this->validator($request->all())->validate();
        $user = $this->create($request->all());
        return redirect(route('d.register-after', ['domain_toko' => $domain_toko]).'?v='.$user->id.'&i='.time().'&d='.str_random(6));
    }

    public function registerAfter(Request $request, $domain_toko){
		$toko = DB::table('t_store')
            ->where('domain_toko', $domain_toko)
            ->get()->first();
        if(isset($toko)){
            $r['sort'] = strip_tags($request->sort);
            $r['cari'] = strip_tags($request->q);
            if($request->v != '' && $request->i != '' && $request->d != ''){
                $requestData['v'] = strip_tags($request->v);
                $requestData['i'] = strip_tags($request->i);
                $requestData['d'] = strip_tags($request->d);
                $userData = DB::table('users')
                    ->where('id', $requestData['v'])
                    ->select('name', 'email', 'no_telp')
                    ->get()->first();
                $wilayah_indonesia = json_decode(Fungsi::getContent('data/wilayah_indonesia.json'));
                return Fungsi::respon('depan.'.$toko->template.'.auth.register-after', compact('toko', 'r', 'wilayah_indonesia', 'userData', 'requestData'), "html", $request);
            } else {
                return redirect(route('d.register', ['domain_toko' => $domain_toko]));
            }
        } else {
            //landing page
        }
    }

    public function registerProses(Request $request, $domain_toko){
        // dd($request->all(), $domain_toko);
		$toko = DB::table('t_store')
            ->where('domain_toko', $domain_toko)
            ->get()->first();
        if(isset($toko)){
            $data_['i'] = strip_tags($request->i);
            $data_['v'] = strip_tags($request->v);
            $data_['d'] = strip_tags($request->d);
            if($data_['i'] != '' && $data_['v'] != '' && $data_['d'] != ''){
                $data['no_telp'] = strip_tags($request->no_telp);
                $data['kode_pos'] = strip_tags($request->kode_pos);
                $data['provinsi'] = strip_tags($request->provinsi);
                $data['kabupaten'] = strip_tags($request->kabupaten);
                $data['kecamatan'] = strip_tags($request->kecamatan);
                $data['alamat'] = strip_tags($request->alamat);
                if(preg_match('/[^0-9]/', $data['no_telp']) || preg_match('/[^0-9]/', $data['kode_pos'])){
                    return redirect(route('d.register', ['domain_toko' => $domain_toko]));
                }
                $userData = DB::table('users')
                    ->where('id', $data_['v'])
                    ->select('no_telp')
                    ->get()->first();
                if(isset($userData)){
                    $dataNo = DB::table('users')
                        ->where('id', $data_['v'])
                        ->update([
                            'no_telp' => $data['no_telp']
                        ]);
                    $insert = DB::table('t_customer')
                        ->insert([
                            'user_id' => $data_['v'],
                            'provinsi' => $data['provinsi'],
                            'kabupaten' => $data['kabupaten'],
                            'kecamatan' => $data['kecamatan'],
                            'alamat' => $data['alamat'],
                            'kode_pos' => $data['kode_pos'],
                            'kategori' => 'Customer',
                            'data_of' => Fungsi::dataOfByDomainToko($domain_toko)
                        ]);
                    if($insert){
                        $user = User::find($data_['v']);
                        // dd($user);
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
                            DB::table('users')
                                ->where('id', $user->id)
                                ->delete();
                            DB::table('t_customer')
                                ->where('user_id', $user->id)
                                ->delete();
                            return redirect(route('d.register', ['domain_toko' => $domain_toko]))->with('error', $e->getMessage());
                        }
                        return redirect(route('d.login', ['domain_toko' => $domain_toko]))->with('sukses', 
                            'We sent you an activation code. Check your email and click on the link to verify, Didn\'t receive email <a href="javascript:void(0);" class="text-reset resendMail">resend mail</a>.'
                        );
                    }
                } else {
                    return redirect(route('d.register', ['domain_toko' => $domain_toko]));
                }
            } else {
                return redirect(route('d.register', ['domain_toko' => $domain_toko]));
            }
        } else {
            //landing page
        }
    }

    
}
