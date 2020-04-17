<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;

class OrderExport implements FromView
{
    private $data_of;
    private $filter;

    public function __construct(string $data_of, $filter)
    {
        $this->data_of = $data_of;
        $this->filter = $filter;
    }

    public function view(): view
    {
        $data= [];
        $all_order =  DB::table("t_order")
                            ->where("data_of", $this->data_of)
                            ->orderBy('urut_order', 'asc')
                            ->get();

        if ($this->filter['dari'] != '' && $this->filter['sampai'] != '') {
            $awal = strtotime($this->filter['dari']);
            $today = strtotime($this->filter['sampai']);
        }else{
            $awal = strtotime('1 '.date(' M Y'));
            $today = strtotime(date('j M Y'));
        }

        $date = 'Date : '.date('l, d M Y', $awal).' Until '.date('l, d M Y', $today);
        foreach ($all_order as $row) {
            if (strtotime($row->tanggal_order) >= $awal && strtotime($row->tanggal_order) <= $today) {
            /* Pemesan */
            $p = DB::table('t_order')
                            ->join('users', 't_order.pemesan_id', '=', 'users.id')
                            ->where('t_order.pemesan_id', $row->pemesan_id)
                            ->where('t_order.data_of', $this->data_of)
                            ->select('users.name', 'users.no_telp', 't_order.pemesan_kategori')
                            ->get()->first();
            if (isset($p)) {
                $pemesan = $p;
            }else{
                $pemesan = new \stdclass();
                $pemesan->name = '[?Data tidak ditemukan?]';
                $pemesan->no_telp = '[?Data tidak ditemukan?]';
                $pemesan->kategori = '[?Data tidak ditemukan?]';
            }

            /* Dikirim kepada */
            $tp = DB::table('t_order')
                            ->join('users', 't_order.tujuan_kirim_id', '=', 'users.id')
                            ->where('t_order.tujuan_kirim_id', $row->tujuan_kirim_id)
                            ->where('t_order.data_of', $this->data_of)
                            ->select('users.name', 'users.no_telp')
                            ->get()->first();
            if (isset($tp)) {
                $penerima = $tp;
            }else{
                $penerima = new \stdclass();
                $penerima->name = '[?Data tidak ditemukan?]';
                $penerima->no_telp = '[?Data tidak ditemukan?]';
            }


            /* Alamat Pengiriman */
            $ap = DB::table('t_order')
                            ->join('t_customer', 't_order.tujuan_kirim_id', '=', 't_customer.user_id')
                            ->where('t_customer.user_id', $row->tujuan_kirim_id)
                            ->where('t_order.data_of', $this->data_of)
                            ->select('t_customer.provinsi', 't_customer.kabupaten', 't_customer.kecamatan', 't_customer.kode_pos', 't_customer.alamat')
                            ->get()->first();
            if (isset($ap)) {
                $alamat_t = implode(', ', array($ap->alamat, $ap->kecamatan, $ap->kabupaten, $ap->provinsi, $ap->kode_pos));
            }else{
                $alamat_t = '[?Data tidak ditemukan?]';
            }

            /* Kecamatan Asal Kirim, Tanggal Order  */
            // $asal = $kak[3];
            $kak = explode('|', $row->kecamatan_asal_kirim_id);
            $tanggal_order = $row->tanggal_order;

            /* Detail pembayaran */
            $status = (json_decode($row->pembayaran)->status);
            $tb = (json_decode($row->pembayaran)->tanggalBayar);

            /* Ekspedisi */
            $eks = (json_decode($row->kurir)->tipe);

            /* No resi */
            $no_resi = $row->resi;

            /* Catatan / Note */
            $note = (json_decode($row->catatan)->data);

            /* Data Produk */
            $produk = json_decode($row->produk);

            $totalBerat = $produk->totalBerat;
            $data_produk = [];
            foreach ($produk->list as $dp) {
                $t_ = $dp->rawData;
                $data_p = DB::table('t_varian_produk')
                                ->where('id_varian', $t_->id_varian)
                                ->where('data_of', $this->data_of)
                                ->get()->first();
                if (isset($data_p)){
                    $produk = $t_;
                }else{
                    $produk = $t_;
                    $produk->nama_produk = '[?Data tidak ditemukan?]';
                }

                $t_->jumlah = $dp->jumlah;
                array_push($data_produk, $produk);
                $jumlah = $dp->jumlah;
            }

            /* Detail, Biaya &, Harga Produk */
            $dhp = json_decode($row->total);
            $harga_produk = $dhp->hargaProduk;
            $harga_ongkir = $dhp->hargaOngkir;
            $biaya_lain = $dhp->biayaLain;
            $diskon_order = $dhp->diskonOrder;
            $diskon_produk = $dhp->diskonProduk;

            /* Bank */
            $idP = DB::table('t_order')
                            ->join('t_pembayaran', 't_order.id_order', '=', 't_pembayaran.order_id')
                            ->where('t_pembayaran.order_id', $row->id_order)
                            ->where('t_pembayaran.data_of', $this->data_of)
                            ->select('t_pembayaran.order_id', 't_pembayaran.via', 't_pembayaran.tgl_bayar')
                            ->get();
            $idp2 = [];
            foreach ($idP as $key) {
                array_push($idp2, $key);
            }
            usort($idp2, function($a, $b){
                if (strtotime($a->tgl_bayar) == strtotime($b->tgl_bayar)) {
                    return 0;
                }
                return (strtotime($a->tgl_bayar) < strtotime($b->tgl_bayar)) ? -1 : 1;
            });

            $admin = DB::table('t_order')
                                ->join('users', 't_order.admin_id', '=', 'users.id')
                                ->where('t_order.admin_id', $row->admin_id)
                                ->where('t_order.data_of', $this->data_of)
                                ->select('users.name')
                                ->get()->first();
            if (isset($admin)) {
                $by = $admin;
            }else{
                $by = new \stdclass();
                $by->name = '[?Data tidak ditemukan?]';
            }

            array_push($data, [
                'pemesan' => $pemesan,
                'penerima' => $penerima,
                'alamat_t' => $alamat_t,
                'tanggal_order' => $tanggal_order,
                'status' => $status,
                'tb' => $tb,
                'eks' => $eks,
                'no_resi' => $no_resi,
                'note' => $note,
                'totalBerat' => $totalBerat,
                'data_produk' => $data_produk,
                'harga_produk' => $harga_produk,
                'harga_ongkir' => $harga_ongkir,
                'biaya_lain' => $biaya_lain,
                'diskon_produk' => $diskon_produk,
                'diskon_order' => $diskon_order,
                'idp2' => $idp2,
                'admin' => $by->name,
            ]);
            }
        }

        return view('belakang.exports.Order', [
            'data' => $data,
            'date' => $date
        ]);
    }

}
