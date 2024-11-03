<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('menu', function (Blueprint $table) {
            $table->id('id_menu');
            $table->string('nama_menu');
            $table->float('harga', 10, 2);
            $table->string('jenis_menu');
            $table->string('gambar_menu');
            $table->timestamps();
            $table->timestamp('deleted_at')->useCurrent()->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('menu');
    }
};
