<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;
use App\Http\Controllers\PusatController as Fungsi;

class ProdukExport implements FromView
{
    private $data_of;
    private $tipe;

    public function __construct(string $data_of, string $tipe)
    {
        $this->data_of = $data_of;
        $this->tipe = $tipe == 'arsip' ? 1 : 0;
    }

    public function view(): view
    {
        $produk = DB::table('t_varian_produk')
				->join('t_produk', 't_produk.id_produk', '=', 't_varian_produk.produk_id')
				->select('t_produk.*', 't_varian_produk.*')
				->where('t_varian_produk.data_of', Fungsi::dataOfCek())
				->where('t_produk.arsip', $this->tipe)
                ->get();

			$data = [];
			$i = 0;
			$cari = (isset($request->cari)) ? strtolower($request->cari) : "";
			foreach(Fungsi::genArray($produk) as $p){
				if(preg_match("/".$cari."/", strtolower($p->nama_produk))){
					array_push($data, (array)$p);
					if(!is_null($p->foto_id)){
						$fotoSrc = json_decode($p->foto_id);
						if(!is_null($fotoSrc->utama)){
							$fotoUtama = DB::table('t_foto')->where('id_foto', $fotoSrc->utama)->where('data_of', Fungsi::dataOfCek())->get()->first();
							$data[$i]['foto']["utama"] = asset($fotoUtama->path);
							unset($fotoUtama);
						}else{
                            $data[$i]['foto']["utama"] = "";
                        }
						if($fotoSrc->lain != ""){
							$fotoLain_list = explode(";", $fotoSrc->lain);
							foreach($fotoLain_list as $iI => $iL){
								$fotoLain = DB::table('t_foto')->where('id_foto', $iL)->where('data_of', Fungsi::dataOfCek())->get()->first();
								$data[$i]['foto']["lain"][$iI+1] = asset($fotoLain->path);
								unset($fotoLain);
							}
						}else{
                            $data[$i]['foto']["lain"] = [];
                        }
					} else {
                        $data[$i]['foto']['utama'] = '';
                        $data[$i]['foto']['lain'] = [];
                    }
					$hg = DB::table('t_grosir')
						->where('t_grosir.data_of', Fungsi::dataOfCek())
						->where('t_grosir.produk_id', $p->produk_id)
						->get();
					if(count($hg) > 0){
						$data[$i]["harga_grosir"] = 1;
					} else {
						$data[$i]["harga_grosir"] = 0;
					}
					$data[$i] = (object)$data[$i];
                }
                if ($p->kategori_produk_id != null) {
                    $id_kategori = DB::table('t_produk')
                    ->join('t_kategori_produk', 't_kategori_produk.id_kategori_produk', '=', 't_produk.kategori_produk_id')
                    ->where('t_kategori_produk.id_kategori_produk', $p->kategori_produk_id)
                    ->select('t_kategori_produk.nama_kategori_produk')
                    ->get()->first();
                    if (!isset($id_kategori)) {
                        $kategori = '[?Data Terhapus?]';
                    }else{
                        $kategori = $id_kategori->nama_kategori_produk;
                    }
                }else{
                    $kategori = '';
                }
                $data[$i]->nama_kategori_produk = $kategori;
                $i++;
            }

        return view('belakang.exports.produk', [
            'produk' => $data
        ]);
    }

}
