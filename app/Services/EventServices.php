<?php

namespace App\Services;

use App\Models\Event;
use App\Models\KategoriEvent;
use App\Models\RangeEvent;
use App\Models\EventPeserta;
use Illuminate\Support\Facades\DB;

class EventServices
{
    public $event;
    public $kategoriEvent;
    public $rangeEvent;
    public $eventPeserta;

    public function __construct()
    {
        $this->event = new Event();
        $this->kategoriEvent = new KategoriEvent();
        $this->rangeEvent = new RangeEvent();
        $this->eventPeserta = new EventPeserta();
    }

    public function getData($params = [])
    {
        // dd($params);
        $query = $this->event->select(
            'event.*',
            'kategori_event.nama_kategori',
            'range_event.nama_range',
            'users.name as user',
        )
            ->leftJoin('kategori_event', 'event.id_kategori_event', '=', 'kategori_event.id')
            ->leftJoin('range_event', 'event.id_range_event', '=', 'range_event.id')
            ->leftJoin('users', 'event.id_created_by', '=', 'users.id');

        // If params is a string, treat it as ID
        if (is_string($params) || is_numeric($params)) {
            return $query->where('event.id', $params)->first();
        }

        if (!empty($params) && is_array($params)) {
            if (isset($params['id'])) {
                return $query->where('event.id', $params['id'])->first();
            }
            if (isset($params['slug'])) {
                return $query->where('event.slug', $params['slug'])->first();
            }
            if (isset($params['status'])) {
                $query->where('event.status', $params['status']);
            }
            if (isset($params['kategori'])) {
                $query->where('event.id_kategori_event', $params['kategori']);
            }
            if (isset($params['lingkup'])) {
                $query->where('event.id_range_event', $params['lingkup']);
            }
        }

        return $query->orderBy('event.id', 'desc')->get();
    }

    public function getDataUserByEventPeserta($params = [])
    {
        // dd($params);
        $query = $this->eventPeserta->select(
            'event.*',
            'event_peserta.id as id_event_peserta',
            'event_peserta.id_peserta',
            'event_peserta.status',
            'event_peserta.tanggal_daftar',
            'event_peserta.tanggal_konfirmasi',
            'kategori_event.nama_kategori',
            'range_event.nama_range',
        )
            ->join('event', 'event_peserta.id_event', '=', 'event.id')
            ->leftJoin('kategori_event', 'event.id_kategori_event', '=', 'kategori_event.id')
            ->leftJoin('range_event', 'event.id_range_event', '=', 'range_event.id');

        if (isset($params['slug']) && !empty($params['slug'])) {
            $query->where('event.slug', $params['slug']);
        }
        if (isset($params['user_id']) && !empty($params['user_id'])) {
            $query->where('event_peserta.id_peserta', $params['user_id']);
        }

        return $query->first();
    }
    public function getDataEventByUser($params = [])
    {
        // dd($params);
        $query = $this->eventPeserta->select(
            'event.*',
            'event_peserta.id_peserta',
            'event_peserta.status',
            'event_peserta.tanggal_daftar',
            'event_peserta.tanggal_konfirmasi',
            'kategori_event.nama_kategori',
            'range_event.nama_range',
        )
            ->join('event', 'event_peserta.id_event', '=', 'event.id')
            ->leftJoin('kategori_event', 'event.id_kategori_event', '=', 'kategori_event.id')
            ->leftJoin('range_event', 'event.id_range_event', '=', 'range_event.id')
            ->where('event_peserta.id_peserta', $params['user_id']);

        // dd($query->get());
        // If params is a string, treat it as ID
        return $query->orderBy('event.id', 'desc')->get();
    }

    public function getKategoris()
    {
        return $this->kategoriEvent->where('is_active', true)->orderBy('nama_kategori')->get();
    }

    public function getLingkups()
    {
        return $this->rangeEvent->where('is_active', true)->orderBy('nama_range')->get();
    }

    public function getStatistics()
    {
        return [
            'total_events' => $this->event->count(),
            'events_aktif' => $this->event->where('status', 'published')->count(),
            'events_draft' => $this->event->where('status', 'draft')->count(),
            'events_bulan_ini' => $this->event->whereMonth('created_at', now()->month)->count(),
        ];
    }
}
