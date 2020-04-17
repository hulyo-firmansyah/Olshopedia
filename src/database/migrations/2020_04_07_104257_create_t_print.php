<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTPrint extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_print', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('ship')->nullable();
            $table->text('ship_v2')->nullable();
            $table->text('ship_a6')->nullable();
            $table->text('invoice')->nullable();
            $table->text('invoice_thermal_88mm')->nullable();
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
        Schema::dropIfExists('t_print');
    }
}
