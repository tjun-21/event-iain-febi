<?php

namespace App\Http\Controllers\Events;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

// load service 
use App\Services\EventServices;

class EventsController extends Controller
{
    public $eventService;

    public function __construct()
    {
        $this->eventService = new EventServices;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = $this->eventService->getData();
        $statistics = $this->eventService->getStatistics();

        $data = [
            'title' => 'Manajemen Event',
            'events' => $events,
            'statistics' => $statistics,
        ];

        return view('dashboard.events.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategoris = $this->eventService->getKategoris();
        $lingkups = $this->eventService->getLingkups();

        $data = [
            'title' => 'Tambah Event Baru',
            'kategoris' => $kategoris,
            'lingkups' => $lingkups,
        ];

        return view('dashboard.events.form', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Validasi input
            $validated = $request->validate([
                'nama_event' => 'required|string|max:255',
                'slug' => 'string|max:255|unique:event,slug',
                'deskripsi_singkat' => 'nullable|string|max:500',
                'deskripsi' => 'nullable|string',
                'id_kategori_event' => 'exists:kategori_event,id',
                'id_range_event' => 'exists:range_event,id',
                'tanggal_mulai' => 'required|date',
                'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
                'batas_pendaftaran' => 'date|before_or_equal:tanggal_mulai',
                'batas_submission' => 'nullable|date|before_or_equal:tanggal_mulai',
                'jam_mulai' => 'required|date_format:H:i',
                'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
                'lokasi' => 'string|max:255',
                'alamat_lengkap' => 'nullable|string',
                'is_online' => 'nullable|boolean',
                'platform_online' => 'nullable|string|max:255',
                'link_event' => 'nullable|url',
                'status' => 'required|in:draft,published,cancelled',
                'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            // Handle file upload
            if ($request->hasFile('banner_image')) {
                $file = $request->file('banner_image');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads/events'), $filename);
                $validated['banner_image'] = 'uploads/events/' . $filename;
            }

            // Set created by
            $validated['id_created_by'] = auth()->id() ?? 1; // Default ke 1 jika tidak ada auth

            // Simpan data ke database
            $event = Event::create($validated);

            // Jika berhasil, redirect dengan pesan sukses
            return redirect_with_success('events.index', 'Event "' . $event->nama_event . '" berhasil ditambahkan!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Jika validasi gagal, kembalikan dengan error validasi
            return back_with_error('Data yang dimasukkan tidak valid. Silakan periksa kembali.')
                ->withErrors($e->validator);
        } catch (\Illuminate\Database\QueryException $e) {
            // Jika error database (misal: constraint violation)
            return back_with_error('Gagal menyimpan data ke database. Pastikan data tidak duplikat.');
        } catch (\Exception $e) {
            // Jika error umum lainnya
            return back_with_error('Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $event = Event::with(['kategori', 'lingkup'])->findOrFail($id);

        $data = [
            'title' => 'Detail Event: ' . $event->nama_event,
            'event' => $event,
        ];

        return view('dashboard.events.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $event = Event::findOrFail($id);
        $kategoris = $this->eventService->getKategoris();
        $lingkups = $this->eventService->getLingkups();

        $data = [
            'title' => 'Edit Event: ' . $event->nama_event,
            'event' => $event,
            'kategoris' => $kategoris,
            'lingkups' => $lingkups,
        ];

        return view('dashboard.events.form', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $event = Event::findOrFail($id);

            // Validasi input
            $validated = $request->validate([
                'nama_event' => 'required|string|max:255',
                'slug' => 'required|string|max:255|unique:event,slug,' . $id,
                'deskripsi_singkat' => 'nullable|string|max:500',
                'deskripsi' => 'nullable|string',
                'id_kategori_event' => 'required|exists:kategori_event,id',
                'id_range_event' => 'required|exists:range_event,id',
                'tanggal_mulai' => 'required|date',
                'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
                'batas_pendaftaran' => 'required|date|before_or_equal:tanggal_mulai',
                'batas_submission' => 'nullable|date|before_or_equal:tanggal_mulai',
                'jam_mulai' => 'required|date_format:H:i',
                'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
                'lokasi' => 'required|string|max:255',
                'alamat_lengkap' => 'nullable|string',
                'is_online' => 'nullable|boolean',
                'platform_online' => 'nullable|string|max:255',
                'link_event' => 'nullable|url',
                'status' => 'required|in:draft,published,cancelled',
                'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            // Handle file upload
            if ($request->hasFile('banner_image')) {
                // Delete old image if exists
                if ($event->banner_image && file_exists(public_path($event->banner_image))) {
                    unlink(public_path($event->banner_image));
                }

                $file = $request->file('banner_image');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads/events'), $filename);
                $validated['banner_image'] = 'uploads/events/' . $filename;
            }

            // Update data
            $event->update($validated);

            return redirect_with_success('events.index', 'Event "' . $event->nama_event . '" berhasil diperbarui!');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect_with_error('events.index', 'Event tidak ditemukan.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back_with_error('Data yang dimasukkan tidak valid. Silakan periksa kembali.')
                ->withErrors($e->validator);
        } catch (\Illuminate\Database\QueryException $e) {
            return back_with_error('Gagal memperbarui data ke database. Pastikan data tidak duplikat.');
        } catch (\Exception $e) {
            return back_with_error('Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $event = Event::findOrFail($id);
            $namaEvent = $event->nama_event;

            // Delete banner image if exists
            if ($event->banner_image && file_exists(public_path($event->banner_image))) {
                unlink(public_path($event->banner_image));
            }

            // Check if event has participants
            // Uncomment when Participant model is ready
            // if ($event->participants()->count() > 0) {
            //     return back_with_error('Event "' . $namaEvent . '" tidak dapat dihapus karena sudah memiliki peserta!');
            // }

            $event->delete();

            return redirect_with_success('events.index', 'Event "' . $namaEvent . '" berhasil dihapus!');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect_with_error('events.index', 'Event tidak ditemukan.');
        } catch (\Illuminate\Database\QueryException $e) {
            return back_with_error('Gagal menghapus event dari database. Data mungkin masih digunakan oleh data lain.');
        } catch (\Exception $e) {
            return back_with_error('Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }

    /**
     * Get events data for AJAX requests
     */
    public function getEvents()
    {
        $events = Event::where('status', 'published')
            ->select('id', 'nama_event', 'slug', 'tanggal_mulai', 'tanggal_selesai')
            ->get();

        return response()->json($events);
    }

    /**
     * Toggle status aktif/nonaktif
     */
    public function toggleStatus(string $id)
    {
        try {
            $event = Event::findOrFail($id);

            $newStatus = $event->status === 'published' ? 'draft' : 'published';

            $event->update(['status' => $newStatus]);

            $statusText = $newStatus === 'published' ? 'dipublikasikan' : 'dijadikan draft';

            return back_with_success("Event \"{$event->nama_event}\" berhasil {$statusText}!");
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return back_with_error('Event tidak ditemukan.');
        } catch (\Illuminate\Database\QueryException $e) {
            return back_with_error('Gagal mengubah status event di database.');
        } catch (\Exception $e) {
            return back_with_error('Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }
}
