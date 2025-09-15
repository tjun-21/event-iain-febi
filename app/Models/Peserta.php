<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peserta extends Model
{
    use HasFactory;

    protected $table = 'peserta';

    protected $fillable = [
        'nama',
        'nik',
        'jenis_peserta',
        'nim',
        'asal',
        'email',
        'password',
        'no_telepon',
        'jenis_kelamin',
        'alamat',
        'roles_id',
        'status_pendaftaran',
        'tanggal_daftar'
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'tanggal_daftar' => 'datetime'
    ];
}
