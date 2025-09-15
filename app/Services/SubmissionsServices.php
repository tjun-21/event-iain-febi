<?php

namespace App\Services;

use App\Models\File;
use App\Models\Peserta;
// use App\Models\KategoriEvent;
// use App\Models\RangeEvent;
use Illuminate\Support\Facades\DB;

class SubmissionsServices
{
    public $file;
    public $peserta;
    // public $rangeEvent;

    public function __construct()
    {
        $this->file = new File();
        $this->peserta = new Peserta();
        // $this->kategoriEvent = new KategoriEvent();
        // $this->rangeEvent = new RangeEvent();
    }

    public function getData($params = [])
    {
        // dd($params);
        $query = $this->peserta->select(
            'file.id as id_file',
            'file.original_name',
            'file.status as file_status',
            'file.created_at as file_uploaded_at',
            'file.file_path',
            'file.original_name',
            'event.id as id_event',
            'event.nama_event',
            'event.slug',
            'event_peserta.id_event',
            'event_peserta.id_peserta',
            'event_peserta.status',
            'event_peserta.tanggal_konfirmasi',
            'kategori_event.nama_kategori',
            'range_event.nama_range',
            'peserta.id as id_peserta',
            'peserta.nama as nama_peserta',
        )
            ->join('event_peserta', 'peserta.id', '=', 'event_peserta.id_peserta')
            ->leftJoin('file', 'event_peserta.id', '=', 'file.id_event_peserta')
            ->leftJoin('event', 'event_peserta.id_event', '=', 'event.id')
            ->leftJoin('kategori_event', 'event.id_kategori_event', '=', 'kategori_event.id')
            ->leftJoin('range_event', 'event.id_range_event', '=', 'range_event.id');

        // Filter by event slug if provided
        if (isset($params['slug']) && !empty($params['slug'])) {
            $query->where('event.slug', $params['slug']);
        }

        // If params is a string, treat it as ID
        // dd($query->get());


        return $query->orderBy('event.id', 'desc')->get();
    }
}
