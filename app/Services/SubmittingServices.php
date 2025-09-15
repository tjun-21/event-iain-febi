<?php

namespace App\Services;

// use App\Models\Event;
// use App\Models\KategoriEvent;
// use App\Models\RangeEvent;
use Illuminate\Support\Facades\DB;

class SubmittingServices
{
    public $event;
    public $kategoriEvent;
    public $rangeEvent;

    public function __construct()
    {
        // $this->event = new Event();
        // $this->kategoriEvent = new KategoriEvent();
        // $this->rangeEvent = new RangeEvent();
    }

    public function getData($params = [])
    {
        // dd($params);
        // $query = $this->event->select('event.*', 'kategori_event.nama_kategori', 'range_event.nama_range', 'users.name as user')
        //     ->leftJoin('kategori_event', 'event.id_kategori_event', '=', 'kategori_event.id')
        //     ->leftJoin('range_event', 'event.id_range_event', '=', 'range_event.id')
        //     ->leftJoin('users', 'event.id_created_by', '=', 'users.id');

        // // If params is a string, treat it as ID
        // if (is_string($params) || is_numeric($params)) {
        //     return $query->where('event.id', $params)->first();
        // }

        // if (!empty($params) && is_array($params)) {
        //     if (isset($params['id'])) {
        //         return $query->where('event.id', $params['id'])->first();
        //     }
        //     if (isset($params['slug'])) {
        //         return $query->where('event.slug', $params['slug'])->first();
        //     }
        //     if (isset($params['status'])) {
        //         $query->where('event.status', $params['status']);
        //     }
        //     if (isset($params['kategori'])) {
        //         $query->where('event.id_kategori_event', $params['kategori']);
        //     }
        //     if (isset($params['lingkup'])) {
        //         $query->where('event.id_range_event', $params['lingkup']);
        //     }
        // }

        // return $query->orderBy('event.id', 'desc')->get();
    }
}
