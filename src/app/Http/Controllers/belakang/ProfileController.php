<?php

namespace App\Http\Controllers\belakang;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\PusatController as Fungsi;


class ProfileController extends Controller
{
	public function __construct(){
		$this->middleware('b.auth');
		$this->middleware('xss_protect');
    }

    public function userId()
    {
        return Auth::user()->id;
    }

    /**
     * Halaman Profile
     */
    public function index(Request $request)
    {
        $id = $this->userId();
        $users = DB::table('users')
            ->join('t_user_meta', 'users.id', '=', 't_user_meta.user_id')
            ->where('users.id', $id)
            ->select('users.*', 't_user_meta.role')
            ->get()->first();
        if ($request->ajax()) {
            return Fungsi::respon('belakang.profile', compact('users'), 'ajax', $request);
        }
        return Fungsi::respon('belakang.profile', compact('users'), 'html', $request);
    }

    /**
     * Update profile
     */
    public function updateProfile(Request $request)
    {
        if($request->ajax()){
            $id =$this->userId();
            $data = [
                'name' => $request->nama,
                'no_telp' => $request->no_telp
            ];
            if(isset($request->pass)){
                $data['password'] = Hash::make($request->pass);
            }
            $user = DB::table('users')
                ->where('id', $id)
                ->update($data);
            $role = DB::table('t_user_meta')
                ->where('user_id', $id)
                ->update([
                    'role' => $request->role,
                ]);
            if ($user || $role) {
                return response()->json(['status' => true]);
            } else {
                return response()->json(['status' => false, 'msg' => 'Gagal Menmperbarui Profil!']);
            }
        } else {
            abort(404);
        }
    }
}
