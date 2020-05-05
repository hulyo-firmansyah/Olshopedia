<?php

namespace App\Http\Controllers\depan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\PusatController as Fungsi;
use Cart;

class CartController extends Controller
{
	public function __construct(){
		$this->middleware('cek_toko_domain');
	}

    public function tampil(Request $request, $domain_toko){
        $cart = Cart::session($request->getClientIp())->getContent();
        // dd($cart);
		$toko = DB::table('t_store')
            ->where('domain_toko', $domain_toko)
            ->get()->first();
        $r['sort'] = strip_tags($request->sort);
        $r['cari'] = strip_tags($request->q);
        if(isset($toko)){
            return Fungsi::respon('depan.'.$toko->template.'.cart', compact("toko", 'r', 'cart'), "html", $request);
        } else {
            // ke landing page
        }
    }

    public function tambah(Request $request, $domain_toko){
        // echo '<pre>'.print_r($request->getClientIp(), true)."</pre>";
        // return '<pre>'.print_r($request->all(), true)."</pre>";
        if($request->ajax()){
            if($request->ip !== '' && $request->iv !== '' && $request->jumlah !== ''){
                $id_produk = strip_tags($request->ip);
                $id_varian = strip_tags($request->iv);
                $jumlah = (int)strip_tags($request->jumlah);
                $produk = DB::table('t_varian_produk')
                    ->join('t_produk', 't_produk.id_produk', '=', 't_varian_produk.produk_id')
                    ->select('t_produk.nama_produk', 't_varian_produk.harga_jual_normal', 't_varian_produk.ukuran', 
                        't_varian_produk.warna', 't_varian_produk.foto_id', 't_varian_produk.diskon_jual', 't_varian_produk.stok')
                    ->where('t_varian_produk.data_of', Fungsi::dataOfByDomainToko($domain_toko))
                    ->where('t_varian_produk.id_varian', $id_varian)
                    ->get()->first();
                if(isset($produk)){
                    $nama_produk = $produk->nama_produk;
                    if((isset($produk->ukuran) && $produk->ukuran !== '') && (isset($produk->warna) && $produk->warna !== '')){
                        $nama_produk .= ' ('.$produk->ukuran.' '.$produk->warna.')';
                    } else if((isset($produk->ukuran) && $produk->ukuran !== '') && (!isset($produk->warna) || $produk->warna === '')){
                        $nama_produk .= ' ('.$produk->ukuran.')';
                    } else if((!isset($produk->ukuran) || $produk->ukuran === '') && (isset($produk->warna) && $produk->warna !== '')){
                        $nama_produk .= ' ('.$produk->warna.')';
                    }
                    Cart::session($request->getClientIp())->add([
                        'id' => 'p'.$id_produk.'v'.$id_varian,
                        'name' => $nama_produk,
                        'price' => $produk->harga_jual_normal,
                        'quantity' => $jumlah,
                        'attributes' => [
                            'koleksi' => $produk
                        ]
                    ]);
                    return Fungsi::respon([
                        'status' => true,
                        'msg' => 'Produk berhasil ditambahkan ke cart!',
                        'cart_count' => count(Cart::session($request->getClientIp())->getContent())
                    ], [], 'json', $request);
                } else {
                    return Fungsi::respon([
                        'status' => false,
                        'msg' => 'Data produk tersebut tidak ditemukan!'
                    ], [], 'json', $request);
                }
            } else {
                return Fungsi::respon([
                    'status' => false,
                    'msg' => 'Data kurang lengkap!'
                ], [], 'json', $request);
            }
        } else {
            abort(404);
        }
    }

    public function hapus(Request $request, $domain_toko){
        // echo '<pre>'.print_r($request->getClientIp(), true)."</pre>";
        // return '<pre>'.print_r($request->all(), true)."</pre>";
        if($request->ajax()){
            if($request->id !== ''){
                $id = strip_tags($request->id);
                Cart::session($request->getClientIp())->remove($id);
                return Fungsi::respon([
                    'status' => true,
                    'msg' => 'Produk berhasil dihapus dari cart!',
                    'cart_count' => count(Cart::session($request->getClientIp())->getContent())
                ], [], 'json', $request);
            } else {
                return Fungsi::respon([
                    'status' => false,
                    'msg' => 'Data kurang lengkap!'
                ], [], 'json', $request);
            }
        } else {
            abort(404);
        }
    }

}