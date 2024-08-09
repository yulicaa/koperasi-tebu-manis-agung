<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Upload extends Model
{
    protected $table = 'upload';
    protected $fillable = [
        'id',
        'parent_id',
        'file_name',
        'file_type',
        'created_at'
    ];

    protected $casts = [
        'id' => 'string'
    ];
}
