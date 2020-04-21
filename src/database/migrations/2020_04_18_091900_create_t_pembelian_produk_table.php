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
            $table->text('no_nota');
            $table->text('data');
            $table->date('tgl_beli');
            $table->dateTime('tgl_dibuat');
            $table->dateTime('tgl_diedit')->nullable();
            $table->unsignedBigInteger('admin_id');
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
