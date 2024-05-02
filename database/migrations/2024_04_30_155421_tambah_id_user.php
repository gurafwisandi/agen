<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TambahIdUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('penjualan', function (Blueprint $table) {
            $table->unsignedBigInteger('id_user')->nullable()->after('id_customer');
            $table->foreign('id_user')->references('id')->on('users');
            $table->double('total_bayar')->default(0)->after('id_user');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('penjualan', function (Blueprint $table) {
            $table->dropForeign(['id_user']);
            $table->dropColumn('id_user');
            $table->dropColumn('total_bayar');
        });
    }
}
