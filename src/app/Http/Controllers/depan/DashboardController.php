<?php

namespace App\Http\Controllers\depan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PusatController as Fungsi;

class DashboardController extends Controller
{
	public function __construct(){
		$this->middleware('b.auth');
		// $this->middleware('b.locale');
		$this->middleware('xss_protect');
	}

    public function index(Request $request, $toko_slug){
		return Fungsi::dataOfCekUsername();
		// if($request->ajax()){
		// 	return Fungsi::respon('depan.dashboard', compact("toko_slug"), "ajax", $request);
		// }
		// return Fungsi::respon('depan.dashboard', compact("toko_slug"), "html", $request);
	}

	// public function locale(Request $request){
	// 	$langAv = ['en', 'id'];
	// 	if(!isset($request->lang)){
	// 		$lang = 'id';
	// 	}
	// 	if(!in_array($request->lang, $langAv)){
	// 		$lang = 'id';
	// 	} else {
	// 		$lang = $request->lang;
	// 	}
		
	// 	$request->session()->put('locale', $lang);
	// 	if(filter_var(base64_decode($request->next), FILTER_VALIDATE_URL)){
	// 		return redirect(base64_decode($request->next));
	// 	} else {
	// 		return redirect('/');
	// 	}
	// }
	
}