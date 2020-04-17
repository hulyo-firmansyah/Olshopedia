<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTProdukTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_produk', function (Blueprint $table) {
            $table->bigIncrements('id_produk');
            $table->string('nama_produk', 35);
            $table->unsignedBigInteger('kategori_produk_id')->nullable();
            $table->unsignedBigInteger('supplier_id');
            $table->unsignedInteger('berat');
            $table->text('ket')->nullable();
            $table->unsignedInteger('produk_offset');
            $table->boolean('arsip')->default(false);
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
        Schema::dropIfExists('t_produk');
    }
}
