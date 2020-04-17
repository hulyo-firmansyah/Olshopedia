<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTGrosirTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_grosir', function (Blueprint $table) {
            $table->bigIncrements('id_grosir');
            $table->unsignedBigInteger('produk_id');
            $table->string('rentan', 30);
            $table->unsignedInteger('harga');
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
        Schema::dropIfExists('t_grosir');
    }
}
