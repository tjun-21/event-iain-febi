<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Requirement extends Model
{
    use HasFactory;

    // Nama tabel (optional, karena Laravel sudah otomatis plural)
    protected $table = 'requirement';

    // Kolom yang bisa diisi mass-assignment
    protected $fillable = [
        'deskripsi',
        'event_id',
    ];

    // Casting tipe data
    protected $casts = [];

    // Relationship ke JenisRequirement

    // Relationship ke Event
    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }
}
