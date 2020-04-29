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

    public function tampil(Request $request){
        $data = Cart::session($request->getClientIp())->getContent();
        dd($data);
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
                        't_varian_produk.warna', 't_varian_produk.foto_id', 't_varian_produk.diskon_jual')
                    ->where('t_varian_produk.data_of', Fungsi::dataOfByDomainToko($domain_toko))
                    ->where('t_varian_produk.id_varian', $id_varian)
                    ->get()->first();
                if(isset($produk)){
                    Cart::session($request->getClientIp())->add([
                        'id' => 'p'.$id_produk.'v'.$id_varian,
                        'name' => $produk->nama_produk,
                        'price' => $produk->harga_jual_normal,
                        'quantity' => $jumlah,
                        'attributes' => [
                            'koleksi' => $produk
                        ]
                    ]);
                    return Fungsi::respon([
                        'status' => true,
                        'msg' => 'Produk berhasil ditambahkan di cart!',
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

}