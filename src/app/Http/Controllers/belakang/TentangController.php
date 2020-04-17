<?php
namespace App\Http\Controllers\belakang;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\PusatController as Fungsi;

class TentangController extends Controller
{
	public function __construct(){
		$this->middleware(['b.auth', 'b.locale']);
    }
    
    public function versionHistory(Request $request){
        if($request->ajax()){
			return Fungsi::respon('belakang.riwayat-versi', [], "ajax", $request);
		}
		return Fungsi::respon('belakang.riwayat-versi', [], "html", $request);
	}
}