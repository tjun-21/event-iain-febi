<?php

namespace App\Services;

use App\Models\RangeEvent;
use Illuminate\Support\Facades\DB;

class LingkupServices
{
    public $rangeEvent;

    public function __construct()
    {
        $this->rangeEvent = new RangeEvent();
    }

    public function getData($params = [])
    {
        $query = $this->rangeEvent->select('*');
        if (!empty($params)) {
            $query->where('slug', $params)->first();
        }

        return $query->orderBy('id', 'desc')->get();
    }
}
