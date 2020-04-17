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
            $table->unsignedBigInteger('user_id');
            $table->string('nama_supplier', 60)->nullable();
            $table->string('provinsi', 50);
            $table->string('kabupaten', 50);
            $table->string('kecamatan', 50);
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
