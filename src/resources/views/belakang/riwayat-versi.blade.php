@extends('belakang.index')
@section('isi')
<!--uiop-->
<div class="page-header page-header-bordered">
    <h1 class="page-title font-size-26 font-weight-100">Riwayat Versi</h1>
</div>

<div class="page-content">
    <div class='container'>
        <div class='panel'>
            <div class='panel-body'>
                <div class='mb-40'>
                    <h4>v0.9.2 &nbsp;&nbsp;(24 Apr 2020)</h4>
                    <div class='ml-30'>
                        <b style='font-size:15px'>Changed</b>
                        <ul>
                            <li>Optimization performance pada cari, filter, semua order</li>
                        </ul>
                    </div>
                    <div class='ml-30'>
                        <b style='font-size:15px'>Added</b>
                        <ul>
                            <li>Penambahan checklist all dan print all pada cari dan filter order</li>
                        </ul>
                    </div>
                    <div class='ml-30'>
                        <b style='font-size:15px'>Fixed</b>
                        <ul>
                            <li>Fix bug select box kurir tertindih data order pada filter order</li>
                            <li>Fix bug tidak bisa memfilter admin di semua, filter, cari order</li>
                            <li>fix bug error select all saat tidak ada order di semua, filter, cari order</li>
                        </ul>
                    </div>
                </div>
                <div class='mb-40'>
                    <h4>v0.9.1 &nbsp;&nbsp;(23 Apr 2020)</h4>
                    <div class='ml-30'>
                        <b style='font-size:15px'>Fixed</b>
                        <ul>
                            <li>Fix Bug tidak bisa memfilter via pembayaran bank di order</li>
                            <li>Fix Bug filter order tidak memfilter print label</li>
                            <li>Fix bug digit terlalu banyak di add dan edit supplier</li>
                        </ul>
                    </div>
                </div>
                <div class='mb-40'>
                    <h4>v0.9 &nbsp;&nbsp;(22 Apr 2020)</h4>
                    <div class='ml-30'>
                        <b style='font-size:15px'>Added</b>
                        <ul>
                            <li>Penambahan menu data pembelian produk</li>
                        </ul>
                    </div>
                    <div class='ml-30'>
                        <b style='font-size:15px'>Changed</b>
                        <ul>
                            <li>Stok sekarang tetap harus menginputkan jumlah di tambah dan edit produk</li>
                            <li>Menu Supplier dipindah dari submenu setting ke menu utama</li>
                            <li>Perubahan menu pembelian produk</li>
                        </ul>
                    </div>
                    <div class='ml-30'>
                        <b style='font-size:15px'>Fixed</b>
                        <ul>
                            <li>Fix Bug gross profit tetap terlihat setelah admin tidak diberi akses lihat omzet</li>
                            <li>Fix Bug error sending mail registration atau login</li>
                        </ul>
                    </div>
                </div>
                <div class='mb-40'>
                    <h4>v0.8 &nbsp;&nbsp;(8 Apr 2020)</h4>
                    <div class='ml-30'>
                        <b style='font-size:15px'>Added</b>
                        <ul>
                            <li>Penambahan Addons Notifikasi resi via Email (Beta)</li>
                            <li>Penambahan Addons Notifikasi Whatsapp (Beta)
                                <ul>
                                    <li>Notifikasi saat resi sudah diupdate</li>
                                </ul>
                            </li>
                            <li>Penambahan Pembelian Produk</li>
                            <li>Penambahan Print Order</li>
                        </ul>
                    </div>
                    <div class='ml-30'>
                        <b style='font-size:15px'>Fixed</b>
                        <ul>
                            <li>Fix Bug error saat menambahkan customer dan mengedit customer jika kode pos diisi acak</li>
                            <li>Fix Bug error tidak bisa track stok saat mengedit produk (menambah varian baru)</li>
                            <li>Fix Bug error tidak bisa tambah varian saat mengedit produk supplier</li>
                        </ul>
                    </div>
                </div>
                <div class='mb-40'>
                    <h4>v0.7 &nbsp;&nbsp;(26 Mar 2020)</h4>
                    <div class='ml-30'>
                        <b style='font-size:15px'>Added</b>
                        <ul>
                            <li>Penambahan Hak Akses Admin 'Hapus Produk'</li>
                            <li>Penambahan Hak Akses Admin 'Upload Produk Via Excel'</li>
                            <li>Penambahan Hak Akses Admin 'Download Excel'</li>
                            <li>Penambahan Hak Akses Admin 'Hapus Customer'</li>
                            <li>Penambahan Hak Akses Admin 'Edit Customer'</li>
                            <li>Penambahan Hak Akses Admin 'Edit Order'</li>
                            <li>Penambahan Hak Akses Admin 'Edit Order dari Admin lain'</li>
                            <li>Penambahan Hak Akses Admin 'Cancel Order'</li>
                            <li>Penambahan Hak Akses Admin 'Melihat Omset (Net Sales dan Gross Profit)'</li>
                        </ul>
                    </div>
                    <!-- <div class='ml-30'>
                        <b style='font-size:15px'>Changed</b>
                        <ul>
                            <li>Peningkatan performance saat pengiriman email</li>
                        </ul>
                    </div> -->
                    <div class='ml-30'>
                        <b style='font-size:15px'>Fixed</b>
                        <ul>
                            <li>Fix Bug tombol pilih via pembayaran kadang error di Edit Order</li>
                            <li>Fix Bug tidak bisa edit dan hapus Diskon Order serta Biaya Lain di Edit Order</li>
                            <li>Fix Bug error data kurang saat Edit Order</li>
                            <li>Fix Bug Diskon Order dan Biaya Lain tidak terhitung di Detail Order</li>
                            <li>Fix Bug Dropdown menu profil tidak hilang setelah diklik</li>
                            <li>Fix Bug Diskon Order tidak ikut terhitung di laporan dan analisa</li>
                            <li>Fix Bug filter error saat tidak dipilih dengan benar di analisa (Best Customer)</li>
                        </ul>
                    </div>
                </div>
                <div class='mb-40'>
                    <h4>v0.6 &nbsp;&nbsp;(17 Mar 2020)</h4>
                    <div class='ml-30'>
                        <b style='font-size:15px'>Added</b>
                        <ul>
                            <li>Track Stok produk pada edit produk dan selesai order</li>
                            <li>Password strength meter</li>
                            <li>Penambahan Hak Akses Admin 'Menu Expense'</li>
                            <li>Penambahan Hak Akses Admin 'Melihat Analisa'</li>
                            <li>Penambahan Edit Order</li>
                        </ul>
                    </div>
                    <div class='ml-30'>
                        <b style='font-size:15px'>Changed</b>
                        <ul>
                            <li>Sekarang sku otomatis ter generate</li>
                        </ul>
                    </div>
                    <div class='ml-30'>
                        <b style='font-size:15px'>Fixed</b>
                        <ul>
                            <li>Fix Bug tidak bisa dienter di lupa password</li>
                            <li>Fix Bug error saat import produk dengan berat bukan angka</li>
                            <li>Fix Bug import produk yang seharusnya 2 varian 1 produk, menjadi 2 produk 1 varian</li>
                            <li>Fix Bug import produk tidak tertrack riwayat stok</li>
                            <li>Fix Bug tidak bisa hapus varian pada edit produk</li>
                            <li>Fix Bug tidak redirect saat login session habis jika pakai ajax load</li>
                            <li>Fix Bug tidak bisa tambah bank di beberapa device</li>
                            <li>Fix Bug tidak bisa merubah stok dari stok sendiri ke stok dari supplier di edit produk jika varian telah dihapus</li>
                            <li>Fix Bug selectpicker stok supplier tidak ke init di edit produk</li>
                            <li>Fix Bug stok tidak kurang saat selesai order</li>
                            <li>Fix Bug error saat id order tidak ditemukan di detail order</li>
                            <li>Fix Bug tidak bisa edit customer jika email tidak dirubah juga</li>
                            <li>Fix Bug tambah user dengan email not valid</li>
                            <li>Fix Bug user yang sudah ditambahkan tidak bisa login</li>
                            <li>Fix Bug kadang error saat menambah, mengedit, menghapus Biaya Lain dan Diskon Order di Tambah Order</li>
                        </ul>
                    </div>
                </div>
                <div class='mb-40'>
                    <h4>v0.5 &nbsp;&nbsp;(9 Mar 2020)</h4>
                    <div class='ml-30'>
                        <b style='font-size:15px'>Added</b>
                        <ul>
                            <li>Penambahan Export Expense</li>
                            <li>Penambahan Export Customer</li>
                            <li>Penambahan Export Order</li>
                            <li>Penambahan Export dan Import Produk</li>
                            <li>Penambahan Preview Import Produk</li>
                            <li>Penambahan Log Aktifitas</li>
                        </ul>
                    </div>
                    <div class='ml-30'>
                        <b style='font-size:15px'>Changed</b>
                        <ul>
                            <li>Peningkatan kecepatan loading pada menu Pengaturan</li>
                        </ul>
                    </div>
                    <div class='ml-30'>
                        <b style='font-size:15px'>Fixed</b>
                        <ul>
                            <li>Fix Bug produk arsip bisa diorder</li>
                            <li>Fix Bug tambah dan edit kategori produk dengan nama kategori yang sama</li>
                            <li>Fix Bug foto produk tidak tampil jika menggunakan link external</li>
                            <li>Fix Bug pada order saat cek ongkir terkadang tidak cek ongkir</li>
                        </ul>
                    </div>
                </div>
                <div class='mb-40'>
                    <h4>v0.4 &nbsp;&nbsp;(3 Mar 2020)</h4>
                    <div class='ml-30'>
                        <b style='font-size:15px'>Added</b>
                        <ul>
                            <li>Penambahan cache data pada pengaturan</li>
                            <li>Penambahan menu pengaturan umum pada pengaturan</li>
                            <li>Penambahan multi edit produk</li>
                            <li>Produk sekarang sudah bisa diarsipkan</li>
                        </ul>
                    </div>
                    <div class='ml-30'>
                        <b style='font-size:15px'>Changed</b>
                        <ul>
                            <li>Peningkatan performance</li>
                        </ul>
                    </div>
                    <div class='ml-30'>
                        <b style='font-size:15px'>Fixed</b>
                        <ul>
                            <li>Fix Bug cicilan selesai tapi status tetap cicilan bukan lunas pada update bayar di order</li>
                            <li>Fix Bug tidak bisa update bayar saat expedisi ambil di toko dan cicilan belum lunas di order</li>
                            <li>Fix Bug upload gambar pada tambah dan edit produk bukan format/extensi gambar</li>
                            <li>Fix Bug tidak bisa redirect saat token email verifikasi salah</li>
                            <li>Fix Bug tidak bisa mengakses profil</li>
                            <li>Fix Bug salah penghitungan varian pada tambah dan edit produk</li>
                            <li>Fix Bug riwayat stok produk tidak terhapus saat produk sudah terhapus</li>
                            <li>Fix Bug error saat subdomain toko sudah digunakan</li>
                            <li>Fix Bug pengaturan customer yang tidak terhubung dengan tambah order</li>
                            <li>Fix Bug varian tidak tampil di bagian list produk di tambah order</li>
                            <li>Fix Bug tidak bisa tambah produk dan edit produk setelah ada error grosir</li>
                            <li>Fix Bug undefined hapus varian di edit produk</li>
                        </ul>
                    </div>
                </div>
                <div class='mb-40'>
                    <h4>v0.3 &nbsp;&nbsp;(24 Feb 2020)</h4>
                    <div class='ml-30'>
                        <b style='font-size:15px'>Added</b>
                        <ul>
                            <li>Penambahan fitur Laporan</li>
                            <li>Penambahan fitur Analisa</li>
                            <li>Penambahan cache data pada Analisa</li>
                            <li>Penambahan cache data pada tambah, edit, hapus Customer</li>
                            <li>Penambahan cache data pada tambah, edit, hapus Kategori Produk</li>
                            <li>Penambahan cache data pada tambah, edit, hapus Expense</li>
                            <li>Penambahan popup konfirmasi cancel order di semua, cari, filter order</li>
                        </ul>
                    </div>
                    <div class='ml-30'>
                        <b style='font-size:15px'>Changed</b>
                        <ul>
                            <li>Perubahan struktur tabel order (database)</li>
                        </ul>
                    </div>
                    <div class='ml-30'>
                        <b style='font-size:15px'>Fixed</b>
                        <ul>
                            <li>Fix Bug pada session login tanpa verifikasi email</li>
                            <li>Fix Bug minor select picker pada Semua, Filter, Cari, Cancel Order</li>
                            <li>Fix Bug pemesan kategori customer di order baru</li>
                            <li>Fix Bug cari produk dengan customer reseller (bagian cari produk) di order baru</li>
                            <li>Fix Bug cari produk dengan varian tidak tampil (bagian cari produk) di order baru</li>
                            <li>Fix Bug tambah dan edit produk (bagian tambah/edit varian produk) di tambah produk dan edit produk</li>
                            <li>Fix Bug popover data customer telah terhapus di semua, filter, cari, cancel order</li>
                            <li>Fix Bug uangFormat error di expense form</li>
                            <li>Fix Bug error via pembayaran dengan bank di bagian detail order</li>
                        </ul>
                    </div>
                </div>
                <div class='mb-40'>
                    <h4>v0.2 &nbsp;&nbsp;(11 Feb 2020)</h4>
                    <div class='ml-30'>
                        <b style='font-size:15px'>Added</b>
                        <ul>
                            <li>Penambahan Email Verification</li>
                            <li>Penambahan Lupa Password</li>
                            <li>Penambahan Version History</li>
                            <li>Penambahan chart Gross Profit di dashboard</li>
                        </ul>
                    </div>
                    <div class='ml-30'>
                        <b style='font-size:15px'>Changed</b>
                        <ul>
                            <li>Perubahan tampilan pada perhitungan order hari ini, order belum diproses, produk terjual, dan gross profit di dashboard</li>
                        </ul>
                    </div>
                    <div class='ml-30'>
                        <b style='font-size:15px'>Fixed</b>
                        <ul>
                            <li>Fix Bug pada rentang grosir di tambah produk</li>
                            <li>Fix Bug map jquery asRange (parse error)</li>
                            <li>Fix Bug class Fungsi not found pada Excel Export</li>
                        </ul>
                    </div>
                </div>
                <div>
                    <h4>v0.1 &nbsp;&nbsp;(7 Feb 2020)</h4>
                    <div class='ml-30'>
                        <b style='font-size:15px'>Added</b>
                        <ul>
                            <li>Penambahan fitur expense</li>
                            <li>Penambahan fitur order</li>
                            <li>Penambahan fitur produk</li>
                            <li>Penambahan fitur kategori produk</li>
                            <li>Penambahan fitur pelanggan</li>
                            <li>Penambahan pengaturan toko</li>
                            <li>Penambahan pengaturan order</li>
                            <li>Penambahan pengaturan cek ongkir</li>
                            <li>Penambahan pengaturan produk</li>
                            <li>Penambahan pengaturan customer</li>
                            <li>Penambahan pengaturan payment</li>
                            <li>Penambahan pengaturan supplier</li>
                            <li>Penambahan pengaturan template</li>
                            <li>Penambahan pengaturan user</li>
                            <li>Penambahan chart produk terjual dan order</li>
                            <li>Penambahan penghitungan order hari ini, order belum diproses, produk terjual, dan gross profit di dashboard</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--uiop-->
@endsection