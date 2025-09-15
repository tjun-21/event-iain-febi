<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Event;
use App\Models\Requirement;

// load service 
use App\Services\EventServices;
// use App\Services\submittingServices;

class SubmittingController extends Controller
{
    // public $submittingService;
    public $eventService;

    public function __construct()
    {
        // $this->submittingService = new submittingServices;
        $this->eventService = new EventServices;
    }

    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        $user = user_id();
        // dd($user);
        $events = $this->eventService->getDataEventByUser([
            'user_id' => $user
        ]);

        $data = [
            'title' => 'Submitting | List Events',
            'events' => $events,
        ];

        return view('dashboard.submitting.index', $data);
    }

    public function upload(Event $event)
    {
        // dd('test');
        // Load relationships
        $event->load(['kategori', 'requirements']);

        $data = [
            'title' => 'Submit File for Event - ' . $event->nama_event,
            'event' => $event,
        ];

        return view('dashboard.submitting.upload', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($slug)
    {
        // dd($slug);
        // dd(user_id());
        $event = $this->eventService->getDataUserByEventPeserta([
            'slug' => $slug,
            'user_id' => user_id()
        ]);
        // dd($event);
        // Cek apakah user sudah submit file untuk event ini
        $submittedFile = null;
        $alreadySubmitted = false;
        if ($event && user_id()) {
            $submittedFile = \App\Models\File::where('id_event_peserta', $event->id_event_peserta)
                ->latest('created_at')
                ->first();
            $alreadySubmitted = $submittedFile ? true : false;
        }
        // dd($submittedFile);
        $data = [
            'title' => 'Submitting File: ',
            'event' => $event,
            'alreadySubmitted' => $alreadySubmitted,
            'submittedFile' => $submittedFile,
        ];
        return view('dashboard.submitting.show', $data);
        // return view('dashboard.submitting.show', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());

        // dd($validated);
        try {
            // Validasi input file dokumen
            $validated = $request->validate([
                'id_event_peserta' => 'required|exists:event_peserta,id',
                'file' => 'required|file|mimes:pdf,jpg,jpeg,png,docx,zip|max:10240', // 10MB = 10240KB
            ]);
            // Handle file upload
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads/submissions'), $filename);
                $validated['file_path'] = 'uploads/submissions/' . $filename;
            }

            // Simpan data ke model File
            \App\Models\File::create([
                'id_event_peserta' => $validated['id_event_peserta'],
                'file_path' => $validated['file_path'],
                'original_name' => $file->getClientOriginalName(),
            ]);

            // Ambil slug event dari event_peserta
            $eventPeserta = \App\Models\EventPeserta::find($validated['id_event_peserta']);
            $event = $eventPeserta ? \App\Models\Event::find($eventPeserta->id_event) : null;
            $slug = $event ? $event->slug : null;
            if ($slug) {
                return redirect()->route('submitting.create', $slug)
                    ->with('success', 'Dokumen berhasil diupload!');
            } else {
                return back()->with('success', 'Dokumen berhasil diupload!');
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back_with_error('File tidak valid atau melebihi 10MB.')
                ->withErrors($e->validator);
        } catch (\Exception $e) {
            return back_with_error('Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $event = $this->eventService->getData($id);

        // Get requirements for this event
        $requirements = Requirement::where('event_id', $id)
            ->orderBy('created_at', 'asc')
            ->get();

        $data = [
            'title' => 'Detail Event: ' . ($event ? $event->nama_event : 'Event'),
            'event' => $event,
            'requirements' => $requirements,
        ];

        return view('dashboard.events.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */

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
                'deskripsi' => 'nullable|string',
                'id_kategori_event' => 'required|exists:kategori_event,id',
                'id_range_event' => 'required|exists:range_event,id',
                'tanggal_mulai' => 'required|date',
                'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
                'batas_pendaftaran' => 'required|date',
                'batas_submission' => 'nullable|date',
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
