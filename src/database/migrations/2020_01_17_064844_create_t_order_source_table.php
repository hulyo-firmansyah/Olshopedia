<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTOrderSourceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_order_source', function (Blueprint $table) {
            $table->bigIncrements('id_order_source');
            $table->unsignedBigInteger('store_id');
            $table->string('kategori', 30);
            $table->text('keterangan')->nullable();
            $table->boolean('status');
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
        Schema::dropIfExists('t_order_source');
    }
}
