<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengeluaran', function (Blueprint $table) {
            $table->id('id_pengeluaran');
            $table->unsignedBigInteger('id');
            $table->foreign('id')->references('id')->on('users')->onDelete('cascade');
            $table->string('nama_pengeluaran');
            $table->float('total_pengeluaran', 10, 2);
            $table->timestamp('tanggal_pengeluaran')->useCurrent(); 
            $table->string('keterangan_pengeluaran'); 
            $table->timestamps();
            $table->timestamp('deleted_at')->useCurrent()->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengeluaran');
    }
};
