<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailPenjualanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_penjualan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_penjualan')->nullable();
            $table->foreign('id_penjualan')->references('id')->on('penjualan');
            $table->unsignedBigInteger('id_item')->nullable();
            $table->foreign('id_item')->references('id')->on('item');
            $table->double('jml')->default(0);
            $table->unsignedBigInteger('id_satuan')->nullable();
            $table->foreign('id_satuan')->references('id')->on('satuan');
            $table->double('harga')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detail_penjualan');
    }
}
