<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTExpenseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_expense', function (Blueprint $table) {
            $table->bigIncrements('id_expense');
            $table->string('tanggal', 50);
            $table->string('nama_expense', 200);
            $table->unsignedInteger('harga');
            $table->unsignedInteger('jumlah');
            $table->text('note');
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
        Schema::dropIfExists('t_expense');
    }
}
