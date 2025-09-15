<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RangeEvent extends Model
{
    use HasFactory;

    protected $table = 'range_event';

    protected $fillable = [
        'nama_range',
        'slug',
        'deskripsi',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];
}
