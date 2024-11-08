<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailTransaksiPenjualan extends Model
{
    use HasFactory;

    protected $table = 'detail_transaksi_penjualan';
    protected $fillable = [
        'id_transaksi_penjualan', 'id_menu', 'jumlah'
    ];

    public function transaksi()
    {
        return $this->belongsTo(TransaksiPenjualan::class, 'id_transaksi_penjualan');
    }
}
