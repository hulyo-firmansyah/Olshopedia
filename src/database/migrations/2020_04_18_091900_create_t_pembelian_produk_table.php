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
            $table->dateTime('tgl');
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
