<?php

namespace App\Http\Controllers\belakang;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Contracts\Encryption\DecryptException;
use App\Http\Controllers\PusatController as Fungsi;


class LogController extends Controller
{

	public function __construct(){
		$this->middleware(['b.auth', 'xss_protect', 'b.cekDataToko']);
    }

    
    public function index(Request $request)
    {
        $data = [];
        $filter['tglDari'] = strip_tags($request->dari);
        $filter['tglSampai'] = strip_tags($request->sampai);
        if ($filter['tglDari'] == '') {
            $filter['tglDari'] = date('d M Y');
        }
        if($filter['tglSampai'] == ''){
            $filter['tglSampai'] = date('d M Y');
        }

        $log = DB::table('t_log')
            ->join('users', 't_log.user_id', '=', 'users.id')
            ->where('data_of', Fungsi::dataOfCek())
            ->select('t_log.keterangan', 't_log.tanggal_waktu', 'users.name', 'users.email')
            ->orderBy('tanggal_waktu', 'desc')
            ->get();


        foreach ($log as $row) {
            $time = strtotime(explode(' ', $row->tanggal_waktu)[0].' 00:00:00');
            if ($time >= strtotime($filter['tglDari']) && $time <= strtotime($filter['tglSampai'])) {
                array_push($data, [
                    'keterangan' => $row->keterangan,
                    'tanggal_waktu' => $row->tanggal_waktu,
                    'name' => $row->name,
                    'email' => $row->email,
                    'since' => Fungsi::time_since(strtotime($row->tanggal_waktu))
                ]);
            }
        }

        if ($request->ajax()) {
            return Fungsi::respon('belakang.log', compact('filter', 'data'), 'ajax', $request);
        }
        return Fungsi::respon('belakang.log', compact('filter', 'data'), 'html', $request);
    }
    
    public function deleteLog()
    {
        $destroy = DB::table('t_log')
            ->where('data_of', Fungsi::dataOfCek())
            ->delete();

        if ($destroy) {
            Session::flash('msg_success', 'Log berhasil dihapus!');
            return redirect()->route('b.log-index');
            
        }else if($destroy == 0){
            Session::flash('msg_warning', 'Tidak ada log terhapus');
            return redirect()->route('b.log-index');
        }else{
            Session::flash('msg_errorl', 'Log gagal dihapus!');
            return redirect()->route('b.log-index');
        }
    }
}