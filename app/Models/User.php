<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $guard = 'web';

    protected $fillable = [
        'name',
        'email',
        'password',
        'id_role',
        'username'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relasi ke model Role
    public function role()
    {
        return $this->belongsTo(Role::class, 'id_role');
    }

    protected $dates = ['deleted_at'];
}
