<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'name',
        'email',
        'password',
        'role',
        'tanggal_lahir',
        'tempat_lahir',
        'umur',
        'agama',
        'no_telp',
        'luas_lahan',
        'status_perkawinan',
        'status_keanggotaan',
        'penghasilan_perbulan',
        'penghasilan_panen',
        'status_pinjaman',
        'pinjaman_sebelumnya',
    ];

    protected $casts = [
        'id' => 'string'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function getPenghasilanPerbulanAttribute($value)
    {
        return 'Rp. ' . number_format($value, 0, ',', '.');
    }

    public function getPenghasilanPanenAttribute($value)
    {
        return 'Rp. ' . number_format($value, 0, ',', '.');
    }
}
