<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTPembayaranTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_pembayaran', function (Blueprint $table) {
            $table->bigIncrements('id_bayar');
            $table->string('tgl_bayar', 90);
            $table->integer('nominal');
            $table->string('via', 30);
            $table->unsignedBigInteger('order_id');
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
        Schema::dropIfExists('t_pembayaran');
    }
}
