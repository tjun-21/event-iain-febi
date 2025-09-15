<?php

namespace App\Services;

use App\Models\KategoriEvent;
// use App\Models\Files;

use Illuminate\Support\Facades\DB;

class KategoriServices
{
    public $kategoriEvent;
    // public $fileDocument;

    public function __construct()
    {
        $this->kategoriEvent = new KategoriEvent();
        // $this->fileDocument = new Files();
    }

    public function getData($params = [])
    {
        $query = $this->kategoriEvent->select('*');
        if (!empty($params)) {
            $query->where('slug', $params)->first();
        }

        return $query->orderBy('kategori_event.id', 'desc')->get();
    }
}
