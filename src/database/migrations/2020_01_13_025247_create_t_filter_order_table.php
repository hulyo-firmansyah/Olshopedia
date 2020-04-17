<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTFilterOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_filter_order', function (Blueprint $table) {
            $table->bigIncrements('id_filter_order');
            $table->string('nama_filter', 100);
            $table->string('f_admin', 60);
            $table->enum('f_bayar', [
                '0',
                'belum',
                'cicil',
                'lunas'
            ]);
            $table->enum('f_kirim', [
                '0',
                'belum_proses',
                'belum_resi',
                'dalam_kirim',
                'sudah_tujuan'
            ]);
            $table->string('f_via', 60);
            $table->string('f_kurir', 80);
            $table->enum('f_print', [
                '0',
                'print',
                'belum_print'
            ]);
            $table->enum('f_tglTipe', [
                'bayar',
                'order'
            ]);
            $table->unsignedBigInteger('f_orderSource');
            $table->date('f_tglDari')->nullable();
            $table->date('f_tglSampai')->nullable();
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
        Schema::dropIfExists('t_filter_order');
    }
}
