<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pelanggan', function (Blueprint $table) {
            $table->id('id_pelanggan');
            $table->string('nama_pelanggan');
            $table->string('nomor_telepon')->unique();
            $table->string('email_pelanggan')->unique();
            $table->integer('jumlah_poin')->default(0);
            $table->timestamps();
            $table->timestamp('deleted_at')->useCurrent()->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pelanggan');
    }
};
