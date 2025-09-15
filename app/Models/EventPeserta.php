<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventPeserta extends Model
{
    use HasFactory;

    protected $table = 'event_peserta';

    protected $fillable = [
        'id_event',
        'id_peserta',
        'status',
        'tanggal_daftar',
        'tanggal_konfirmasi',
        'catatan_admin',
        // 'biaya_dibayar',
        'status_pembayaran'
    ];

    protected $casts = [
        'tanggal_daftar' => 'datetime',
        'tanggal_konfirmasi' => 'datetime',
        // 'biaya_dibayar' => 'decimal:2'
    ];
}
