<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTStoreTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_store', function (Blueprint $table) {
            $table->bigIncrements('id_store');
            $table->string("nama_toko", 35)->nullable();
            $table->string("domain_toko", 20)->unique()->nullable();
            $table->string("template", 50)->nullable();
            $table->text("deskripsi_toko")->nullable();
            $table->text("alamat_toko")->nullable();
            $table->string("no_telp_toko", 20)->unique()->nullable();
            $table->enum("s_order_nama", ['on', 'off'])->default('off');
            $table->enum("s_tampil_logo", ['on', 'off'])->default('off');
            $table->enum("s_order_source", ['on', 'off'])->default('off');
            $table->unsignedInteger("stok_produk_limit")->default(20);
            $table->text("kat_customer");
            $table->text("cek_ongkir");
            $table->unsignedBigInteger('foto_id')->nullable();
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
        Schema::dropIfExists('t_store');
    }
}
