<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transaksi_penjualan', function (Blueprint $table) {
            $table->id('id_transaksi_penjualan');
            $table->unsignedBigInteger('id_pelanggan')->nullable();
            $table->unsignedBigInteger('id_user');
            $table->decimal('total_biaya', 15, 2);
            $table->timestamp('tanggal_transaksi')->useCurrent();
            $table->string('metode_pembayaran');
            $table->decimal('jumlah_uang', 15, 2);
            $table->decimal('kembalian', 15, 2);
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('id_pelanggan')->references('id_pelanggan')->on('pelanggan')->onDelete('set null');
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::create('detail_transaksi_penjualan', function (Blueprint $table) {
            $table->id('id_detail_transaksi');
            $table->unsignedBigInteger('id_transaksi_penjualan');
            $table->unsignedBigInteger('id_menu');
            $table->string('nama_menu');
            $table->integer('jumlah');
            $table->decimal('harga_satuan', 15, 2);
            $table->decimal('subtotal', 15, 2);
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('id_transaksi_penjualan')->references('id_transaksi_penjualan')->on('transaksi_penjualan')->onDelete('cascade');
            $table->foreign('id_menu')->references('id_menu')->on('menu')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('detail_transaksi_penjualan');
        Schema::dropIfExists('transaksi_penjualan');
    }
};