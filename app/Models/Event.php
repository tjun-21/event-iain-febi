<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $table = 'event';

    protected $fillable = [
        'nama_event',
        'slug',
        'deskripsi',
        // 'deskripsi_singkat',
        'id_kategori_event',
        'id_range_event',
        'id_created_by',
        'tanggal_mulai',
        'tanggal_selesai',
        'batas_pendaftaran',
        'batas_submission',
        // 'jam_mulai',
        // 'jam_selesai',
        // 'lokasi',
        // 'alamat_lengkap',
        // 'is_online',
        // 'platform_online',
        // 'link_event',
        'status',
        'banner_image'
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
        'batas_pendaftaran' => 'date',
        'batas_submission' => 'date',
        // 'jam_mulai' => 'datetime',
        // 'jam_selesai' => 'datetime',
        // 'is_online' => 'boolean'
    ];

    // Relationships
    public function kategori()
    {
        return $this->belongsTo(KategoriEvent::class, 'id_kategori_event');
    }

    // public function lingkup()
    // {
    //     return $this->belongsTo(RangeEvent::class, 'id_range_event');
    // }

    // public function creator()
    // {
    //     return $this->belongsTo(User::class, 'id_created_by');
    // }

    /**
     * Relationship to requirements
     */
    public function requirements()
    {
        return $this->hasMany(Requirement::class, 'event_id');
    }
}
