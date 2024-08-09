<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Laporan extends Model
{
    protected $table = 'laporan';

    protected $fillable = [
        'id',
        'pinjaman_id',
        'status'
    ];

    protected $casts = [
        'id' => 'string'
    ];

    public function pinjaman()
    {
        return $this->belongsTo(Pinjaman::class, 'pinjaman_id');
    }
}
