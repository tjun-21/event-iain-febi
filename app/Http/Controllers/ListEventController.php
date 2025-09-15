<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Services\EventServices;
use App\Models\Event;
use App\Models\EventPeserta;
use Illuminate\Support\Facades\Auth;

class ListEventController extends Controller
{
    public $eventService;
    public function __construct()
    {
        // Middleware sudah diatur di routes/web.php
        $this->eventService = new EventServices;
        // Middleware untuk verifikasi email (opsional)
        // $this->middleware('verified');
    }

    public function index()
    {
        $events = $this->eventService->getData();
        $data = [
            'title' => 'List Events',
            'events' => $events,
        ];

        return view('dashboard.list-events.index', $data);
    }

    public function show(Event $event)
    {
        // Load relationships
        $event->load(['kategori', 'requirements']);

        // Check if current user is already registered
        $isRegistered = false;
        if (user_id()) {
            $isRegistered = EventPeserta::where('id_event', $event->id)
                ->where('id_peserta', user_id())
                ->exists();
        }
        // dd($isRegistered);

        $data = [
            'title' => 'Detail Event - ' . $event->nama_event,
            'event' => $event,
            'isRegistered' => $isRegistered,
        ];

        return view('dashboard.list-events.show', $data);
    }

    public function register(Request $request, Event $event)
    {
        // Check if user is authenticated
        // dd($event);
        if (!isUserLoggedIn()) {
            return response()->json([
                'success' => false,
                'message' => 'Anda harus login terlebih dahulu untuk mendaftar.'
            ], 401);
        }

        // Check if event is published
        if ($event->status !== 'published') {
            return response()->json([
                'success' => false,
                'message' => 'Event ini belum dipublikasi atau sudah dibatalkan.'
            ], 400);
        }

        // Check if registration is still open
        $deadline = \Carbon\Carbon::parse($event->batas_pendaftaran);
        if ($deadline->isPast()) {
            return response()->json([
                'success' => false,
                'message' => 'Pendaftaran untuk event ini sudah ditutup.'
            ], 400);
        }
        // Check if user is already registered
        $existingRegistration = EventPeserta::where('id_event', $event->id)
            ->where('id_peserta', Auth::id())
            ->first();

        if ($existingRegistration) {
            return response()->json([
                'success' => false,
                'message' => 'Anda sudah terdaftar untuk event ini.'
            ], 400);
        }

        try {
            // Create registration
            EventPeserta::create([
                'id_event' => $event->id,
                'id_peserta' => user_id(),
                'status' => 'registered',
                'tanggal_daftar' => now(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Selamat! Anda berhasil mendaftar untuk event "' . $event->nama_event . '".'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mendaftar. Silakan coba lagi.'
            ], 500);
        }
    }
}
