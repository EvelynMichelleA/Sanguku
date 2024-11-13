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
        'id_pelanggan',
        'id_user',
        'total_biaya',
        'tanggal_transaksi',
        'metode_pembayaran'
    ];

    // Relasi ke pelanggan
    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan');
    }

    // Relasi ke user (yang melakukan transaksi)
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    // Relasi ke detail transaksi penjualan
    public function details()
    {
        return $this->hasMany(DetailTransaksiPenjualan::class, 'id_transaksi_penjualan');
    }
}

class DetailTransaksiPenjualan extends Model
{
    use HasFactory;

    protected $table = 'detail_transaksi_penjualan';
    protected $primaryKey = 'id_detail_transaksi';
    protected $fillable = [
        'id_transaksi_penjualan',
        'id_menu',
        'nama_menu',
        'jumlah',
        'harga_satuan',
        'subtotal'
    ];

    // Relasi ke transaksi penjualan
    public function transaksi()
    {
        return $this->belongsTo(TransaksiPenjualan::class, 'id_transaksi_penjualan');
    }

    // Relasi ke menu
    public function menu()
    {
        return $this->belongsTo(Menu::class, 'id_menu');
    }
}
