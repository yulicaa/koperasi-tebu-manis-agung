<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Tagihan extends Model
{
    protected $table = 'tagihan';

    protected $fillable = [
        'id',
        'pinjaman_id',
        'angsuran',
        'tagihan_pokok',
        'tunggakan',
        'total_tagihan',
        'jatuh_tempo',
        'status'
    ];

    protected $casts = [
        'id' => 'string'
    ];

    public function pinjaman()
    {
        return $this->belongsTo(Pinjaman::class, 'pinjaman_id');
    }

    public function user()
    {
        return $this->hasOneThrough(User::class, Pinjaman::class, 'id', 'id', 'pinjaman_id', 'user_id');
    }

    public function getTagihanPokokAttribute($value)
    {
        return 'Rp. ' . number_format($value, 0, ',', '.');
    }

    public function getTunggakanAttribute($value)
    {
        return 'Rp. ' . number_format($value, 0, ',', '.');
    }

    public function getTotalTagihanAttribute($value)
    {
        return 'Rp. ' . number_format($value, 0, ',', '.');
    }
}
