<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    protected $table = 'file';

    protected $fillable = [
        'original_name',
        'file_path',
        'id_peserta',
        'id_event',
        'file_category',
        'description',
        'status'
    ];

    protected $casts = [
        'file_size' => 'integer'
    ];
}
