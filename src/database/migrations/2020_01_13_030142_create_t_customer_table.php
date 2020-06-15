<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTCustomerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_customer', function (Blueprint $table) {
            $table->bigIncrements('id_customer');
            $table->unsignedBigInteger('user_id');
            $table->string('provinsi', 100);
            $table->string('kabupaten', 100);
            $table->string('kecamatan', 100);
            $table->integer('kode_pos');
            $table->text('alamat');
            $table->enum('kategori', [
                'Customer',
                'Reseller',
                'Dropshipper'
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
        Schema::dropIfExists('t_customer');
    }
}
