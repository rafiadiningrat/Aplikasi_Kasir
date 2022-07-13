<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransaksiPembelianBarangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksi_pembelian_barangs', function (Blueprint $table) {
            $table->id();
            $table->float('jumlah', 8, 2);
            $table->float('harga_satuan', 8, 2);
            $table->unsignedBigInteger('master_barangs_id');
            $table->foreign('master_barangs_id')->references('id')->on('master_barangs')->onUpdate('cascade')
            ->onDelete('cascade');
            $table->unsignedBigInteger('transaksi_pembelian_id');
            $table->foreign('transaksi_pembelian_id')->references('id')->on('transaksi_pembelians')->onUpdate('cascade')
            ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaksi_pembelian_barangs');
    }
}
