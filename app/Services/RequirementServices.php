<?php

namespace App\Services;

use App\Models\Requirement;
use App\Models\Event;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;

class RequirementServices
{
    public $requirement;

    public function __construct()
    {
        $this->requirement = new Requirement();
    }

    /**
     * Get all requirements with optional filters
     */
    public function getData($params = [])
    {
        $query = $this->requirement->with(['event']);

        if (isset($params['search']) && !empty($params['search'])) {
            $search = $params['search'];
            $query->where(function ($q) use ($search) {
                $q->where('deskripsi', 'like', '%' . $search . '%')
                    ->orWhereHas('event', function ($eventQuery) use ($search) {
                        $eventQuery->where('nama_event', 'like', '%' . $search . '%');
                    });
            });
        }

        if (isset($params['event_id']) && !empty($params['event_id'])) {
            $query->where('event_id', $params['event_id']);
        }

        $perPage = $params['per_page'] ?? 10;

        return $query->orderBy('created_at', 'desc')->paginate($perPage);
    }

    /**
     * Get requirements by event ID
     */
    public function getByEventId($eventId)
    {
        return $this->requirement->where('event_id', $eventId)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Get requirement by ID
     */
    public function getById($id)
    {
        return $this->requirement->with(['event'])->find($id);
    }

    /**
     * Create new requirement
     */
    public function create($data)
    {
        try {
            DB::beginTransaction();

            // Validate event exists
            $event = Event::find($data['event_id']);
            if (!$event) {
                throw new \Exception('Event tidak ditemukan');
            }

            $requirement = $this->requirement->create([
                'deskripsi' => $data['deskripsi'],
                'event_id' => $data['event_id'],
            ]);

            DB::commit();
            return $requirement;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    /**
     * Update requirement
     */
    public function update($id, $data)
    {
        try {
            DB::beginTransaction();

            $requirement = $this->requirement->find($id);
            if (!$requirement) {
                throw new \Exception('Requirement tidak ditemukan');
            }

            $requirement->update([
                'deskripsi' => $data['deskripsi'],
            ]);

            DB::commit();
            return $requirement;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    /**
     * Delete requirement
     */
    public function delete($id)
    {
        try {
            DB::beginTransaction();

            $requirement = $this->requirement->find($id);
            if (!$requirement) {
                throw new \Exception('Requirement tidak ditemukan');
            }

            $requirement->delete();

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    /**
     * Get all events for dropdown
     */
    public function getEventsList()
    {
        return Event::select('id', 'nama_event')
            ->orderBy('nama_event')
            ->get();
    }

    /**
     * Count requirements by event
     */
    public function countByEvent($eventId)
    {
        return $this->requirement->where('event_id', $eventId)->count();
    }
}
