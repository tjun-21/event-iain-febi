<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriEvent extends Model
{
    use HasFactory;

    protected $table = 'kategori_event';

    protected $fillable = [
        'nama_kategori',
        'slug',
        'deskripsi',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];
}
