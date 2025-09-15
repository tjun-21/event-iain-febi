<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Requirement;
use App\Services\RequirementServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventRequirementController extends Controller
{
    protected $requirementService;

    public function __construct(RequirementServices $requirementService)
    {
        $this->requirementService = $requirementService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index($eventId)
    {
        $event = Event::findOrFail($eventId);
        $requirements = $this->requirementService->getByEventId($eventId);

        $data = [
            'title' => 'Requirements Event: ' . $event->nama_event,
            'event' => $event,
            'requirements' => $requirements
        ];

        return view('dashboard.event-requirements.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($eventId)
    {
        $event = Event::findOrFail($eventId);

        $data = [
            'title' => 'Tambah Requirement - ' . $event->nama_event,
            'event' => $event
        ];

        return view('dashboard.event-requirements.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $eventId)
    {
        $event = Event::findOrFail($eventId);

        $request->validate([
            'deskripsi' => 'required|string',
        ]);

        try {
            $data = [
                'deskripsi' => $request->deskripsi,
                'event_id' => $eventId,
            ];

            $this->requirementService->create($data);

            return redirect()
                ->route('event-requirements.index', $eventId)
                ->with('success', 'Requirement berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Gagal menambahkan requirement: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($eventId, $requirementId)
    {
        $event = Event::findOrFail($eventId);
        $requirement = $this->requirementService->getById($requirementId);
        // dd($requirement);

        if (!$requirement || $requirement->event_id != $eventId) {
            abort(404);
        }

        $data = [
            'title' => 'Detail Requirement - ' . $event->nama_event,
            'event' => $event,
            'requirement' => $requirement
        ];

        return view('dashboard.event-requirements.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($eventId, $requirementId)
    {
        $event = Event::findOrFail($eventId);
        $requirement = $this->requirementService->getById($requirementId);

        if (!$requirement || $requirement->event_id != $eventId) {
            abort(404);
        }

        $data = [
            'title' => 'Edit Requirement - ' . $event->nama_event,
            'event' => $event,
            'requirement' => $requirement
        ];

        return view('dashboard.event-requirements.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $eventId, $requirementId)
    {
        $event = Event::findOrFail($eventId);
        $requirement = $this->requirementService->getById($requirementId);

        if (!$requirement || $requirement->event_id != $eventId) {
            abort(404);
        }

        $request->validate([
            'deskripsi' => 'required|string',
        ]);

        try {
            $data = [
                'deskripsi' => $request->deskripsi,
            ];

            $this->requirementService->update($requirementId, $data);

            return redirect()
                ->route('event-requirements.index', $eventId)
                ->with('success', 'Requirement berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Gagal memperbarui requirement: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($eventId, $requirementId)
    {
        $event = Event::findOrFail($eventId);
        $requirement = $this->requirementService->getById($requirementId);

        if (!$requirement || $requirement->event_id != $eventId) {
            abort(404);
        }

        try {
            $this->requirementService->delete($requirementId);

            return redirect()
                ->route('event-requirements.index', $eventId)
                ->with('success', 'Requirement berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Gagal menghapus requirement: ' . $e->getMessage());
        }
    }
}
