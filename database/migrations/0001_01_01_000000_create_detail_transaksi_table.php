<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detail_transaksi_penjualan', function (Blueprint $table) {
            $table->unsignedBigInteger('id_transaksi_penjualan');
            $table->foreign('id_transaksi_penjualan')->references('id_transaksi_penjualan')->on('transaksi_penjualan')->onDelete('cascade');
            $table->unsignedBigInteger('id_menu');
            $table->foreign('id_menu')->references('id_menu')->on('menu')->onDelete('cascade');
            $table->integer('jumlah');
        });
    }
    
    public function down(): void
    {
        Schema::dropIfExists('detail_transaksi_penjualan');
    }
};
