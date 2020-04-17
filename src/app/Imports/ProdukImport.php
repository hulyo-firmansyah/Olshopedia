<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Http\Controllers\PusatController as Fungsi;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProdukImport implements ToCollection, WithHeadingRow
{
    private $hasil;

    public function collection(Collection $rows){
        $this->hasil = $rows;
        // foreach (Fungsi::genArray($rows) as $row) {
        //     $nama_produk = strip_tags($row['nama_produk']);
        //     $ukuran = strip_tags($row['ukuran']);
        //     $warna = strip_tags($row['warna']);
        //     $deskripsi = strip_tags($row['deskripsi']);
        //     $sku = strip_tags($row['sku']);
        //     $supplier = strip_tags($row['supplier']);
        //     $gambar = strip_tags($row['gambar']);
        //     $harga_beli = strip_tags($row['harga_beli']);
        //     $harga_jual = strip_tags($row['harga_jual']);
        //     $harga_reseller = strip_tags($row['harga_reseller']);
        //     $berat_gram = strip_tags($row['berat_gram']);
        //     $jumlah_stok = strip_tags($row['jumlah_stok']);
        //     $nama_kategori = strip_tags($row['kategori']);

        //     if ($nama_produk != "" && $sku != "" && $harga_beli != "" && $harga_jual != "" && $berat_gram != "" && $jumlah_stok != "") {
        //         if ($supplier != "") {
        //             $cekSupplier = DB::table('t_supplier')
        //                                     ->where('nama_supplier', $supplier)
        //                                     ->where('data_of', Fungsi::dataOfCek())
        //                                     ->get()->first();
        //             if (isset($cekSupplier)) {
        //                 $id_supplier = $cekSupplier->id_supplier;
        //             }else{
        //                 $id_supplier = null;
        //             }
        //         }else{
        //             $id_supplier = 0;
        //         }

        //         $produk_cek = DB::table('t_produk')
        //                                 ->where('nama_produk', $nama_produk)
        //                                 ->where('data_of', Fungsi::dataOfCek())
        //                                 ->get()->first();
        //         if (!is_null($produk_cek)) {
        //             $id_produk = $produk_cek->id_produk;
        //         }
        //         if (is_null($produk_cek) && isset($id_supplier)) {
        //             if ($nama_kategori != "") {
        //                 $kate = DB::table('t_kategori_produk')
        //                                 ->where('nama_kategori_produk', $nama_kategori)
        //                                 ->where('data_of', Fungsi::dataOfCek())
        //                                 ->get()->first();
        //                 if (isset($kate)) {
        //                     $id_kategori = $kate->id_kategori_produk;
        //                 }else{
        //                     $kate = DB::table('t_kategori_produk')
        //                                 ->insertGetId([
        //                                     'nama_kategori_produk' => $nama_kategori,
        //                                     'data_of' => Fungsi::dataOfCek(),
        //                                 ]);
        //                     $id_kategori = $kate;
        //                 }
        //             }else{
        //                 $id_kategori = null;
        //             }

        //             $berat = explode(' ', $berat_gram);

        //             $produk_id = DB::table('t_produk')
        //                             ->insertGetId([
        //                                 'nama_produk' => $nama_produk,
        //                                 'kategori_produk_id' => $id_kategori,
        //                                 'supplier_id' => $id_supplier,
        //                                 'berat' => ((int)$berat[0]),
        //                                 'ket' => $deskripsi,
        //                                 'data_of' => Fungsi::dataOfCek(),
        //                             ]);
        //             $id_produk = $produk_id;

        //             $varian_cek = DB::table('t_varian_produk')
        //                             ->where('sku', $sku)
        //                             ->where('data_of', Fungsi::dataOfCek())
        //                             ->get()->first();

        //             if (!isset($varian_cek)) {
        //                 if ($gambar != '') {
        //                     $cekGambar = DB::table('t_foto')
        //                             ->where('path', $gambar)
        //                             ->where('data_of', Fungsi::dataOfCek())
        //                             ->get()->first();
        //                     if (!isset($cekGambar)) {
        //                         $id_utama = 0;
        //                         $id_lain = [];
        //                         $path = explode(';', $gambar);
        //                         $i = 1;
        //                         foreach ($path as $values) {
        //                             $foto = DB::table('t_foto')
        //                                     ->insertGetId([
        //                                         'path' => $values,
        //                                         'data_of' => Fungsi::dataOfCek(),
        //                                         ]);
        //                             if($i == 1){
        //                                 $id_utama = $foto;
        //                             } else {
        //                                 array_push($id_lain, $foto);
        //                             }
        //                             $i++;
        //                         }
        //                         $foVarian = json_encode([
        //                             "utama" => $id_utama,
        //                             "lain" => implode(';', $id_lain)
        //                         ]);
        //                     }else{
        //                         $foVarian = '{"utama":null, "lain":""}';
        //                     }
        //                 } else {
        //                     $foVarian = '{"utama":null, "lain":""}';
        //                 }

        //                 if ($id_supplier != 0) {
        //                     if ($jumlah_stok == 'Y') {
        //                         $s = 1;
        //                     }else{
        //                         $s = 0;
        //                     }
        //                     $stok = $s.'|lain';
        //                 }else{
        //                     $stok = $jumlah_stok.'|sendiri';
        //                 }

        //                 $varian_produk = DB::table('t_varian_produk')
        //                                                 ->insert([
        //                                                     'stok' => $stok,
        //                                                     'sku' => $sku,
        //                                                     'produk_id' => $id_produk,
        //                                                     'harga_beli' =>((int)$harga_beli),
        //                                                     'harga_jual_normal' => ((int)$harga_jual),
        //                                                     'harga_jual_reseller' => ((int)$harga_reseller),
        //                                                     'ukuran' => $ukuran,
        //                                                     'warna' => $warna,
        //                                                     'foto_id' => $foVarian,
        //                                                     'data_of' => Fungsi::dataOfCek(),
        //                                                 ]);
        //             }
        //         }else if(isset($produk_cek) && isset($id_supplier)){
        //             $varian_cek = DB::table('t_varian_produk')
        //                             ->where('sku', $sku)
        //                             ->where('data_of', Fungsi::dataOfCek())
        //                             ->get()->first();

        //             if (!isset($varian_cek)) {
        //                 if ($gambar != '') {
        //                     $cekGambar = DB::table('t_foto')
        //                             ->where('path', $gambar)
        //                             ->where('data_of', Fungsi::dataOfCek())
        //                             ->get()->first();
        //                     if (!isset($cekGambar)) {
        //                         $id_utama = 0;
        //                         $id_lain = [];
        //                         $path = explode(';', $gambar);
        //                         $i = 1;
        //                         foreach ($path as $values) {
        //                             $foto = DB::table('t_foto')
        //                                     ->insertGetId([
        //                                         'path' => $values,
        //                                         'data_of' => Fungsi::dataOfCek(),
        //                                         ]);
        //                             if($i == 1){
        //                                 $id_utama = $foto;
        //                             } else {
        //                                 array_push($id_lain, $foto);
        //                             }
        //                             $i++;
        //                         }
        //                         $foVarian = json_encode([
        //                             "utama" => $id_utama,
        //                             "lain" => implode(';', $id_lain)
        //                         ]);
        //                     }else{
        //                         $foVarian = '{"utama":null, "lain":""}';
        //                     }
        //                 } else {
        //                     $foVarian = '{"utama":null, "lain":""}';
        //                 }

        //                 if ($id_supplier != 0) {
        //                     if ($jumlah_stok == 'Y') {
        //                         $s = 1;
        //                     }else{
        //                         $s = 0;
        //                     }
        //                     $stok = $s.'|lain';
        //                 }else{
        //                     $stok = $jumlah_stok.'|sendiri';
        //                 }

        //                 $varian_produk = DB::table('t_varian_produk')
        //                                                 ->insert([
        //                                                     'stok' => $stok,
        //                                                     'sku' => $sku,
        //                                                     'produk_id' => $id_produk,
        //                                                     'harga_beli' =>((int)$harga_beli),
        //                                                     'harga_jual_normal' => ((int)$harga_jual),
        //                                                     'harga_jual_reseller' => ((int)$harga_reseller),
        //                                                     'ukuran' => $ukuran,
        //                                                     'warna' => $warna,
        //                                                     'foto_id' => $foVarian,
        //                                                     'data_of' => Fungsi::dataOfCek(),
        //                                                 ]);
        //             }
        //         }
        //     }
        // }
        // // $this->data = $rows;
    }

    public function getHasil(){
        $temp = [];
        foreach(Fungsi::genArray($this->hasil) as $i => $h){
            $temp[] = $h;
            $temp[$i]['id_untuk_validasi'] = ($i+1);
        }
        return $temp;
    }

}
