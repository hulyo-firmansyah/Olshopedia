<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTUserMetaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_user_meta', function (Blueprint $table) {
            $table->bigIncrements('id_user_meta');
            $table->unsignedBigInteger('user_id');
            $table->text('ijin')->nullable();
            $table->enum('role', [
                'SuperAdmin',
                'Owner',
                'Admin',
                'Shipper'
            ]);
            $table->unsignedBigInteger('data_of')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('t_user_meta');
    }
}
