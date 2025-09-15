<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_event',
        'nama_sesi',
        'deskripsi',
        'tanggal',
        'jam_mulai',
        'jam_selesai',
        'pembicara',
        'lokasi_sesi',
        'urutan'
    ];

    protected $casts = [
        'tanggal' => 'date',
        'jam_mulai' => 'datetime',
        'jam_selesai' => 'datetime',
        'urutan' => 'integer'
    ];
}
