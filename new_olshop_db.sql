-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 20 Apr 2020 pada 04.45
-- Versi server: 10.4.6-MariaDB
-- Versi PHP: 7.3.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `new_olshop_db`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1747, '2014_10_12_100000_create_password_resets_table', 1),
(1748, '2020_01_13_020553_create_users_table', 1),
(1749, '2020_01_13_021225_create_t_varian_produk_table', 1),
(1750, '2020_01_13_022104_create_t_user_meta_table', 1),
(1751, '2020_01_13_022525_create_t_supplier_table', 1),
(1752, '2020_01_13_022908_create_t_riwayat_stok_table', 1),
(1753, '2020_01_13_023339_create_t_produk_table', 1),
(1754, '2020_01_13_023647_create_t_pembayaran_table', 1),
(1755, '2020_01_13_023832_create_t_order_table', 1),
(1756, '2020_01_13_024804_create_t_kategori_produk_table', 1),
(1757, '2020_01_13_024914_create_t_grosir_table', 1),
(1758, '2020_01_13_025141_create_t_foto_table', 1),
(1759, '2020_01_13_025247_create_t_filter_order_table', 1),
(1760, '2020_01_13_025951_create_t_expense_table', 1),
(1761, '2020_01_13_030142_create_t_customer_table', 1),
(1762, '2020_01_16_071455_create_t_store_table', 1),
(1763, '2020_01_17_064844_create_t_order_source_table', 1),
(1764, '2020_01_20_031408_create_t_bank_table', 1),
(1765, '2020_03_09_100105_create_t_log_table', 1),
(1766, '2020_03_23_141800_create_jobs_table', 1),
(1767, '2020_03_24_091246_create_failed_jobs_table', 1),
(1768, '2020_03_27_095945_create_t_addons_table', 1),
(1769, '2020_03_27_115019_create_t_addons_data_table', 1),
(1770, '2020_04_07_104257_create_t_print', 1),
(1771, '2020_04_18_091900_create_t_pembelian_produk_table', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_addons`
--

CREATE TABLE `t_addons` (
  `id_addons` bigint(20) UNSIGNED NOT NULL,
  `notif_resi_email` tinyint(1) NOT NULL DEFAULT 0,
  `notif_wa` tinyint(1) NOT NULL DEFAULT 0,
  `data_of` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_addons_data`
--

CREATE TABLE `t_addons_data` (
  `id_addons_data` bigint(20) UNSIGNED NOT NULL,
  `notif_resi_email` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notif_wa` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `data_of` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_bank`
--

CREATE TABLE `t_bank` (
  `id_bank` bigint(20) UNSIGNED NOT NULL,
  `bank` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_rek` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cabang` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `atas_nama` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `data_of` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_customer`
--

CREATE TABLE `t_customer` (
  `id_customer` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `provinsi` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kabupaten` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kecamatan` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode_pos` int(11) NOT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `kategori` enum('Customer','Reseller','Dropshipper') COLLATE utf8mb4_unicode_ci NOT NULL,
  `data_of` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_expense`
--

CREATE TABLE `t_expense` (
  `id_expense` bigint(20) UNSIGNED NOT NULL,
  `tanggal` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_expense` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `harga` int(10) UNSIGNED NOT NULL,
  `jumlah` int(10) UNSIGNED NOT NULL,
  `note` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `data_of` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_filter_order`
--

CREATE TABLE `t_filter_order` (
  `id_filter_order` bigint(20) UNSIGNED NOT NULL,
  `nama_filter` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `f_admin` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `f_bayar` enum('0','belum','cicil','lunas') COLLATE utf8mb4_unicode_ci NOT NULL,
  `f_kirim` enum('0','belum_proses','belum_resi','dalam_kirim','sudah_tujuan') COLLATE utf8mb4_unicode_ci NOT NULL,
  `f_via` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `f_kurir` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `f_print` enum('0','print','belum_print') COLLATE utf8mb4_unicode_ci NOT NULL,
  `f_tglTipe` enum('bayar','order') COLLATE utf8mb4_unicode_ci NOT NULL,
  `f_orderSource` bigint(20) UNSIGNED NOT NULL,
  `f_tglDari` date DEFAULT NULL,
  `f_tglSampai` date DEFAULT NULL,
  `data_of` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_foto`
--

CREATE TABLE `t_foto` (
  `id_foto` bigint(20) UNSIGNED NOT NULL,
  `path` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `data_of` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_grosir`
--

CREATE TABLE `t_grosir` (
  `id_grosir` bigint(20) UNSIGNED NOT NULL,
  `produk_id` bigint(20) UNSIGNED NOT NULL,
  `rentan` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `harga` int(10) UNSIGNED NOT NULL,
  `data_of` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_kategori_produk`
--

CREATE TABLE `t_kategori_produk` (
  `id_kategori_produk` bigint(20) UNSIGNED NOT NULL,
  `nama_kategori_produk` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `data_of` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_log`
--

CREATE TABLE `t_log` (
  `id_log` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `tanggal_waktu` datetime NOT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `data_of` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_order`
--

CREATE TABLE `t_order` (
  `id_order` bigint(20) UNSIGNED NOT NULL,
  `urut_order` bigint(20) UNSIGNED NOT NULL,
  `pemesan_id` bigint(20) UNSIGNED NOT NULL,
  `pemesan_kategori` enum('Customer','Reseller','Dropshipper') COLLATE utf8mb4_unicode_ci NOT NULL,
  `tujuan_kirim_id` bigint(20) UNSIGNED NOT NULL,
  `kecamatan_asal_kirim_id` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_order` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pembayaran` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `produk` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `kurir` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `total` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `resi` varchar(80) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `catatan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `state` enum('bayar','proses','kirim','terima') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'bayar',
  `cicilan_state` tinyint(1) NOT NULL DEFAULT 0,
  `src` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `admin_id` bigint(20) UNSIGNED DEFAULT NULL,
  `canceled` tinyint(1) NOT NULL DEFAULT 0,
  `order_source_id` bigint(20) UNSIGNED DEFAULT NULL,
  `kat_customer` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `print_label` tinyint(1) NOT NULL DEFAULT 0,
  `tgl_dibuat` date NOT NULL,
  `tgl_diedit` date DEFAULT NULL,
  `data_of` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_order_source`
--

CREATE TABLE `t_order_source` (
  `id_order_source` bigint(20) UNSIGNED NOT NULL,
  `store_id` bigint(20) UNSIGNED NOT NULL,
  `kategori` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  `data_of` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_pembayaran`
--

CREATE TABLE `t_pembayaran` (
  `id_bayar` bigint(20) UNSIGNED NOT NULL,
  `tgl_bayar` varchar(90) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nominal` int(11) NOT NULL,
  `via` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `data_of` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_pembelian_produk`
--

CREATE TABLE `t_pembelian_produk` (
  `id_pembelian_produk` bigint(20) UNSIGNED NOT NULL,
  `no_nota` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `tgl_beli` date NOT NULL,
  `tgl_dibuat` datetime NOT NULL,
  `data_of` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_print`
--

CREATE TABLE `t_print` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ship` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ship_v2` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ship_a6` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `invoice` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `invoice_thermal_88mm` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `data_of` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_produk`
--

CREATE TABLE `t_produk` (
  `id_produk` bigint(20) UNSIGNED NOT NULL,
  `nama_produk` varchar(35) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kategori_produk_id` bigint(20) UNSIGNED DEFAULT NULL,
  `supplier_id` bigint(20) UNSIGNED NOT NULL,
  `berat` int(10) UNSIGNED NOT NULL,
  `ket` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `produk_offset` int(10) UNSIGNED NOT NULL,
  `arsip` tinyint(1) NOT NULL DEFAULT 0,
  `data_of` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_riwayat_stok`
--

CREATE TABLE `t_riwayat_stok` (
  `id_riwayat_stok` bigint(20) UNSIGNED NOT NULL,
  `varian_id` bigint(20) UNSIGNED NOT NULL,
  `tgl` datetime NOT NULL,
  `ket` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `jumlah` int(10) UNSIGNED NOT NULL,
  `tipe` enum('masuk','keluar') COLLATE utf8mb4_unicode_ci NOT NULL,
  `data_of` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_store`
--

CREATE TABLE `t_store` (
  `id_store` bigint(20) UNSIGNED NOT NULL,
  `nama_toko` varchar(35) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `domain_toko` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `template` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deskripsi_toko` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat_toko` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_telp_toko` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `s_order_nama` enum('on','off') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'off',
  `s_tampil_logo` enum('on','off') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'off',
  `s_order_source` enum('on','off') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'off',
  `stok_produk_limit` int(10) UNSIGNED NOT NULL DEFAULT 20,
  `kat_customer` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `cek_ongkir` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `foto_id` bigint(20) UNSIGNED DEFAULT NULL,
  `data_of` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_supplier`
--

CREATE TABLE `t_supplier` (
  `id_supplier` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `nama_supplier` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provinsi` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kabupaten` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kecamatan` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode_pos` int(10) UNSIGNED NOT NULL,
  `jalan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `ket` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `data_of` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_user_meta`
--

CREATE TABLE `t_user_meta` (
  `id_user_meta` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `ijin` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` enum('SuperAdmin','Owner','Admin','Supplier','Shipper') COLLATE utf8mb4_unicode_ci NOT NULL,
  `data_of` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_varian_produk`
--

CREATE TABLE `t_varian_produk` (
  `id_varian` bigint(20) UNSIGNED NOT NULL,
  `produk_id` bigint(20) UNSIGNED NOT NULL,
  `sku_offset` smallint(5) UNSIGNED NOT NULL,
  `sku` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stok` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `harga_beli` int(10) UNSIGNED NOT NULL,
  `diskon_jual` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `harga_jual_normal` int(10) UNSIGNED NOT NULL,
  `harga_jual_reseller` int(10) UNSIGNED DEFAULT NULL,
  `ukuran` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `warna` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `foto_id` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `data_of` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_telp` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `email_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indeks untuk tabel `t_addons`
--
ALTER TABLE `t_addons`
  ADD PRIMARY KEY (`id_addons`);

--
-- Indeks untuk tabel `t_addons_data`
--
ALTER TABLE `t_addons_data`
  ADD PRIMARY KEY (`id_addons_data`);

--
-- Indeks untuk tabel `t_bank`
--
ALTER TABLE `t_bank`
  ADD PRIMARY KEY (`id_bank`),
  ADD UNIQUE KEY `t_bank_no_rek_unique` (`no_rek`);

--
-- Indeks untuk tabel `t_customer`
--
ALTER TABLE `t_customer`
  ADD PRIMARY KEY (`id_customer`);

--
-- Indeks untuk tabel `t_expense`
--
ALTER TABLE `t_expense`
  ADD PRIMARY KEY (`id_expense`);

--
-- Indeks untuk tabel `t_filter_order`
--
ALTER TABLE `t_filter_order`
  ADD PRIMARY KEY (`id_filter_order`);

--
-- Indeks untuk tabel `t_foto`
--
ALTER TABLE `t_foto`
  ADD PRIMARY KEY (`id_foto`);

--
-- Indeks untuk tabel `t_grosir`
--
ALTER TABLE `t_grosir`
  ADD PRIMARY KEY (`id_grosir`);

--
-- Indeks untuk tabel `t_kategori_produk`
--
ALTER TABLE `t_kategori_produk`
  ADD PRIMARY KEY (`id_kategori_produk`);

--
-- Indeks untuk tabel `t_log`
--
ALTER TABLE `t_log`
  ADD PRIMARY KEY (`id_log`);

--
-- Indeks untuk tabel `t_order`
--
ALTER TABLE `t_order`
  ADD PRIMARY KEY (`id_order`);

--
-- Indeks untuk tabel `t_order_source`
--
ALTER TABLE `t_order_source`
  ADD PRIMARY KEY (`id_order_source`);

--
-- Indeks untuk tabel `t_pembayaran`
--
ALTER TABLE `t_pembayaran`
  ADD PRIMARY KEY (`id_bayar`);

--
-- Indeks untuk tabel `t_pembelian_produk`
--
ALTER TABLE `t_pembelian_produk`
  ADD PRIMARY KEY (`id_pembelian_produk`);

--
-- Indeks untuk tabel `t_print`
--
ALTER TABLE `t_print`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `t_produk`
--
ALTER TABLE `t_produk`
  ADD PRIMARY KEY (`id_produk`);

--
-- Indeks untuk tabel `t_riwayat_stok`
--
ALTER TABLE `t_riwayat_stok`
  ADD PRIMARY KEY (`id_riwayat_stok`);

--
-- Indeks untuk tabel `t_store`
--
ALTER TABLE `t_store`
  ADD PRIMARY KEY (`id_store`),
  ADD UNIQUE KEY `t_store_domain_toko_unique` (`domain_toko`),
  ADD UNIQUE KEY `t_store_no_telp_toko_unique` (`no_telp_toko`);

--
-- Indeks untuk tabel `t_supplier`
--
ALTER TABLE `t_supplier`
  ADD PRIMARY KEY (`id_supplier`);

--
-- Indeks untuk tabel `t_user_meta`
--
ALTER TABLE `t_user_meta`
  ADD PRIMARY KEY (`id_user_meta`);

--
-- Indeks untuk tabel `t_varian_produk`
--
ALTER TABLE `t_varian_produk`
  ADD PRIMARY KEY (`id_varian`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1772;

--
-- AUTO_INCREMENT untuk tabel `t_addons`
--
ALTER TABLE `t_addons`
  MODIFY `id_addons` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `t_addons_data`
--
ALTER TABLE `t_addons_data`
  MODIFY `id_addons_data` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `t_bank`
--
ALTER TABLE `t_bank`
  MODIFY `id_bank` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `t_customer`
--
ALTER TABLE `t_customer`
  MODIFY `id_customer` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `t_expense`
--
ALTER TABLE `t_expense`
  MODIFY `id_expense` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `t_filter_order`
--
ALTER TABLE `t_filter_order`
  MODIFY `id_filter_order` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `t_foto`
--
ALTER TABLE `t_foto`
  MODIFY `id_foto` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `t_grosir`
--
ALTER TABLE `t_grosir`
  MODIFY `id_grosir` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `t_kategori_produk`
--
ALTER TABLE `t_kategori_produk`
  MODIFY `id_kategori_produk` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `t_log`
--
ALTER TABLE `t_log`
  MODIFY `id_log` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `t_order`
--
ALTER TABLE `t_order`
  MODIFY `id_order` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `t_order_source`
--
ALTER TABLE `t_order_source`
  MODIFY `id_order_source` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `t_pembayaran`
--
ALTER TABLE `t_pembayaran`
  MODIFY `id_bayar` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `t_pembelian_produk`
--
ALTER TABLE `t_pembelian_produk`
  MODIFY `id_pembelian_produk` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `t_print`
--
ALTER TABLE `t_print`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `t_produk`
--
ALTER TABLE `t_produk`
  MODIFY `id_produk` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `t_riwayat_stok`
--
ALTER TABLE `t_riwayat_stok`
  MODIFY `id_riwayat_stok` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `t_store`
--
ALTER TABLE `t_store`
  MODIFY `id_store` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `t_supplier`
--
ALTER TABLE `t_supplier`
  MODIFY `id_supplier` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `t_user_meta`
--
ALTER TABLE `t_user_meta`
  MODIFY `id_user_meta` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `t_varian_produk`
--
ALTER TABLE `t_varian_produk`
  MODIFY `id_varian` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
