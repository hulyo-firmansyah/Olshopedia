<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_order', function (Blueprint $table) {
            $table->bigIncrements('id_order');
            $table->unsignedBigInteger('urut_order');
            $table->unsignedBigInteger('pemesan_id');
            $table->enum('pemesan_kategori', [
                'Customer',
                'Reseller',
                'Dropshipper'
            ]);
            $table->unsignedBigInteger('tujuan_kirim_id');
            $table->text('kecamatan_asal_kirim_id');
            $table->string('tanggal_order', 60);
            $table->text('pembayaran');
            $table->text('produk');
            $table->text('kurir');
            $table->text('total');
            $table->string('resi', 80)->nullable();
            $table->text('catatan');
            $table->enum('state', [
                'bayar',
                'proses',
                'kirim',
                'terima'
            ])->default('bayar');
            $table->boolean('cicilan_state')->default(false);
            $table->string('src', 80);
            $table->unsignedBigInteger('admin_id')->nullable();
            $table->boolean('canceled')->default(false);
            $table->unsignedBigInteger('order_source_id')->nullable();
            $table->text('kat_customer');
            $table->boolean('print_label')->default(false);
            $table->date('tgl_dibuat');
            $table->date('tgl_diedit')->nullable();
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
        Schema::dropIfExists('t_order');
    }
}
