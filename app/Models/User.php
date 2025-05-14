<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; // Penting untuk autentikasi
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable // Pastikan extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array // Di Laravel 10+
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    // Jika menggunakan Laravel < 10, gunakan $casts property:
    // protected $casts = [
    //     'email_verified_at' => 'datetime',
    // ];

    public function karyawan()
    {
        return $this->hasOne(Karyawan::class);
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isKaryawan()
    {
        return $this->role === 'karyawan';
    }
}