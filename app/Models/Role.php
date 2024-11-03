<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $table = 'role'; // Nama tabel di database
    protected $primaryKey = 'id_role';

    // Relasi One-to-Many dengan model User
    public function user()
    {
        return $this->hasMany(user::class, 'role_id', 'id_role');
    }
}
