<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTKonfirmasiBayarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_konfirmasi_bayar', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('order_slug');
            $table->text('atas_nama');
            $table->unsignedInteger('nominal');
            $table->text('bank_tujuan');
            $table->dateTime('tgl_transfer');
            $table->unsignedBigInteger('foto_id');
            $table->text('catatan')->nullable();
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
        Schema::dropIfExists('t_konfirmasi_bayar');
    }
}
