<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pelanggan extends Model
{
    use HasFactory, Notifiable;

    // Tentukan nama tabel jika tidak mengikuti konvensi Laravel
    protected $table = 'pelanggan';

    // Tentukan primary key tabel
    protected $primaryKey = 'id_pelanggan';

    // Tentukan kolom yang bisa diisi (mass assignable)
    protected $fillable = [
        'nama_pelanggan',
        'nomor_telepon',
        'email_pelanggan',
        'jumlah_poin'
    ];

    // Tentukan jika ada kolom soft delete
    protected $dates = ['deleted_at'];

    // Menyediakan timestamps secara otomatis
    public $timestamps = true;

    
}
