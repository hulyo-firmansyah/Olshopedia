<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTBankTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_bank', function (Blueprint $table) {
            $table->bigIncrements('id_bank');
            $table->string('bank', 30);
            $table->string('no_rek', 60)->unique();
            $table->string('cabang', 50);
            $table->string('atas_nama', 100);
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
        Schema::dropIfExists('t_bank');
    }
}
