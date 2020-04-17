<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTRiwayatStokTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_riwayat_stok', function (Blueprint $table) {
            $table->bigIncrements('id_riwayat_stok');
            $table->unsignedBigInteger('varian_id');
            $table->dateTime('tgl');
            $table->text('ket');
            $table->unsignedInteger('jumlah');
            $table->enum('tipe', [
                'masuk',
                'keluar'
            ]);
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
        Schema::dropIfExists('t_riwayat_stok');
    }
}
