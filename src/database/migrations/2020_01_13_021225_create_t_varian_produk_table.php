<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTVarianProdukTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_varian_produk', function (Blueprint $table) {
            $table->bigIncrements('id_varian');
            $table->unsignedBigInteger('produk_id');
            $table->unsignedSmallInteger("sku_offset");
            $table->string("sku", 30)->nullable();
            $table->string("stok", 20); 
            $table->unsignedInteger("harga_beli");
            $table->string("diskon_jual", 30)->nullable();
            $table->unsignedInteger("harga_jual_normal");
            $table->unsignedInteger("harga_jual_reseller")->nullable();
            $table->string("ukuran", 50)->nullable();
            $table->string("warna", 50)->nullable();
            $table->text("foto_id")->nullable();
            $table->unsignedBigInteger("data_of");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('t_varian_produk');
    }
}
