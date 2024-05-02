<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailPembelianTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_pembelian', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_pembelian')->nullable();
            $table->foreign('id_pembelian')->references('id')->on('pembelian');
            $table->unsignedBigInteger('id_item')->nullable();
            $table->foreign('id_item')->references('id')->on('item');
            $table->double('jml')->default(0);
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
        Schema::dropIfExists('detail_pembelian');
    }
}
