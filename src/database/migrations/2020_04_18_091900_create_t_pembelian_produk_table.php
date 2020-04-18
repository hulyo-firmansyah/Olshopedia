<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTPembelianProdukTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_pembelian_produk', function (Blueprint $table) {
            $table->bigIncrements('id_pembelian_produk');
            $table->unsignedBigInteger('produk_id');
            $table->unsignedBigInteger('varian_produk_id');
            $table->enum('tipe_beli', [
                'tambah_stok',
                'tambah_varian'
            ])->default('tambah_stok');
            $table->text('data')->nullable();
            $table->unsignedBigInteger('data_of');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('t_pembelian_produk');
    }
}
