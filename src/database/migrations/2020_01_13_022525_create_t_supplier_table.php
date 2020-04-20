<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTSupplierTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_supplier', function (Blueprint $table) {
            $table->bigIncrements('id_supplier');
            $table->string('nama_supplier', 100)->nullable();
            $table->string('provinsi', 80);
            $table->string('kabupaten', 80);
            $table->string('kecamatan', 80);
            $table->unsignedInteger('kode_pos');
            $table->text('jalan');
            $table->text('ket');
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
        Schema::dropIfExists('t_supplier');
    }
}
