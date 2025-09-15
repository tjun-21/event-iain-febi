<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Event;
use App\Models\Peserta;

// load service 
use App\Services\EventServices;
use App\Services\ParticipantsServices;

class ParticipantsController extends Controller
{
    public $eventService;
    public $participantsService;

    public function __construct()
    {
        $this->eventService = new EventServices;
        $this->participantsService = new ParticipantsServices;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = $this->eventService->getData();

        $data = [
            'title' => 'Manajemen Participants',
            'events' => $events,
        ];

        return view('dashboard.participants.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */


    /**
     * Display the specified resource.
     */


    public function list(string $slug)
    {
        // dd($slug);
        $listPeserta = $this->participantsService->getData([
            'slug' => $slug
        ]);

        $data = [
            'title' => 'List Participants: ',
            'list' => $listPeserta,
        ];

        return view('dashboard.participants.list', $data);
    }

    public function show($event, $participant)
    {
        // dd($event, $participant);
        // Ambil data event jika perlu
        $eventData = Event::where('slug', $event)->firstOrFail();
        // dd($eventData);
        // Ambil data peserta yang ikut event tersebut
        $peserta = $this->participantsService->getDetailParticipant([
            'id' => $participant
        ]);
        // dd($peserta);
        // $peserta = Peserta::findOrFail($participant);

        $data = [
            'event' => $eventData,
            'peserta' => $peserta
        ];
        // Kirim ke view detail peserta
        return view('dashboard.participants.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id) {}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $request->validate([
                'status' => 'required|in:registered,confirmed,cancelled',
            ]);
            // Update status pada tabel event_peserta
            $eventPeserta = \App\Models\EventPeserta::where('id_peserta', $id)->firstOrFail();
            $eventPeserta->status = $request->status;
            $eventPeserta->tanggal_konfirmasi = now();
            $eventPeserta->save();

            return redirect()->back()->with('success', 'Status registrasi peserta berhasil diperbarui!');
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


            return redirect_with_success('events.index', 'Event "' .  '" berhasil dihapus!');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect_with_error('events.index', 'Event tidak ditemukan.');
        } catch (\Illuminate\Database\QueryException $e) {
            return back_with_error('Gagal menghapus event dari database. Data mungkin masih digunakan oleh data lain.');
        } catch (\Exception $e) {
            return back_with_error('Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }
}
