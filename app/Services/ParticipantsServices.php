<?php

namespace App\Services;

use App\Models\EventPeserta;
// use App\Models\KategoriEvent;
// use App\Models\RangeEvent;
use Illuminate\Support\Facades\DB;

class ParticipantsServices
{
    public $eventPeserta;

    public function __construct()
    {
        $this->eventPeserta = new EventPeserta();
    }

    public function getData($params = [])
    {
        $query = $this->eventPeserta
            ->join('event', 'event_peserta.id_event', '=', 'event.id')
            ->join('peserta', 'peserta.id', '=', 'event_peserta.id_peserta')
            ->select(
                'event.nama_event',
                'event.slug as event_slug',
                'event.tanggal_mulai',
                'event.tanggal_selesai',
                'event_peserta.id_peserta as id',
                'event_peserta.id_event',
                'peserta.nama',
                'peserta.asal',
                'peserta.jenis_kelamin',
                'peserta.tanggal_daftar as tanggal_registrasi_akun',
                'event_peserta.status',
                'event_peserta.tanggal_daftar as tanggal_pendaftaran',
                'event_peserta.tanggal_konfirmasi',
            );

        // Jika ada parameter id, return data dengan id tersebut
        if (!empty($params) && is_array($params) && isset($params['id'])) {
            return $query->where('event_peserta.id', $params['id'])->first();
        }

        // Jika ada parameter slug, filter event
        // if (!empty($params) && is_array($params) && isset($params['slug'])) {
        //     $query->where('event.slug', $params['slug']);
        // }

        return $query->orderBy('event_peserta.id', 'desc')->get();
    }

    public function getDetailParticipant($params = [])
    {
        // dd($params);
        $query = $this->eventPeserta
            ->join('event', 'event_peserta.id_event', '=', 'event.id')
            ->join('peserta', 'peserta.id', '=', 'event_peserta.id_peserta')
            ->select(
                'event.nama_event',
                'event.slug as event_slug',
                'event.tanggal_mulai',
                'event.tanggal_selesai',
                'event_peserta.id_peserta as id',
                'event_peserta.id_event',
                'peserta.*',
                'event_peserta.status',
                'event_peserta.tanggal_daftar as tanggal_pendaftaran',
                'event_peserta.tanggal_konfirmasi',
            );

        // Jika ada parameter id, return data dengan id tersebut
        if (!empty($params) && is_array($params) && isset($params['id'])) {
            return $query->where('event_peserta.id_peserta', $params['id'])->first();
        }

        return $query->orderBy('event_peserta.id', 'desc')->get();
    }


    // public function getStatistics()
    // {
    //     return [
    //         'total_events' => $this->event->count(),
    //         'events_aktif' => $this->event->where('status', 'published')->count(),
    //         'events_draft' => $this->event->where('status', 'draft')->count(),
    //         'events_bulan_ini' => $this->event->whereMonth('created_at', now()->month)->count(),
    //     ];
    // }
}
