<?php

namespace App\Listeners\BelakangLogging;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Events\BelakangLogging;
use Illuminate\Support\Facades\DB;

class TrackLog
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(BelakangLogging $event)
    {
        switch($event->tipe){
            case 'login':
                $log_login = DB::table('t_log')
                    ->insert([
                        'keterangan' => 'Login',
                        'tanggal_waktu' => date('Y-m-d H:i:s'),
                        'user_id' => $event->data->id,
                        'data_of' => $event->dataof,
                    ]);
                break;

            case 'logout':
                $log_logout = DB::table('t_log')
                    ->insert([
                        'keterangan' => 'Logout',
                        'tanggal_waktu' => date('Y-m-d H:i:s'),
                        'user_id' => $event->data,
                        'data_of' => $event->dataof,
                    ]);
                break;

            case 'tambah_produk':
                $log_insertProduk = DB::table('t_log')
                    ->insert([
                        'keterangan' => 'Menambah Produk <b>'.$event->data['nama_produk'].'</b>',
                        'tanggal_waktu' => date('Y-m-d H:i:s'),
                        'user_id' => $event->data['user_id'],
                        'data_of' => $event->dataof,
                    ]);
                break;

            case 'edit_produk':
                $log_updateProduk = DB::table('t_log')
                    ->insert([
                        'keterangan' => 'Mengedit Produk <b>'.$event->data['nama_produk'].'</b>',
                        'tanggal_waktu' => date('Y-m-d H:i:s'),
                        'user_id' => $event->data['user_id'],
                        'data_of' => $event->dataof,
                    ]);
                break;

            case 'beli_produk_tambah_stok':
                $log_updateProduk = DB::table('t_log')
                    ->insert([
                        'keterangan' => 'Membeli Produk (Tambah Stok) <b>'.$event->data['nama_produk'].$event->data['varian'].'</b>',
                        'tanggal_waktu' => date('Y-m-d H:i:s'),
                        'user_id' => $event->data['user_id'],
                        'data_of' => $event->dataof,
                    ]);
                break;

            case 'beli_produk_ubah_stok':
                $log_updateProduk = DB::table('t_log')
                    ->insert([
                        'keterangan' => 'Membeli Produk (Ubah Stok) <b>'.$event->data['nama_produk'].$event->data['varian'].'</b>',
                        'tanggal_waktu' => date('Y-m-d H:i:s'),
                        'user_id' => $event->data['user_id'],
                        'data_of' => $event->dataof,
                    ]);
                break;

            case 'beli_produk_tambah_varian':
                $log_updateProduk = DB::table('t_log')
                    ->insert([
                        'keterangan' => 'Membeli Produk (Tambah Varian) <b>'.$event->data['nama_produk'].$event->data['varian'].'</b>',
                        'tanggal_waktu' => date('Y-m-d H:i:s'),
                        'user_id' => $event->data['user_id'],
                        'data_of' => $event->dataof,
                    ]);
                break;

            case 'hapus_produk':
                $log_deleteProduk = DB::table('t_log')
                    ->insert([
                        'keterangan' => 'Menghapus Produk <b>'.implode('</b>, <b>', $event->data['nama_produk']).'</b>',
                        'tanggal_waktu' => date('Y-m-d H:i:s'),
                        'user_id' => $event->data['user_id'],
                        'data_of' => $event->dataof,
                    ]);
                break;

            case 'tambah_customer':
                $log_insertCustomer = DB::table('t_log')
                    ->insert([
                        'keterangan' => 'Menambah [<b>'.$event->data['kategori'].'</b>] <b>'.$event->data['nama'].'</b>',
                        'tanggal_waktu' => date('Y-m-d H:i:s'),
                        'user_id' => $event->data['user_id'],
                        'data_of' => $event->dataof,
                    ]);
                break;

            case 'edit_customer':
                $log_updateCustomer = DB::table('t_log')
                    ->insert([
                        'keterangan' => 'Mengedit [<b>'.$event->data['kategori'].'</b>] <b>'.$event->data['nama'].'</b>',
                        'tanggal_waktu' => date('Y-m-d H:i:s'),
                        'user_id' => $event->data['user_id'],
                        'data_of' => $event->dataof,
                    ]);
                break;

            case 'hapus_customer':
                $log_deleteCustomer = DB::table('t_log')
                    ->insert([
                        'keterangan' => 'Menghapus [<b>'.$event->data['kategori'].'</b>] <b>'.$event->data['nama'].'</b>',
                        'tanggal_waktu' => date('Y-m-d H:i:s'),
                        'user_id' => $event->data['user_id'],
                        'data_of' => $event->dataof,
                    ]);
                break;

            case 'cancel_order':
                $log_cancelOrder = DB::table('t_log')
                    ->insert([
                        'keterangan' => 'Membatalkan Order ID <b>#'.$event->data['urut_order'].'</b>',
                        'tanggal_waktu' => date('Y-m-d H:i:s'),
                        'user_id' => $event->data['user_id'],
                        'data_of' => $event->dataof,
                    ]);
                break;

            case 'kembali_order':
                $log_kembaliOrder = DB::table('t_log')
                    ->insert([
                        'keterangan' => 'Mengembalikan Order ID <b>#'.$event->data['urut_order'].'</b> dari cancel order',
                        'tanggal_waktu' => date('Y-m-d H:i:s'),
                        'user_id' => $event->data['user_id'],
                        'data_of' => $event->dataof,
                    ]);
                break;

            case 'hapus_order':
                $log_deleteOrder = DB::table('t_log')
                    ->insert([
                        'keterangan' => 'Menghapus Order ID <b>#'.$event->data['urut_order'].'</b>',
                        'tanggal_waktu' => date('Y-m-d H:i:s'),
                        'user_id' => $event->data['user_id'],
                        'data_of' => $event->dataof,
                    ]);
                break;

            case 'tambah_order':
                $log_insertOrder = DB::table('t_log')
                    ->insert([
                        'keterangan' => 'Menambah Order ID <b>#'.$event->data['urut_order'].'</b>',
                        'tanggal_waktu' => date('Y-m-d H:i:s'),
                        'user_id' => $event->data['user_id'],
                        'data_of' => $event->dataof,
                    ]);
                break;

            case 'edit_order':
                $log_updateOrder = DB::table('t_log')
                    ->insert([
                        'keterangan' => 'Mengedit Order ID <b>#'.$event->data['urut_order'].'</b>',
                        'tanggal_waktu' => date('Y-m-d H:i:s'),
                        'user_id' => $event->data['user_id'],
                        'data_of' => $event->dataof,
                    ]);
                break;

            case 'tambah_kategori_produk':
                $log_insertKproduk = DB::table('t_log')
                    ->insert([
                        'keterangan' => 'Menambah Kategori Produk <b>'.$event->data['nama_kategori'].'</b>',
                        'tanggal_waktu' => date('Y-m-d H:i:s'),
                        'user_id' => $event->data['user_id'],
                        'data_of' => $event->dataof,
                    ]);
                break;

            case 'edit_kategori_produk':
                $log_updateKproduk = DB::table('t_log')
                    ->insert([
                        'keterangan' => 'Mengedit Kategori Produk <b>'.$event->data['nama_kategori'].'</b>',
                        'tanggal_waktu' => date('Y-m-d H:i:s'),
                        'user_id' => $event->data['user_id'],
                        'data_of' => $event->dataof,
                    ]);
                break;

            case 'hapus_kategori_produk':
                $log_deleteKproduk = DB::table('t_log')
                    ->insert([
                        'keterangan' => 'Mengahapus Kategori Produk <b>'.$event->data['nama_kategori'].'</b>',
                        'tanggal_waktu' => date('Y-m-d H:i:s'),
                        'user_id' => $event->data['user_id'],
                        'data_of' => $event->dataof,
                    ]);
                break;
        }
    }
}
