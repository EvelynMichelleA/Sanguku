<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiPenjualan extends Model
{
    use HasFactory;

    protected $table = 'transaksi_penjualan';

    protected $primaryKey = 'id_transaksi_penjualan';

    protected $fillable = [
        'tanggal_transaksi',
        'id', // User ID
        'id_pelanggan', // Pelanggan ID
        'total_biaya',
        'metode_pembayaran',
    ];
    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan');
    }
    public function pengguna()
    {
        return $this->belongsTo(User::class, 'id');
    }
    public function details()
    {
        return $this->hasMany(DetailTransaksiPenjualan::class, 'id_transaksi_penjualan');
    }
}
