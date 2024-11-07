<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pengeluaran extends Model
{
    
    use HasFactory, SoftDeletes;

    protected $table = 'pengeluaran'; // Specify the table name if it's not the plural form

    protected $primaryKey = 'id_pengeluaran'; // Set the primary key if it's not 'id'
    public $incrementing = true; // Primary key menggunakan auto increment
    protected $keyType = 'int'; // Tipe data primary key

    protected $fillable = [
        'id', // Foreign key ke tabel users
        'nama_pengeluaran',
        'total_pengeluaran',
        'tanggal_pengeluaran',
        'keterangan_pengeluaran',
    ];
    

    // Define any relationships if necessary, for example, to a User model
    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'id');
    }
}
