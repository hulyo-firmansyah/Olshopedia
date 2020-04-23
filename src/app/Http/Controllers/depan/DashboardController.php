<?php

namespace App\Http\Controllers\depan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\PusatController as Fungsi;

class DashboardController extends Controller
{
	public function __construct(){
		// $this->middleware('b.auth');
		// $this->middleware('b.locale');
		$this->middleware('xss_protect');
	}

    public function index(Request $request, $toko_slug){
		// dd($toko_slug);
		$toko = DB::table('t_store')
			->where('domain_toko', $toko_slug)
			->get()->first();
		if(isset($toko)){
			// $dataOf = Fungsi::dataOfByTokoSlug($toko_slug);
			if($request->ajax()){
				return Fungsi::respon('depan.'.$toko->template.'.index', compact("toko"), "ajax", $request);
			}
			return Fungsi::respon('depan.'.$toko->template.'.index', compact("toko"), "html", $request);
		} else {
			// ke landing page
		}
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