<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransaksiPenjualan extends Model
{
    protected $table = 'transaksi_penjualan';

    protected $primaryKey = 'id_transaksi_penjualan';

    protected $fillable = [
        'id_pelanggan',
        'id_pengguna',
        'total_biaya',
        'tanggal_transaksi',
        'metode_pembayaran'
    ];

    /**
     * Relasi ke model Pelanggan
     */
    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan');
    }

    /**
     * Relasi ke model User
     */
    public function pengguna()
    {
        return $this->belongsTo(User::class, 'id');
    }
}
